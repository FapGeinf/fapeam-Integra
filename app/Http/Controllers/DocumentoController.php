<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function downloadManual(){
			return response()->file(Storage::path('public/documentos/manual.pdf'));
		}

		public function showSystemPage(){
			return view('links_login.apresentacao');
		}

		public function showLegPage(){
			return view('links_login.legislacao');
		}

}