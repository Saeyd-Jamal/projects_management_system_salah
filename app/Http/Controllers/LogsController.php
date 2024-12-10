<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs  = Logs::where('created_at', '>=', now()->subDays(30))->orderBy('created_at', 'desc')->paginate(30);
        // scan logs up 30 days
        $oldLogs = Logs::where('created_at', '<', now()->subDays(30))->delete();
        return view('dashboard.pages.logs', compact('logs'));
    }
}
