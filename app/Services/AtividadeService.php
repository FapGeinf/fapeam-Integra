<?php

namespace App\Services;

use App\Models\Atividade;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\PublicoService;
use App\Services\CanalService;
use App\Services\EixoService;
use App\Services\StatusAtividadeService;
use App\Services\IndicadorService;
use App\Services\MedidaTipoService;

class AtividadeService
{
    protected $canalService;
    protected $eixoService;
    protected $statusAtividadeService;
    protected $indicadorService;
    protected $medidaTipoService;
    protected $publicoService;

    public function __construct(
        PublicoService $publicoService,
        CanalService $canalService,
        EixoService $eixoService,
        StatusAtividadeService $statusAtividadeService,
        IndicadorService $indicadorService,
        MedidaTipoService $medidaTipoService
    ) {
        $this->publicoService = $publicoService;
        $this->canalService = $canalService;
        $this->eixoService = $eixoService;
        $this->statusAtividadeService = $statusAtividadeService;
        $this->indicadorService = $indicadorService;
        $this->medidaTipoService = $medidaTipoService;
    }

    public function indexAtividades($eixo_id)
    {
        $eixoNome = null;
        $atividades = collect();

        if ($eixo_id && in_array($eixo_id, [1, 2, 3, 4, 5, 6, 7])) {
            $eixo = $this->eixoService->findEixoById($eixo_id);
            $eixoNome = $eixo ? $eixo->nome : null;

            $atividades = Atividade::whereHas('eixos', function ($query) use ($eixo_id) {
                $query->where('eixo_id', $eixo_id);
            })->with(['publico', 'canais', 'medida'])->orderBy('data_prevista', 'asc')->get();
        } elseif ($eixo_id == 8) {
            $atividades = Atividade::with(['publico', 'canais', 'medida'])->orderBy('data_prevista', 'asc')->get();
        }

        $publicos = $this->publicoService->indexPublicos();
        $canais = $this->canalService->getAllCanais();
        $statusAtividades = $this->statusAtividadeService->getAllStatusAtividades();

        return [
            'atividades' => $atividades,
            'eixoNome' => $eixoNome,
            'eixo_id' => $eixo_id,
            'publicos' => $publicos,
            'canais' => $canais,
            'statusAtividades' => $statusAtividades
        ];
    }

    public function show($id)
    {
        return Atividade::findOrFail($id);
    }

    public function createFormAtividade()
    {
        $statusAtividades = $this->statusAtividadeService->getAllStatusAtividades();
        $eixos = $this->eixoService->getAllEixos();
        $publicos = $this->publicoService->indexPublicos();
        $canais = $this->canalService->getAllCanais();
        $medidas = $this->medidaTipoService->getAllMedidas();
        $indicadores = $this->indicadorService->getAllIndicadores();

        return [
            'eixos' => $eixos,
            'publicos' => $publicos,
            "canais" => $canais,
            'medidas' => $medidas,
            'indicadores' => $indicadores,
            'statusAtividades' => $statusAtividades
        ];
    }

    public function store(array $data)
    {
        $data = $this->publicoService->handlePublicoId($data);

        Log::info('Criando nova atividade', ['dados' => $data]);

        $atividade = Atividade::create([
            'atividade_descricao' => $data['atividade_descricao'] ?? null,
            'objetivo' => $data['objetivo'] ?? null,
            'responsavel' => $data['responsavel'] ?? null,
            'publico_id' => $data['publico_id'] ?? null,
            'tipo_evento' => $data['tipo_evento'] ?? null,
            'data_prevista' => $data['data_prevista'] ?? null,
            'data_realizada' => $data['data_realizada'] ?? null,
            'meta' => $data['meta'] ?? null,
            'realizado' => $data['realizado'] ?? null,
            'medida_id' => $data['medida_id'] ?? null,
            'justificativa' => $data['justificativa'] ?? null,
            'status_atividade_id' => $data['status_atividade_id'] ?? null
        ]);

        if (!empty($data['eixo_ids'])) {
            Log::info('Associando eixos à atividade', ['eixos' => $data['eixo_ids']]);
            $atividade->eixos()->attach($data['eixo_ids']);
        }

        if (!empty($data['canal_id'])) {
            Log::info('Associando canais à atividade', ['canais' => $data['canal_id']]);
            $atividade->canais()->attach($data['canal_id']);
        }

        if (!empty($data['indicador_ids'])) {
            Log::info('Associando indicadores à atividade', ['indicadores' => $data['indicador_ids']]);
            $atividade->indicadores()->attach($data['indicador_ids']);
        } else {
            $atividade->indicadores()->detach();
        }

        $eixo_id = $atividade->eixos->first()->id ?? null;

        return [
            'eixo_id' => $eixo_id,
            'atividade' => $atividade
        ];
    }

