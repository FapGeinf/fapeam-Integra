<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Jobs\DeleteOldLogs;
use Log;

class DocumentoController extends Controller
{
	public function downloadManual()
	{
		try {
			return response()->file(Storage::path('public/documentos/manual.pdf'));
		} catch (Exception $e) {
            Log::error('Houve um erro inesperado ao fazer o download do anexo selecionado.',['error' => $e->getMessage()]);
			return redirect()->back()->with('error','Houve um erro inesperado ao fazer o download do anexo selecionado. Tente novamente.');
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


}
