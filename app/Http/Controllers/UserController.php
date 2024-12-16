<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', User::class);
        $users = User::paginate(10);
        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function profile(User $user)
    {
        if(Auth::user()->id != $user->id){
            abort(403);
        }
        return view('dashboard.users.profile', compact('user'));
    }
    public function create(Request $request)
    {
        $this->authorize('create', User::class);
        $user = new User();
        return view('dashboard.users.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        $request->validate([
            'name' => 'required',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|same:confirm_password',
            'confirm_password' => 'required|same:password',
        ],[
            'password.same' => 'كلمة المرور غير متطابقة',
            'confirm_password.same' => 'كلمة المرور غير متطابقة',
        ]);
        DB::beginTransaction();
        try{
            if($request->hasFile('avatarFile')){
                $imageFile = $request->file('avatarFile');
                $imageName =  "users_" . Str::slug($request->post('username')) . '.' . $imageFile->extension();
                $imagePath = $imageFile->storeAs('users',$imageName, 'public');

                $request->merge([
                    'avatar' => $imagePath,
                ]);
            }
            $user = User::create($request->all());
            foreach ($request->abilities as $role) {
                RoleUser::create([
                    'role_name' => $role,
                    'user_id' => $user->id,
                    'ability' => 'allow',
                ]);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('danger', $e->getMessage());
        }
        return redirect()->route('users.index')->with('success', 'تم اضافة مستخدم جديد');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', User::class);
        $logs = Logs::where('user_id', $user->id)->paginate(10);
        return view('dashboard.users.show', compact('user', 'logs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user)
    {
        $this->authorize('edit', User::class);
        $btn_label = "تعديل";
        return view('dashboard.users.edit', compact('user', 'btn_label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('edit', User::class);
        $request->validate([
            'name' => 'required',
            'username' => 'required|string|unique:users,username,'.$user->id,
        ]);
        DB::beginTransaction();
        try{
            if($request->hasFile('avatarFile')){
                $image_old = $user->avatar;
                if($image_old != null){
                    Storage::delete('public/'.$image_old);
                }
                $imageFile = $request->file('avatarFile');
                $imageName =  "users_" . Str::slug($request->post('username')) . '.' . $imageFile->extension();
                $imagePath = $imageFile->storeAs('users',$imageName, 'public');

                $request->merge([
                    'avatar' => $imagePath,
                ]);
            }
            if($request->password == null){
                $user->update($request->except('password'));
            }else{
                $user->update($request->all());
            }
            if ($request->abilities != null) {
                $role_old = RoleUser::where('user_id', $user->id)->pluck('role_name')->toArray();
                $role_new = $request->abilities;
                foreach ($role_old as $role) {
                    if (!in_array($role, $role_new)) {
                        RoleUser::where('user_id', $user->id)->where('role_name', $role)->delete();
                    }
                }
                foreach ($role_new as $role) {
                    $role_f = RoleUser::where('user_id', $user->id)->where('role_name', $role)->first();
                    if ($role_f == null) {
                        RoleUser::create([
                            'role_name' => $role,
                            'user_id' => $user->id,
                            'ability' => 'allow',
                        ]);
                    }else{
                        $role_f->update(['ability' => 'allow']);
                    }
                }
            }else{
                RoleUser::where('user_id', $user->id)->delete();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        return redirect()->route('users.index')->with('success', 'تم تعديل المستخدم');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete', User::class);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم');
    }
}
