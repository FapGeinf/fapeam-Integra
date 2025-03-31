<?php

namespace App\Services;

use App\Models\Atividade;
use Illuminate\Http\Request;
use App\Models\Eixo;
use App\Models\Publico;
use App\Models\Canal;
use App\Models\MedidaTipo;
use App\Models\Indicador;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\AtividadeRequest;

class AtividadeService
{
    public function indexAtividades($eixo_id)
    {
        $eixoNome = null;

        if ($eixo_id && in_array($eixo_id, [1, 2, 3, 4, 5, 6, 7, 8])) {
            $eixo = Eixo::find($eixo_id);
            $eixoNome = $eixo ? $eixo->nome : null;

            $atividades = Atividade::whereHas('eixos', function ($query) use ($eixo_id) {
                $query->where('eixo_id', $eixo_id);
            })->with(['publico', 'canais', 'medida'])->orderBy('data_prevista', 'asc')->get();
        } else {
            $atividades = Atividade::with(['publico', 'canais', 'medida'])->orderBy('data_prevista', 'asc')->get();
        }

        $publicos = Publico::all();
        $canais = Canal::all();

        return [
            'atividades' => $atividades,
            'eixoNome' => $eixoNome,
            'eixo_id' => $eixo_id,
            'publicos' => $publicos,
            'canais' => $canais
        ];
    }

    public function show($id)
    {
        return Atividade::findOrFail($id);
    }

    public function createFormAtividade()
    {
        $eixos = Eixo::all();
        $publicos = Publico::all();
        $canais = Canal::all();
        $medidas = MedidaTipo::all();
        $indicadores = Indicador::all();

        return [
            'eixos' => $eixos,
            'publicos' => $publicos,
            "canais" => $canais,
            'medidas' => $medidas,
            'indicadores' => $indicadores
        ];
    }

    public function store(array $data)
    {
        if (isset($data['publico_id']) && $data['publico_id'] === 'outros' && !empty($data['novo_publico'])) {
            Log::info('Criando novo público', ['nome' => $data['novo_publico']]);

            $novoPublico = Publico::create(['nome' => $data['novo_publico']]);
            $data['publico_id'] = $novoPublico->id;

            Log::info('Novo público criado com sucesso:', ['id' => $novoPublico->id]);
        }

        Log::info('Criando a atividade', ['dados' => $data]);

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
        $eixos = Eixo::all();
        $publicos = Publico::all();
        $canais = Canal::all();
        $medidas = MedidaTipo::all();
        $indicadores = Indicador::all();
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
            'indicadores' => $indicadores
        ];

    }

    public function updateAtividade(int $id, array $data)
    {
        if (isset($data['publico_id']) && $data['publico_id'] === 'outros' && !empty($data['novo_publico'])) {
            Log::info('Criando novo público', ['nome' => $data['novo_publico']]);

            $novoPublico = Publico::create(['nome' => $data['novo_publico']]);
            $data['publico_id'] = $novoPublico->id;

            Log::info('Novo público criado com sucesso:', ['id' => $novoPublico->id]);
        }

        $atividade = $this->show($id);

        Log::info('Atualizando a atividade', ['dados' => $data]);

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
           return $atividade->delete();
    }


}