    public function editFormAtividade($id)
    {
        $statusAtividades = $this->statusAtividadeService->getAllStatusAtividades();
        $eixos = $this->eixoService->getAllEixos();
        $publicos = $this->publicoService->indexPublicos();
        $canais = $this->canalService->getAllCanais();
        $medidas = $this->medidaTipoService->getAllMedidas();
        $indicadores = $this->indicadorService->getAllIndicadores();
        $atividade = $this->show($id);

        if (!$atividade) {
            return redirect()->back()->with('error', 'Não foi encontrada a atividade selecionada no sistema.');
        }

        return [
            'eixos' => $eixos,
            'atividade' => $atividade,
            'publicos' => $publicos,
            'canais' => $canais,
            'medidas' => $medidas,
            'indicadores' => $indicadores,
            'statusAtividades' => $statusAtividades
        ];
    }

    public function updateAtividade(int $id, array $data)
    {
        // Utilizando o método criado no PublicoService
        $data = $this->publicoService->handlePublicoId($data);

        $atividade = $this->show($id);

        Log::info('Atualizando a atividade', ['id' => $id, 'dados' => $data]);

        $atividade->update([
            'atividade_descricao' => $data['atividade_descricao'] ?? null,
            'objetivo' => $data['objetivo'] ?? null,
            'responsavel' => $data['responsavel'] ?? null,
            'publico_id' => $data['publico_id'] ?? null,
            'tipo_evento' => $data['tipo_evento'] ?? null,
            'data_prevista' => $data['data_prevista'] ?? null,
            'data_realizada' => $data['data_realizada'] ?? null,
            'meta' => $data['meta'] ?? null,
            'realizado' => $data['realizado'] ?? null,
            'medida_id' => $data['medida_id'] ?? null,
            'justificativa' => $data['justificativa'] ?? null,
            'status_atividade_id' => $data['status_atividade_id'] ?? null,
        ]);

        if (!empty($data['eixo_ids'])) {
            Log::info('Associando eixos à atividade', ['eixos' => $data['eixo_ids']]);
            $atividade->eixos()->sync($data['eixo_ids']);
        }

        if (!empty($data['canal_id'])) {
            Log::info('Associando canais à atividade', ['canais' => $data['canal_id']]);
            $atividade->canais()->sync($data['canal_id']);
        }

        if (!empty($data['indicador_ids'])) {
            Log::info('Associando indicadores à atividade', ['indicadores' => $data['indicador_ids']]);
            $atividade->indicadores()->sync($data['indicador_ids']);
        } else {
            $atividade->indicadores()->detach();
        }

        $eixo_id = $atividade->eixos->first()->id ?? null;

        return [
            'eixo_id' => $eixo_id,
            'atividade' => $atividade
        ];
    }

    public function delete($id)
    {
        $atividade = $this->show($id);

        if (!$atividade) {
            throw new ModelNotFoundException("Atividade com ID {$id} não encontrada.");
        }

        if (!$atividade->delete()) {
            throw new Exception("Erro ao excluir a atividade com ID {$id}.");
        }

        Log::info("Atividade excluída com sucesso", ['atividade_id' => $id]);

        return true;
    }

    public function listarAtividadesPorEixo($eixoId)
    {
        $atividades = Atividade::whereHas('eixos', function ($query) use ($eixoId) {
            $query->where('eixos.id', $eixoId);
        })->with(['publico', 'canais', 'medida'])->orderBy('data_prevista')->get();

        return $atividades;
    }

    public function listarAtividades()
    {
        return Atividade::with('eixos', 'publico', 'canais')->get();
    }


    public function getAtividadesExecutadas()
    {
        return Atividade::whereHas('statusAtividade', function ($query) {
            $query->where('nome', 'Executado'); 
        })->get();
    }

    public function getAtividadesAcompanhamento()
    {
           return Atividade::whereHas('statusAtividade',function($query){
                  $query->where('nome','Acompanhamento');
           })->get();
    }
}