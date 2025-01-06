<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Currency;
use App\Models\Executive;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $year = Carbon::now()->year;

        $allocations = Allocation::get();
        $allocations_count = $allocations->count();
        $total_amount_sub = Allocation::query()->whereYear('date_allocation','<', $year)->sum('amount');
        $total_amount = Allocation::query()->whereYear('date_allocation', $year)->sum('amount');
        $total_amount_received = Allocation::query()->sum('amount_received');

        $executives = Executive::get();
        $executives_count = $executives->count();
        // $executives->whereYear('implementation_date', $request->year);
        $total_ils_sub = Executive::query()->whereYear('implementation_date','<', $year)->sum('total_ils');
        $total_ils = Executive::query()->whereYear('implementation_date', $year)->sum('total_ils');
        $total_amount_payments = Executive::query()->whereYear('implementation_date', $year)->sum('amount_payments');

        $ILS = Currency::where('code', 'ILS')->first()->value;
        return view('index',compact('allocations_count','total_amount_sub','total_amount','total_amount_received','executives_count','total_ils','total_ils_sub','total_amount_payments','ILS'));
    }
}
