<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Currency;
use App\Models\Executive;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $allocations = Allocation::get();
        $allocations_count = $allocations->count();
        $total_amount = $allocations->sum('amount');
        $total_amount_received = $allocations->sum('amount_received');

        $executives = Executive::get();
        $executives_count = $executives->count();
        $total_ils = $executives->sum('total_ils');
        $total_amount_payments = $executives->sum('amount_payments');

        $ILS = Currency::where('code', 'ILS')->first()->value;
        return view('index',compact('allocations_count','total_amount','total_amount_received','executives_count','total_ils','total_amount_payments','ILS'));
    }
}
