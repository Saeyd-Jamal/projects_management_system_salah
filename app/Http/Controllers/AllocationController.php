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
use Yajra\DataTables\Facades\DataTables;

class AllocationController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('view', Allocation::class);

        if($request->ajax()) {
                // جلب بيانات المستخدمين من الجدول
            $allocations = Allocation::query()->orderBy('date_allocation', 'asc');;


            // التصفية بناءً على التواريخ
            if ($request->from_date != null && $request->to_date != null) {
                $allocations->whereBetween('date_allocation', [$request->from_date, $request->to_date]);
            }

            return DataTables::of($allocations)
                    ->addIndexColumn()  // إضافة عمود الترقيم التلقائي
                    ->addColumn('edit', function ($allocation) {
                        return $allocation->id;
                    })
                    ->addColumn('currency_allocation_name', function ($allocation) {
                        return Currency::where('code', $allocation->currency_allocation)->first()->name;
                    })
                    ->addColumn('delete', function ($allocation) {
                        return $allocation->id;
                    })
                    ->make(true);
        }

        $brokers = Allocation::select('broker_name')->distinct()->pluck('broker_name')->toArray();
        $organizations = Allocation::select('organization_name')->distinct()->pluck('organization_name')->toArray();
        $projects = Allocation::select('project_name')->distinct()->pluck('project_name')->toArray();
        $items =  Allocation::select('item_name')->distinct()->pluck('item_name')->toArray();
        $currencies = Currency::get();

        return view('dashboard.projects.allocations.index', compact('brokers', 'organizations', 'projects', 'items', 'currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Allocation::class);
        $allocation = new Allocation();
        if($request->ajax()){
            $allocation->budget_number =  Allocation::orderBy('budget_number', 'desc')->first() ? Allocation::orderBy('budget_number', 'desc')->first()->budget_number + 1 : 1;
            $allocation->date_allocation =  Carbon::now()->format('Y-m-d');
            $allocation->currency_allocation =  'USD';
            return $allocation;
        }
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
            'notes' => 'nullable|string',
            'number_beneficiaries' => 'nullable|integer',
        ]);
        $currency_allocation_value = Currency::where('code', $request->currency_allocation)->first()->value;

        // // رفع الملفات للتخصيص
        // $files = [];
        // $year = Carbon::parse($request->date_allocation)->format('Y');
        // if ($request->hasFile('filesArray')) {
        //     foreach ($request->file('filesArray') as $file) {
        //         $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        //         $filenameExtension = time() . '_' . $fileName . '.' . $file->extension();
        //         $filepath = $file->storeAs("files/allocations/$year/$request->budget_number", $filenameExtension, 'public');
        //         $files[$file->getClientOriginalName()] = $filepath;
        //     }
        // }

        $request->merge([
            'currency_allocation_value' => $currency_allocation_value,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
            // 'files' => json_encode($files),
        ]);

        $allocation = Allocation::create($request->all());
        if($request->ajax()) {
            return response()->json(['message' => 'تم الإضافة بنجاح']);
        }
        return redirect()->route('allocations.index')->with('success', 'تمت عملية الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Allocation $allocation)
    {
        if($request->ajax()){
            return response()->json($allocation);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Allocation $allocation)
    {
        if($request->ajax()) {
            $allocation->currency_allocation_name = Currency::where('code', $allocation->currency_allocation)->first()->name;
            $allocation->user = $allocation->user();
            return response()->json($allocation);
        }
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
            'notes' => 'nullable|string',
            'number_beneficiaries' => 'nullable|integer',
        ]);
        $currency_allocation_value = Currency::where('code', $request->currency_allocation)->first()->value;


        // رفع الملفات للتخصيص
        // $files = json_decode($allocation->files, true) ?? [];

        // $year = Carbon::parse($request->date_allocation)->format('Y');

        // if ($request->hasFile('filesArray')) {
        //     foreach ($request->file('filesArray') as $file) {
        //         $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        //         $filenameExtension = time() . '_' . $fileName . '.' . $file->extension();
        //         $filepath = $file->storeAs("files/allocations/$year/$request->budget_number", $filenameExtension, 'public');
        //         $files[$file->getClientOriginalName()] = $filepath;
        //     }
        // }

        $request->merge([
            'currency_allocation_value' => $currency_allocation_value,
            // 'files' => $files,
        ]);

        $allocation->update($request->all());
        if($request->ajax()) {
            return response()->json(['message' => 'تم التحديث بنجاح']);
        }
        return redirect()->route('allocations.index')->with('success', 'تمت عملية التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('delete', Allocation::class);
        // $files = json_decode($allocation->files, true) ?? [];
        // $year = Carbon::parse($allocation->date_allocation)->format('Y');
        // foreach ($files as $file) {
        //     Storage::delete($file);
        // }
        // Storage::deleteDirectory('files/allocations/' . $year . '/' . $allocation->budget_number);

        $allocation = Allocation::findOrFail($id);
        $allocation->delete();

        if($request->ajax()) {
            return response()->json(['success' => 'تمت عملية الحذف بنجاح']);
        }
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
