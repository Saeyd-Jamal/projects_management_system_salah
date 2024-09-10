<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', User::class);
        $users = User::get();
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
        $roles = Role::get();
        return view('dashboard.users.profile', compact('user', 'roles'));
    }
    public function create()
    {
        $this->authorize('create', User::class);
        $user = new User();
        $roles = Role::get();
        return view('dashboard.users.create', compact('user', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|unique:users,username,' . $request->post('id') . ',id',
        ]);

        if($request->hasFile('avatarFile')){
            $imageFile = $request->file('avatarFile');
            $imageName =  "users_" . Str::slug($request->post('username')) . '.' . $imageFile->extension();
            $imagePath = $imageFile->storeAs('users',$imageName, 'public');

            $request->merge([
                'avatar' => $imagePath,
            ]);
        }
        if($request->password == null){
            $user = User::create($request->except('password'));
        }else{
            $user = User::create($request->all());
        }
        RoleUser::create([
            'user_id' => $user->id,
            'role_id' => $request->post('role_id'),
        ]);
        return redirect()->route('users.index')->with('success', 'تمت إنشاء مستخدم بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if($user->id == 1 && Auth::user()->id != 1){
            abort(403);
        }
        $this->authorize('update', $user);
        $btn_label = 'تعديل';
        $roles = Role::get();
        return view('dashboard.users.edit', compact('user' , 'btn_label', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if(Auth::user()->id != $user->id){
            $this->authorize('update', $user);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|unique:users,username,' . $user->id . ',id',
        ]);

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
        if($request->post('role_id') != null){
            RoleUser::updateOrCreate([
                'user_id' => $user->id,
            ],[
                'role_id' => $request->post('role_id'),
            ]);
            return redirect()->route('users.index')->with('success', 'تمت تحديث مستخدم بنجاح');
        }else{
            return redirect()->route('home')->with('success', 'تمت تحديث بياناتك الشخصية بنجاح');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('users.index')->with('danger', 'تم حذف المستخدم بنجاح');
    }
}
