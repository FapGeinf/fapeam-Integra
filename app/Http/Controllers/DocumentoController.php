<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Jobs\DeleteOldLogs;

class DocumentoController extends Controller
{
	public function downloadManual()
	{
		return response()->file(Storage::path('public/documentos/manual.pdf'));
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
		return response()->file(storage_path('app/public/documentos/diagnosticoRiscos.pdf'));
	}


}
