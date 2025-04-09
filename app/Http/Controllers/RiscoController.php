<?php

namespace App\Http\Controllers;

use App\Events\NovaRespostaCriada;
use App\Events\PrazoProximo;
use Illuminate\Http\Request;
use app\Http\Middleware\VerifyCsrfToken;
use App\Mail\ResponseNotification;
use App\Models\Risco;
use App\Models\Unidade;
use App\Models\Monitoramento;
use App\Models\Notification;
use App\Models\Resposta;
use App\Models\Prazo;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use FFI\Exception as FFIException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\Diretoria;





class RiscoController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();
            $prazo = Prazo::latest()->first();
            $user = auth()->user();
            $tipoAcesso = $user->unidade->unidadeTipoFK;
            $unidadeDiretoria = $user->unidade->unidadeDiretoria;

            switch ($tipoAcesso) {
                case 1:
                case 3:
                    $riscos = Risco::all();
                    break;
                case 4:
                    if ($user->usuario_tipo_fk == 1) {
                        $riscos = Risco::all();
                    } else {
                        $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
                    }
                    break;
                case 5:
                    if ($user->usuario_tipo_fk == 2) {
                        $riscos = Risco::whereHas('unidade', function ($query) use ($unidadeDiretoria) {
                            $query->where('unidadeDiretoria', $unidadeDiretoria);
                        })->get();
                    } else {
                        $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
                    }
                    break;
                default:
                    $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
                    break;
            }

            $riscosAbertos = $riscos->count();

            $riscosAbertosHoje = Risco::whereDate('created_at', \Carbon\Carbon::today())->count();

            $notificacoes = $this->filtraNotificacoes();

            $notificacoesNaoLidas = $notificacoes->whereNull('read_at');
            $notificacoesLidas = $notificacoes->whereNotNull('read_at');
            $unidades = Unidade::all();

            return view('riscos.index', [
                'riscos' => $riscos,
                'prazo' => $prazo ? $prazo->data : null,
                'riscosAbertos' => $riscosAbertos,
                'riscosAbertosHoje' => $riscosAbertosHoje,
                'notificacoes' => $notificacoes,
                'notificacoesNaoLidas' => $notificacoesNaoLidas,
                'notificacoesLidas' => $notificacoesLidas,
                'unidades' => $unidades
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao carregar os riscos. Por favor, tente novamente.']);
        }
    }

    public function analise()
    {

        try {
            $user = auth()->user();
            $prazo = Prazo::latest()->first();
            $user = auth()->user();
            $tipoAcesso = $user->unidade->unidadeTipoFK;
            $unidadeDiretoria = $user->unidade->unidadeDiretoria;

            // switch ($tipoAcesso) {
            //     case 1:
            //     case 3:
            //     case 4:
            //         $riscos = Risco::all();
            //         break;
            //     case 5:
            //         $riscos = Risco::whereHas('unidade', function ($query) use ($unidadeDiretoria) {
            //             $query->where('unidadeDiretoria', $unidadeDiretoria);
            //         })->get();
            //         break;
            //     default:
            //         $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
            //         break;
            // }

            switch ($tipoAcesso) {
                case 1:
                case 3:
                    $riscos = Risco::all();
                    break;
                case 4:
                    if ($user->usuario_tipo_fk == 1) {
                        $riscos = Risco::all();
                    } else {
                        $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
                    }
                    break;
                case 5:
                    if ($user->usuario_tipo_fk == 2) {
                        $riscos = Risco::whereHas('unidade', function ($query) use ($unidadeDiretoria) {
                            $query->where('unidadeDiretoria', $unidadeDiretoria);
                        })->get();
                    } else {
                        $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
                    }
                    break;
                default:
                    $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
                    break;
            }

            $riscosAbertos = $riscos->count();
            $riscosAbertosHoje = Risco::whereDate('created_at', \Carbon\Carbon::today())->count();
            $notificacoes = $this->filtraNotificacoes();
            $notificacoesNaoLidas = $notificacoes->whereNull('read_at');
            $notificacoesLidas = $notificacoes->whereNotNull('read_at');

            $unidades = Unidade::all();

            return view('riscos.analise', [
                'riscos' => $riscos,
                'prazo' => $prazo ? $prazo->data : null,
                'riscosAbertos' => $riscosAbertos,
                'riscosAbertosHoje' => $riscosAbertosHoje,
                'notificacoes' => $notificacoes,
                'notificacoesNaoLidas' => $notificacoesNaoLidas,
                'notificacoesLidas' => $notificacoesLidas,
                'unidades' => $unidades
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao carregar os riscos. Por favor, tente novamente.']);
        }
    }



    public function markAsRead(Request $request)
    {
        $notificationIds = $request->input('notification_ids');

        if ($notificationIds) {
            Notification::whereIn('id', $notificationIds)->update(['read_at' => now()]);
            return redirect()->route('riscos.index')->with('success', 'Notificações marcadas como lidas com sucesso.');
        }

        return redirect()->route('riscos.index')->with('error', 'Erro ao marcar notificações como lidas.');
    }



    private function filtraNotificacoes()
    {
        try {
            $user = auth()->user();

            if (!$user->unidade || !$user->unidade->unidadeTipo) {
                Log::info('Usuário não possui uma unidade ou tipo de unidade associada', ['user_id' => $user->id]);
                return collect();
            }

            $unidadeTipo = $user->unidade->unidadeTipo->id;

            switch ($unidadeTipo) {
                case 1:
                    $notificacoes = Notification::where('global', false)
                        ->where('user_id', $user->id)
                        ->get();
                    break;

                case 2:
                    $notificacoes = Notification::where('global', false)
                        ->where('user_id', $user->id)
                        ->whereHas('monitoramento.risco.unidade', function ($query) use ($user) {
                            $query->where('unidadeId', $user->unidade->id);
                        })
                        ->get();
                    break;

                default:
                    Log::info('Tipo de unidade não reconhecido', ['user_id' => $user->id, 'unidade_tipo' => $unidadeTipo]);
                    return collect();
            }

            return $notificacoes;
        } catch (Exception $e) {
            Log::error('Erro ao filtrar notificações', ['error' => $e->getMessage()]);
            return collect();
        }
    }








    public function show($id)
    {
        try {
            $risco = Risco::with(['monitoramentos'])->findOrFail($id);
            return view('riscos.show', [
                'risco' => $risco,
                'monitoramentos' => $risco->monitoramentos
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao carregar os dados do risco.']);
        }
    }


    public function create()
    {
        $unidades = Unidade::all();
        return view('riscos.store', ['unidades' => $unidades]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'responsavelRisco' => 'required',
                'riscoEvento' => 'max:9000',
                'riscoCausa' => 'max:9000',
                'riscoConsequencia' => 'max:9000',
                'riscoAno' => 'required',
                'probabilidade' => 'required|integer',
                'impacto' => 'required|integer',
                'nivel_de_risco' => 'required|integer',
                'unidadeId' => 'required|exists:unidades,id',
                'monitoramentos' => 'required|array|min:1',
                'monitoramentos.*.monitoramentoControleSugerido' => 'max:9000',
                'monitoramentos.*.statusMonitoramento' => 'required|string',
                'monitoramentos.*.inicioMonitoramento' => 'required|date',
                'monitoramentos.*.fimMonitoramento' => 'nullable|date|after:monitoramentos.*.inicioMonitoramento',
                'monitoramentos.*.isContinuo' => 'required|boolean',
                'monitoramentos.*.anexoMonitoramento' => 'nullable|file|mimes:jpeg,png,pdf|max:51200'
            ]);

            $probabilidade = isset($validatedData['probabilidade']) ? (int) $validatedData['probabilidade'] : 0;
            $impacto = isset($validatedData['impacto']) ? (int) $validatedData['impacto'] : 0;
            
            $valor_nivel_de_risco = $probabilidade * $impacto;
            
            if ($valor_nivel_de_risco >= 15) {
                $nivel_de_risco = 3; 
            } elseif ($valor_nivel_de_risco >= 5) {
                $nivel_de_risco = 2; 
            } elseif ($valor_nivel_de_risco > 0) {
                $nivel_de_risco = 1; 
            } else {
                $nivel_de_risco = 0; 
            }
            

            // Criação do risco
            $risco = Risco::create([
                'responsavelRisco' => $validatedData['responsavelRisco'],
                'riscoEvento' => $validatedData['riscoEvento'],
                'riscoCausa' => $validatedData['riscoCausa'],
                'riscoConsequencia' => $validatedData['riscoConsequencia'],
                'probabilidade' => $probabilidade,
                'impacto' => $impacto,
                'nivel_de_risco' => $nivel_de_risco,
                'riscoAno' => $validatedData['riscoAno'],
                'userIdRisco' => auth()->id(),
                'unidadeId' => $validatedData['unidadeId']
            ]);

            foreach ($validatedData['monitoramentos'] as $index => $monitoramentoData) {
                $isContinuo = filter_var($monitoramentoData['isContinuo'], FILTER_VALIDATE_BOOLEAN);

                if (!$isContinuo && isset($monitoramentoData['fimMonitoramento']) && $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']) {
                    throw new \Exception('Fim do monitoramento não pode ser anterior ao início do monitoramento.');
                }


                $monitoramento = Monitoramento::create([
                    'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                    'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                    'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                    'fimMonitoramento' => $monitoramentoData['fimMonitoramento'] ?? null,
                    'isContinuo' => $isContinuo,
                    'riscoFK' => $risco->id,
                ]);
            }

            return redirect()->route('riscos.index')->with('success', 'Risco criado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar risco: ' . $e->getMessage());
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao criar o risco. Por favor, tente novamente.'])->withInput();
        }
    }


    public function edit($id)
    {
        $unidades = Unidade::all();
        $risco = Risco::findOrFail($id);
        return view('riscos.edit', ['risco' => $risco, 'unidades' => $unidades]);
    }

    public function update(Request $request, $id)
    {
        try {
            $risco = Risco::findOrFail($id);

            $risco->update($request->all());

            return redirect()->route('riscos.show', ['id' => $risco->id])->with('success', 'Risco editado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao atualizar o risco.']);
        }
    }

    public function editMonitoramentos($id)
    {
        $risco = Risco::findOrFail($id);
        return view('riscos.monitoramentos', compact('risco'));
    }

    public function editMonitoramento2($id)
    {
        $monitoramento = Monitoramento::findOrFail($id);


        Log::info('Editando monitoramento:', [
            'monitoramento' => $monitoramento->toArray(),
        ]);

        return view('riscos.editMonitoramento', [
            'monitoramento' => $monitoramento,
        ]);
    }




    public function insertMonitoramentos(Request $request, $id)
    {
        $risco = Risco::findOrFail($id);

        try {
            $validatedData = $request->validate([
                'monitoramentos' => 'required|array',
                'monitoramentos.*.monitoramentoControleSugerido' => 'max:9000',
                'monitoramentos.*.statusMonitoramento' => 'max:9000',
                'monitoramentos.*.inicioMonitoramento' => 'required|date',
                'monitoramentos.*.fimMonitoramento' => 'nullable|date|after_or_equal:inicioMonitoramento',
                'monitoramentos.*.isContinuo' => 'required|boolean',
                'monitoramentos.*.anexoMonitoramento' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:51200',
            ]);

            foreach ($validatedData['monitoramentos'] as $index => $monitoramentoData) {
                $isContinuo = filter_var($monitoramentoData['isContinuo'], FILTER_VALIDATE_BOOLEAN);

                if (!$isContinuo && isset($monitoramentoData['fimMonitoramento']) && $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']) {
                    throw new \Exception('Fim do monitoramento não pode ser anterior ao início do monitoramento.');
                }

                $monitoramento = Monitoramento::create([
                    'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                    'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                    'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                    'fimMonitoramento' => $monitoramentoData['fimMonitoramento'] ?? null,
                    'isContinuo' => $isContinuo,
                    'riscoFK' => $risco->id,
                ]);
            }

            return redirect()->route('riscos.show', ['id' => $risco->id])
                ->with('success', 'Controles Sugeridos inseridos com sucesso');
        } catch (\Exception $e) {
            Log::error('Error inserting Controles Sugeridos:', [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withErrors(['errors' => 'Houve um erro ao inserir Controles Sugeridos']);
        }
    }

    public function atualizaMonitoramento(Request $request, $id)
    {
        try {
            $request->validate([
                'monitoramentoControleSugerido' => 'required|string',
                'statusMonitoramento' => 'required|string',
                'isContinuo' => 'required|boolean',
                'inicioMonitoramento' => 'required|date',
                'fimMonitoramento' => 'nullable|date|after_or_equal:inicioMonitoramento',
                'anexoMonitoramento' => 'nullable|file|mimes:jpeg,png,pdf|max:51200'
            ]);

            $monitoramento = Monitoramento::findOrFail($id);

            $monitoramento->update([
                'monitoramentoControleSugerido' => $request->input('monitoramentoControleSugerido'),
                'statusMonitoramento' => $request->input('statusMonitoramento'),
                'isContinuo' => $request->input('isContinuo'),
                'inicioMonitoramento' => $request->input('inicioMonitoramento'),
                'fimMonitoramento' => $request->input('fimMonitoramento'),
            ]);

            Log::info('Monitoramento atualizado:', $monitoramento->toArray());


            Log::info('Atualização de controle sugerido concluída com sucesso.');

            return redirect()->route('riscos.show', ['id' => $monitoramento->riscoFK])
                ->with('success', 'Controle Sugerido atualizado com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erro de validação ao atualizar controle sugerido:', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Controle Sugerido não encontrado:', ['id' => $id]);
            return redirect()->route('riscos.index')->with('error', 'Controle Sugerido não encontrado.');
        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            Log::error('Erro ao tentar excluir o anexo antigo:', ['path' => $monitoramento->anexoMonitoramento]);
            return back()->with('error', 'Erro ao tentar excluir o anexo antigo. Por favor, tente novamente.');
        } catch (\Exception $e) {
            Log::error('Erro inesperado ao atualizar controle sugerido:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Ocorreu um erro inesperado. Por favor, tente novamente.')->withInput();
        }
    }




    public function delete($id)
    {
        $risco = Risco::findorFail($id);

        $deleteRisco = $risco->delete();

        if (!$deleteRisco) {
            return redirect()->back()->withErrors(['errors' => 'Houve um erro ao deletar o risco']);
        }

        return redirect()->back()->with(['success' => 'Risco Deletado com sucesso']);
    }

    public function deleteMonitoramento($id)
    {
        $monitoramento = Monitoramento::findOrFail($id);

        try {
            $deleteMonitoramento = $monitoramento->delete();

            if (!$deleteMonitoramento) {
                return redirect()->back()->withErrors(['errors' => 'Houve um erro ao deletar o controle sugerido']);
            }

            return redirect()->back()->with(['success' => 'Controle Sugerido deletado com sucesso']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }


    private function sendEmail(Resposta $resposta, Monitoramento $monitoramento, Notification $notification)
    {
        try {
            if ($resposta) {
                $users = User::all();
                Mail::to(auth()->user())->send(new ResponseNotification($notification, $monitoramento));
            }
        } catch (Exception $e) {
            Log::error('Houve um erro ao enviar um email: ' . $e->getMessage());
            throw new Exception('Houve um erro ao enviar o email');
        }
    }


    public function storeResposta(Request $request, $id)
    {
        $monitoramento = Monitoramento::findOrFail($id);
        $risco = Risco::findOrFail($monitoramento->riscoFK);

        try {
            Log::info('Storing resposta for monitoramento', ['monitoramento_id' => $monitoramento->id]);

            $request->validate([
                'respostaRisco' => 'required|string|max:5000',
                'anexo' => 'nullable|file|mimes:jpg,png,pdf|max:102400'
            ]);

            $filePath = null;
            if ($request->hasFile('anexo')) {
                $filePath = $request->file('anexo')->store('anexos', 'public');
                Log::info('File uploaded', ['file_path' => $filePath]);
            } else {
                Log::info('No file uploaded');
            }

            $resposta = Resposta::create([
                'respostaRisco' => $request->respostaRisco,
                'respostaMonitoramentoFk' => $monitoramento->id,
                'user_id' => auth()->id(),
                'anexo' => $filePath
            ]);

            $monitoramento->update([
                'statusMonitoramento' => $request->input('statusMonitoramento')
            ]);

            Log::info('Updated statusMonitoramento', [
                'monitoramento_id' => $monitoramento->id,
                'new_status' => $monitoramento->statusMonitoramento
            ]);

            Log::info('Resposta created', ['resposta_id' => $resposta->id]);


            $allUsers = User::all();

            Log::info('Attaching notification to users', ['user_count' => $allUsers->count()]);

            foreach ($allUsers as $user) {
                $formattedDateTime = Carbon::parse($resposta->created_at)->format('d/m/Y \à\s H:i');
                $message = '<div><span>Nova mensagem!</span><br><br><div><span>Usuário: </span>' . htmlspecialchars($user->name) . '</div>' .
                    '<div><span>Unidade: </span>' . ($user->unidade ? htmlspecialchars($user->unidade->unidadeNome) : 'Desconhecida') . '</div>' .
                    '<div><span>Data do envio: </span>' . htmlspecialchars($formattedDateTime) . '</div><br>' .
                    '</div>';

                $notification = Notification::create([
                    'message' => $message,
                    'global' => false,
                    'monitoramentoId' => $monitoramento->id,
                    'user_id' => $user->id
                ]);

                Log::info('Notification created', ['notification_id' => $notification->id, 'user_id' => $user->id]);
            }



            return redirect()->route('riscos.respostas', $id)->with('success', 'Respostas adicionadas com sucesso');
        } catch (Exception $e) {
            Log::error('Error storing resposta', [
                'error' => $e->getMessage(),
                'monitoramento_id' => $monitoramento->id
            ]);
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }





    public function updateResposta(Request $request, $id)
    {

        $request->validate([
            'respostaRisco' => 'required|string|max:5000',
            'anexo' => 'nullable|file|mimes:jpg,png,pdf|max:102400',
        ]);

        try {

            $resposta = Resposta::findOrFail($id);
            $monitoramento = Monitoramento::findOrFail($resposta->respostaMonitoramentoFk);


            $resposta->respostaRisco = $request->input('respostaRisco');


            if ($request->hasFile('anexo')) {
                if ($resposta->anexo) {
                    Storage::disk('public')->delete($resposta->anexo);
                }

                $resposta->anexo = $request->file('anexo')->store('anexos', 'public');
            }


            if ($monitoramento && $request->filled('statusMonitoramento')) {
                $monitoramento->update([
                    'statusMonitoramento' => $request->input('statusMonitoramento')
                ]);
            }

            $resposta->save();

            return redirect()->route('riscos.respostas', ['id' => $resposta->respostaMonitoramentoFk])
                ->with('success', 'Resposta atualizada com sucesso!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['error' => 'Resposta não encontrada.']);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar a resposta: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Ocorreu um erro ao atualizar a resposta. Por favor, tente novamente.']);
        }
    }

    public function deleteAnexo(Request $request, $id)
    {
        try {
            Log::info('Attempting to delete anexo for Resposta with ID: ' . $id);

            $resposta = Resposta::findOrFail($id);

            if ($resposta->anexo) {
                Log::info('Anexo found: ' . $resposta->anexo . ' for Resposta ID: ' . $id);

                Storage::disk('public')->delete($resposta->anexo);

                $resposta->anexo = null;
                $resposta->save();

                Log::info('Anexo deleted and Resposta updated for ID: ' . $id);
            } else {
                Log::info('No anexo found for Resposta ID: ' . $id);
            }

            return redirect()->back()->with('success', 'Anexo deletado com sucesso');
        } catch (Exception $e) {

            Log::error('Error deleting anexo for Resposta ID: ' . $id . '. Error: ' . $e->getMessage());

            return redirect()->back()->with('errors', 'Houve um erro ao deletar o anexo selecionado');
        }
    }


    public function respostas($id)
    {
        $monitoramento = Monitoramento::with('respostas')->findorFail($id);
        $respostas = Resposta::where('respostaMonitoramentoFK', $monitoramento->id)->get();
        return view('riscos.respostas', ['monitoramento' => $monitoramento, 'respostas' => $respostas]);
    }

    public function homologar($id)
    {
        try {
            $resposta = Resposta::findOrFail($id);
            $user = Auth::user();
            $nome = $user->name;
            $cpf = $user->cpf;
            $cpfMascarado = substr($cpf, 0, 3) . '.***.***-' . substr($cpf, -2); // Mascarando o CPF

            $dataHora = now()->format('d-m-Y H:i:s');
            $dataConcat = "Homologado em {$dataHora} pelo usuário de {$nome}, id {$user->id} e cpf {$cpfMascarado}";

            $mensagem = '';
            if ($user->usuario_tipo_fk == 2) {
                if ($resposta->homologadoDiretoria === null) {
                    $resposta->homologadoDiretoria = $dataConcat;
                    $mensagem = 'Resposta homologada com sucesso pela diretoria!';
                } else {
                    return redirect()->back()->with('error', 'A providência já está homologada pela diretoria.');
                }

            } elseif ($user->usuario_tipo_fk == 1) {
                if ($resposta->homologadaPresidencia === null) {
                    $resposta->homologadaPresidencia = $dataConcat;
                    $mensagem = 'Resposta homologada com sucesso pela presidência!';
                } else {
                    return redirect()->back()->with('error', 'A providência já está homologada pela presidência.');
                }

            } else {
                return redirect()->back()->with('error', 'Você não tem permissão para homologar.');
            }

            if (!empty($resposta->homologadoDiretoria) && !empty($resposta->homologadaPresidencia)) {
                $resposta->homologacaoCompleta = true;
            }

            $resposta->save();

            return redirect()->back()->with('success', $mensagem)->with('homologacao', $dataConcat);

        } catch (Exception $e) {
            Log::error('Erro ao homologar resposta: ' . $e->getMessage(), [
                'id' => $id,
                'stack' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Ocorreu um erro ao tentar homologar a resposta. Tente novamente.');
        }
    }



    public function insertPrazo(Request $request)
    {
        try {
            $request->validate([
                'data' => 'required|date'
            ]);

            $prazoExistente = Prazo::first();

            if ($prazoExistente) {
                $prazoExistente->delete();
            }

            $novoPrazo = Prazo::create([
                'data' => $request->data
            ]);

            if (!$novoPrazo) {
                return redirect()->back()->with('error', 'Erro ao inserir um Prazo');
            }

            event(new PrazoProximo($novoPrazo));

            return redirect()->back()->with('success', 'Prazo Inserido com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Um erro ocorreu: ' . $e->getMessage());
        }
    }

    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('checkAccess');
    }
}
