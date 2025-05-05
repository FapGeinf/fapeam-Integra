<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log as LogModel;

class LogController extends Controller
{
      public function indexLogs()
      {
             $logs = LogModel::orderBy('created_at')->get();
             return view('logs.index',compact('logs'));
      }
}
