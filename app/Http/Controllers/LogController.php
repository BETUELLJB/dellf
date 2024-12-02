<?php
namespace App\Http\Controllers;

use App\Models\Log;

class LogController extends Controller
{
    public function index()
    {
        $logs = Log::latest()->paginate(20); // Recupera os logs com paginação
        return view('logs.index', compact('logs')); // Passa os logs para a view
    }
}
