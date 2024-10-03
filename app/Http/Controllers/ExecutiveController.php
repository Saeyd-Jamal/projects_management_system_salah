<?php

namespace App\Http\Controllers;

use App\Imports\ExecutivesImport;
use App\Models\Executive;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ExecutiveController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Executive::class);
        $executives = Executive::paginate(10);
        return view('dashboard.projects.executives.index', compact('executives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Executive::class);
        $executive = new Executive();
        return view('dashboard.projects.executives.create', compact('executive'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Executive::class);
        $request->validate([
            'implementation_date' => 'required|date',
            // 'budget_number' => 'required|integer',
            'account' => 'required|string',
            'affiliate_name' => 'required|string',
            'detail' => 'nullable|string',
            'quantity' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'total_ils' => 'nullable|numeric',
            'received' => 'nullable|string',
            'executive' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'amount_payments' => 'nullable|numeric',
            'payment_mechanism' => 'nullable|string',
        ]);

        $id = Executive::latest()->first() ? Executive::latest()->first()->id + 1 : 1;
        // رفع الملفات للتخصيص
        $files = [];
        $year = Carbon::parse($request->implementation_date)->format('Y');
        if ($request->hasFile('filesArray')) {
            foreach ($request->file('filesArray') as $file) {
                $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $filenameExtension = time() . '_' . $fileName . '.' . $file->extension();
                $filepath = $file->storeAs("files/executives/$year/$id", $filenameExtension, 'public');
                $files[$file->getClientOriginalName()] = $filepath;
            }
        }
        $month = Carbon::parse($request->implementation_date)->format('m');
        $request->merge([
            'month' => $month,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
            'files' => json_encode($files),
        ]);

        Executive::create($request->all());
        return redirect()->route('executives.index')->with('success', 'تمت عملية الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Executive $executive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Executive $executive)
    {
        $this->authorize('update', Executive::class);
        $editForm = true;
        $btn_label = 'تعديل';
        $files = json_decode($executive->files, true) ?? [];
        return view('dashboard.projects.executives.edit', compact('executive', 'editForm', 'btn_label', 'files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Executive $executive)
    {
        $this->authorize('update', Executive::class);
        $request->validate([
            'implementation_date' => 'required|date',
            // 'budget_number' => 'required|integer',
            'account' => 'required|string',
            'affiliate_name' => 'required|string',
            'detail' => 'nullable|string',
            'quantity' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'total_ils' => 'nullable|numeric',
            'received' => 'nullable|string',
            'executive' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'amount_payments' => 'nullable|numeric',
            'payment_mechanism' => 'nullable|string',
        ]);

        // رفع الملفات للتخصيص
        $files = json_decode($executive->files, true) ?? [];
        $year = Carbon::parse($request->implementation_date)->format('Y');
        if ($request->hasFile('filesArray')) {
            foreach ($request->file('filesArray') as $file) {
                $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $filenameExtension = time() . '_' . $fileName . '.' . $file->extension();
                $filepath = $file->storeAs("files/executives/$year/$executive->id", $filenameExtension, 'public');
                $files[$file->getClientOriginalName()] = $filepath;
            }
        }
        $month = Carbon::parse($request->implementation_date)->format('m');

        $request->merge([
            'month' => $month,
            'files' => json_encode($files),
        ]);
        $executive->update($request->all());
        return redirect()->route('executives.index')->with('success', 'تمت عملية التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Executive $executive)
    {
        $this->authorize('delete', Executive::class);
        $files = json_decode($executive->files, true) ?? [];
        $year = Carbon::parse($executive->implementation_date)->format('Y');
        foreach ($files as $file) {
            Storage::delete($file);
        }
        Storage::deleteDirectory('files/executives/' . $year . '/' . $executive->id);
        $executive->delete();
        return redirect()->route('executives.index')->with('danger', 'تمت عملية الحذف بنجاح');
    }


    public function import(Request $request){
        $this->authorize('import', Executive::class);
        if(!$request->hasFile('file')){
            return redirect()->route('executives.index')->with('danger', 'الرجاء تحميل الملف');
        }
        $file = $request->file('file');
        Excel::import(new ExecutivesImport, $file);
        $executives = Executive::query();
        foreach($executives->get() as $executive){
            $date = Carbon::parse($executive->implementation_date)->format('Y-m-d');
            $month = Carbon::parse($date)->format('m');
            $executive->update([
                'month' => $month
            ]);
        }
        return redirect()->route('executives.index')->with('success', 'تمت عملية الاستيراد بنجاح');
    }

}
