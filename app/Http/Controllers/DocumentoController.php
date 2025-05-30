<?php

namespace App\Http\Controllers;

use App\Services\DocumentoService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Jobs\DeleteOldLogs;
use Log;
use PhpParser\NodeVisitor\CommentAnnotatingVisitor;

class DocumentoController extends Controller
{

	protected $documento;

	public function __construct(DocumentoService $documento)
	{
		$this->documento = $documento;
	}

	public function downloadManual()
	{
		try {
			return response()->file(Storage::path('public/documentos/manual.pdf'));
		} catch (Exception $e) {
			Log::error('Houve um erro inesperado ao fazer o download do anexo selecionado.', ['error' => $e->getMessage()]);
			return redirect()->back()->with('error', 'Houve um erro inesperado ao fazer o download do anexo selecionado. Tente novamente.');
		}
	}

	public function showSystemPage()
	{
		return view('links_login.apresentacao');
	}

	public function showLegPage()
	{
		return view('links_login.legislacao');
	}

	public function eixos()
	{
		return view('eixos');
	}

	public function intro()
	{
		DeleteOldLogs::dispatch();
		return view('links_login.intro');
	}

	public function downloadAvaliacao()
	{
		try {
			return response()->file(storage_path('app/public/documentos/diagnosticoRiscos.pdf'));
		} catch (Exception $e) {
			Log::error('Houve um erro ao realizar o download do documento selecionado.', ['error' => $e->getMessage()]);
			return redirect()->back()->with('error', 'Houve um erro inesperado ao fazer o download do documento selecionado. Tente novamente.');
		}
	}

	public function create()
	{
		$tiposDocumentos = $this->documento->getAllTiposDocumentos();
		return view('documentos.create', compact('tiposDocumentos'));
	}

	public function edit($id)
	{
		$documento = $this->documento->getDocumentoById($id);
		$tiposDocumentos = $this->documento->getAllTiposDocumentos();

		if (!$documento) {
			return redirect()->back()->with('error', 'Documento não encontrado.');
		}

		return view('documentos.edit', compact('documento', 'tiposDocumentos'));
	}

	public function historico()
	{
		$tiposDocumentos = $this->documento->getAllTiposDocumentos();
		$documentosAgrupados = $this->documento->getDocumentosAgrupadosPorTipoEAno();

		return view('historico', compact('tiposDocumentos', 'documentosAgrupados'));
	}


	public function store(Request $request)
	{
		$validated = $request->validate([
			'ano' => 'required|integer',
			'tipo_id' => 'required|exists:tipos_documentos,id',
			'path' => 'required|file|mimes:pdf,doc,docx,zip,png,jpg,jpeg',
		]);
		try {
			$this->documento->insertDocumento($validated);
			return redirect()->route('documentos.historico')->with('success', 'Documento cadastrado com sucesso.');
		} catch (Exception $e) {
			Log::error('Erro ao cadastrar documento', ['error' => $e->getMessage()]);
			return redirect()->route('documentos.historico')->with('error', 'Erro ao cadastrar documento.');
		}
	}


	public function update(Request $request, $id)
	{
		$validated = $request->validate([
			'ano' => 'required|integer',
			'tipo_id' => 'required|exists:tipos_documentos,id',
			'path' => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg,jpeg',
		]);

		try {
			$this->documento->updateDocumento($id, $validated);
			return redirect()->route('documentos.historico')->with('success', 'Documento atualizado com sucesso.');
		} catch (Exception $e) {
			Log::error('Erro ao atualizar documento', ['error' => $e->getMessage()]);
			return redirect()->route('documentos.historico')->with('error', 'Erro ao atualizar documento.');
		}
	}


	public function destroy($id)
	{
		try {
			$this->documento->deleteDocumento($id);
			return redirect()->back()->with('success', 'Documento deletado com sucesso.');
		} catch (Exception $e) {
			Log::error('Erro ao deletar documento', ['error' => $e->getMessage()]);
			return redirect()->back()->with('error', 'Erro ao deletar documento.');
		}
	}


}
