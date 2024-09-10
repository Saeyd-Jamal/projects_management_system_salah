<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);
        $roles = role::get();
        return view('dashboard.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Role::class);
        $role = new Role();
        return view('dashboard.roles.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);

        DB::beginTransaction();
        try {
            $role =Role::create($request->all());
            foreach ($request->abilities as $permission) {
                Permission::create([
                    'role_id' => $role->id,
                    'name' => $permission,
                    'ability' => 'allow',
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return redirect()->route('roles.index')->with('success', 'تمت العملية بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);
        $btn_label = 'تعديل';
        return view('dashboard.roles.edit', compact('role' , 'btn_label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $roleM = Role::findOrFail($id);
        $this->authorize('update', $roleM);
        DB::beginTransaction();
        try {
            $roleM->update($request->all());
            if ($request->abilities != null) {
                $role_old = Permission::where('role_id', $roleM->id)->pluck('name')->toArray();
                $role_new = $request->abilities;
                foreach ($role_old as $role) {
                    if (!in_array($role, $role_new)) {
                        Permission::where('role_id', $roleM->id)->where('name', $role)->delete();
                    }
                }
                foreach ($role_new as $role) {
                    $role_f = Permission::where('role_id', $roleM->id)->where('name', $role)->first();
                    if ($role_f == null) {
                        Permission::create([
                            'name' => $role,
                            'role_id' => $roleM->id,
                            'ability' => 'allow',
                        ]);
                    }else{
                        $role_f->update(['ability' => 'allow']);
                    }
                }
            }else{
                Permission::where('role_id', $roleM->id)->delete();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return redirect()->route('roles.index')->with('success', 'تمت العملية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);
        $role->delete();
        return redirect()->route('roles.index')->with('danger', 'تم حذف الصلاحية بنجاح');
    }
}
