<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Item::class);
        $items = Item::paginate(10);
        return view('dashboard.cataloguing.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Item::class);
        $item = new Item();
        return view('dashboard.cataloguing.items.create', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Item::class);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $files = [];
        if ($request->hasFile('filesArray')) {
            foreach ($request->file('filesArray') as $file) {
                $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $filenameExtension = time() . '_' . $fileName . '.' . $file->extension();
                $filepath = $file->storeAs("files/items/". Str::slug($request->post('name')), $filenameExtension, 'public');
                $files[$file->getClientOriginalName()] = $filepath;
            }
        }
        $request->merge([
            'files' => json_encode($files),
        ]);

        Item::create($request->all());
        return redirect()->route('items.index')->with('success', 'تم إضافة صنف جديد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $this->authorize('update', Item::class);
        $btn_label = 'تعديل';
        $files = json_decode($item->files, true) ?? [];
        return view('dashboard.cataloguing.items.edit', compact('item', 'btn_label','files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $this->authorize('update', Item::class);
        $slug = $item->slug;
        // استرجاع الملفات الحالية وتحويلها إلى مصفوفة
        $files = json_decode($item->files, true) ?? [];
        if ($request->hasFile('filesArray')) {
            foreach ($request->file('filesArray') as $file) {
                $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $filenameExtension = time() . '_' . $fileName . '.' . $file->extension();
                $filepath = $file->storeAs("files/items/". Str::slug($item->name), $filenameExtension, 'public');
                $files[$file->getClientOriginalName()] = $filepath;
            }
        }
        $request->merge([
            'files' => json_encode($files),
        ]);
        $item->update($request->all());
        return redirect()->route('items.index')->with('success', 'تم تحديث بيانات الصنف المحدد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $this->authorize('delete', Item::class);
        $files = json_decode($item->files, true) ?? [];
        foreach ($files as $file) {
            Storage::delete($file);
        }
        Storage::deleteDirectory('files/items/' . Str::slug($item->name));
        $item->delete();
        return redirect()->route('items.index')->with('danger', 'تم حذف الصنف المحدد');
    }
}
