<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrokerController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Broker::class);
        $brokers = Broker::paginate(10);
        return view('dashboard.cataloguing.brokers.index', compact('brokers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Broker::class);
        $broker = new Broker();
        return view('dashboard.cataloguing.brokers.create', compact('broker'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Broker::class);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $request->merge([
            'slug' => Str::slug($request->post('name')),
        ]);

        $files = [];
        if ($request->hasFile('filesArray')) {
            foreach ($request->file('filesArray') as $file) {
                $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $filenameExtension = time() . '_' . $fileName . '.' . $file->extension();
                $filepath = $file->storeAs("files/borkers/$request->slug", $filenameExtension, 'public');
                $files[$file->getClientOriginalName()] = $filepath;
            }
        }
        $request->merge([
            'files' => json_encode($files),
        ]);
        Broker::create($request->all());
        return redirect()->route('brokers.index')->with('success', 'تم إضافة وسيط جديد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Broker $broker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $this->authorize('update', Broker::class);
        $broker = Broker::where('slug', $slug)->first();
        $btn_label = 'تعديل';
        $files = json_decode($broker->files, true) ?? [];
        return view('dashboard.cataloguing.brokers.edit', compact('broker', 'btn_label','files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $this->authorize('update', Broker::class);
        $broker = Broker::where('slug', $slug)->first();

        // استرجاع الملفات الحالية وتحويلها إلى مصفوفة
        $files = json_decode($broker->files, true) ?? [];
        if ($request->hasFile('filesArray')) {
            foreach ($request->file('filesArray') as $file) {
                $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $filenameExtension = time() . '_' . $fileName . '.' . $file->extension();
                $filepath = $file->storeAs("files/borkers/$slug", $filenameExtension, 'public');
                $files[$file->getClientOriginalName()] = $filepath;
            }
        }
        $request->merge([
            'files' => json_encode($files),
        ]);
        $broker->update($request->all());
        return redirect()->route('brokers.edit',$slug)->with('success', 'تم تحديث بيانات وسيط');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $this->authorize('delete', Broker::class);
        $broker = Broker::where('slug', $slug)->first();
        $files = json_decode($broker->files, true) ?? [];
        foreach ($files as $file) {
            Storage::delete($file);
        }
        Storage::deleteDirectory('files/borkers/' . $slug);
        $broker->delete();
        return redirect()->route('brokers.index')->with('danger', 'تم حذف وسيط');
    }
}