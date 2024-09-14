<?php

namespace App\Http\Controllers;

use App\Imports\AllocationsImport;
use App\Models\Allocation;
use App\Models\Broker;
use App\Models\Currency;
use App\Models\Item;
use App\Models\Organization;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AllocationController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Allocation::class);
        $allocations = Allocation::paginate(10);
        
        return view('dashboard.projects.allocations.index', compact('allocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Allocation::class);
        $allocation = new Allocation();

        return view('dashboard.projects.allocations.create', compact('allocation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Allocation::class);
        $request->validate([
            'date_allocation' => 'required|date',
            'budget_number' => 'required|integer',
            'quantity' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'total_dollar' => 'nullable|numeric',
            'allocation' => 'nullable|numeric',
            'currency_allocation' => 'required|exists:currencies,code',
            'amount' => 'nullable|numeric',
            'implementation_items' => 'nullable|string',
            'date_implementation' => 'nullable|date',
            'implementation_statement' => 'nullable|string',
            'amount_received' => 'nullable|numeric',
            'currency_received' => 'required|exists:currencies,code',
            'notes' => 'nullable|string',
            'number_beneficiaries' => 'nullable|integer',
        ]);
        $currency_allocation_value = Currency::where('code', $request->currency_allocation)->first()->value;
        $currency_received_value = Currency::where('code', $request->currency_received)->first()->value;

        // رفع الملفات للتخصيص
        $files = [];
        $year = Carbon::parse($request->date_allocation)->format('Y');
        if ($request->hasFile('filesArray')) {
            foreach ($request->file('filesArray') as $file) {
                $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $filenameExtension = time() . '_' . $fileName . '.' . $file->extension();
                $filepath = $file->storeAs("files/allocations/$year/$request->budget_number", $filenameExtension, 'public');
                $files[$file->getClientOriginalName()] = $filepath;
            }
        }

        $request->merge([
            'currency_allocation_value' => $currency_allocation_value,
            'currency_received_value' => $currency_received_value,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
            'files' => json_encode($files),
        ]);

        $allocation = Allocation::create($request->all());
        return redirect()->route('allocations.index')->with('success', 'تمت عملية الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Allocation $allocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Allocation $allocation)
    {
        $this->authorize('update', Allocation::class);
        $editForm = true;
        $btn_label = 'تعديل';
        $files = json_decode($allocation->files, true) ?? [];
        return view('dashboard.projects.allocations.edit', compact('allocation', 'editForm', 'btn_label', 'files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Allocation $allocation)
    {
        $this->authorize('update', Allocation::class);
        $request->validate([
            'date_allocation' => 'required|date',
            'budget_number' => 'required|integer',
            'quantity' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'total_dollar' => 'nullable|numeric',
            'allocation' => 'nullable|numeric',
            'currency_allocation' => 'required|exists:currencies,code',
            'amount' => 'nullable|numeric',
            'implementation_items' => 'nullable|string',
            'date_implementation' => 'nullable|date',
            'implementation_statement' => 'nullable|string',
            'amount_received' => 'nullable|numeric',
            'currency_received' => 'required|exists:currencies,code',
            'notes' => 'nullable|string',
            'number_beneficiaries' => 'nullable|integer',
        ]);
        $currency_allocation_value = Currency::where('code', $request->currency_allocation)->first()->value;
        $currency_received_value = Currency::where('code', $request->currency_received)->first()->value;


        // رفع الملفات للتخصيص
        $files = json_decode($allocation->files, true) ?? [];

        $year = Carbon::parse($request->date_allocation)->format('Y');

        if ($request->hasFile('filesArray')) {
            foreach ($request->file('filesArray') as $file) {
                $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $filenameExtension = time() . '_' . $fileName . '.' . $file->extension();
                $filepath = $file->storeAs("files/allocations/$year/$request->budget_number", $filenameExtension, 'public');
                $files[$file->getClientOriginalName()] = $filepath;
            }
        }

        $request->merge([
            'currency_allocation_value' => $currency_allocation_value,
            'currency_received_value' => $currency_received_value,
            'files' => $files,
        ]);

        $allocation->update($request->all());
        return redirect()->route('allocations.index')->with('success', 'تمت عملية التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Allocation $allocation)
    {
        $this->authorize('delete', Allocation::class);
        $files = json_decode($allocation->files, true) ?? [];
        $year = Carbon::parse($allocation->date_allocation)->format('Y');
        foreach ($files as $file) {
            Storage::delete($file);
        }
        Storage::deleteDirectory('files/allocations/' . $year . '/' . $allocation->budget_number);
        $allocation->delete();
        return redirect()->route('allocations.index')->with('danger', 'تمت عملية الحذف بنجاح');
    }

    public function import(Request $request){
        $this->authorize('import', Allocation::class);
        if(!$request->hasFile('file')){
            return redirect()->route('allocations.index')->with('danger', 'الرجاء تحميل الملف');
        }
        $file = $request->file('file');
        Excel::import(new AllocationsImport, $file);
        return redirect()->route('allocations.index')->with('success', 'تمت عملية الاستيراد بنجاح');
    }

}
