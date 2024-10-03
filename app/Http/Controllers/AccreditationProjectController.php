<?php

namespace App\Http\Controllers;

use App\Models\AccreditationProject;
use App\Models\Allocation;
use App\Models\Currency;
use App\Models\Executive;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AccreditationProjectController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', AccreditationProject::class);
        $accreditations = AccreditationProject::paginate();
        return view('dashboard.projects.accreditations.index', compact('accreditations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', AccreditationProject::class);
        $accreditation = new AccreditationProject();
        $allocation = new Allocation();
        $executive = new Executive();

        return view('dashboard.projects.accreditations.create', compact('accreditation', 'allocation', 'executive'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', AccreditationProject::class);
        if($request->implementation_date){
            $month = Carbon::parse($request->implementation_date)->format('Y-m');
        }else{
            $month = null;
        }
        if($request->type == 'allocation'){
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
        }


        if($request->type == 'executive'){
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
                'notes' => ($request->notes ?? '') . ' id=' . $id,
            ]);
        }

        AccreditationProject::create($request->all());
        return redirect()->route('accreditations.index')->with('success', 'تمت إضافة مشروع جديد');
    }

    /**
     * Display the specified resource.
     */
    public function show(AccreditationProject $accreditation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccreditationProject $accreditation)
    {
        $this->authorize('update', AccreditationProject::class);
        $selectedForm = $accreditation->type;
        $btn_label = "تعديل";
        $editForm = true;
        $files = json_decode($accreditation->files, true) ?? [];
        return view('dashboard.projects.accreditations.edit', compact('accreditation', 'files', 'selectedForm', 'btn_label', 'editForm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccreditationProject $accreditation)
    {

        $this->authorize('update', AccreditationProject::class);
        if($request->type == 'allocation'){
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
            $files = json_decode($accreditation->files, true) ?? [];

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

            if($request->adoption == true){
                $request->merge([
                    'manager_name' => Auth::user()->name,
                    'user_id' => $accreditation->user_id,
                    'user_name' => $accreditation->user_name,
                ]);
                Allocation::create($request->all());
                $accreditation->delete();
            }else{
                $accreditation->update($request->all());
            }
        }

        if($request->type == 'executive'){
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


            $notes = $request->notes;
            $searchTerm = 'id=';

            $startPos = strpos($notes, $searchTerm);

            if ($startPos !== false) {
                $startPos += strlen($searchTerm);
                $extractedText = substr($notes, $startPos);
                $id  = $extractedText;
            }

            // رفع الملفات للتخصيص
            $files = json_decode($accreditation->files, true) ?? [];
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
                'files' => json_encode($files),
            ]);

            if($request->adoption == true){
                $request->merge([
                    'manager_name' => Auth::user()->name,
                    'user_id' => $accreditation->user_id,
                    'user_name' => $accreditation->user_name,
                ]);
                $request['notes'] = "";
                Executive::create($request->all());
                $accreditation->delete();
            }else{
                $accreditation->update($request->all());
            }
        }


        return redirect()->route('accreditations.index')->with('success', 'تم تعديل المشروع بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccreditationProject $accreditation)
    {
        $this->authorize('delete', $accreditation);
        $accreditation->delete();
        return redirect()->route('accreditations.index')->with('danger', 'تم حذف المشروع بنجاح');
    }
}
