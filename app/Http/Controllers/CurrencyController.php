<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Currency::class);
        $currencies = Currency::get();
        return view('dashboard.pages.currencies', compact('currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Currency::class);
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'value' => 'required|numeric',
        ]);

        Currency::create($request->all());
        return redirect()->route('currencies.index')->with('success', 'تمت إنشاء العملة بنجاح');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        $this->authorize('update', $currency);
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'value' => 'required|numeric',
        ]);

        $currency->update($request->all());
        return redirect()->route('currencies.index')->with('success', 'تمت تعديل العملة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        $this->authorize('delete', $currency);
        $currency->delete();
        return redirect()->route('currencies.index')->with('danger', 'تم حذف العملة بنجاح');
    }
}
