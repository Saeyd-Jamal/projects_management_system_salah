<div class="row">
    <div class="form-group col-md-6">
        <x-form.input type="text" name="name" label="الاسم" :value="$user->name" placeholder="إملأ الاسم" autofocus required />
    </div>
    <div class="form-group col-md-6">
        <label for="username">اسم المستخدم</label>
        <input
            type="text"
            name="username"
            id="username"
            value="{{old('username', $user->username)}}"
            class="form-control form-control-alternative"
            placeholder="إملأ اسم المستخدم"

            required="required"
        >
    </div>

    <div class="form-group col-md-6">
        <x-form.input type="password" name="password" label="كلمة السر"  placeholder="إملأ كلمة السر" />
    </div>
    <div class="form-group col-md-6">
        <x-form.input type="email" name="email" label="الإيميل" :value="$user->email" placeholder="إملأ الإيميل"  />
    </div>
    <div class="form-group col-md-6">
        <x-form.input type="text" name="phone" label="رقم الهاتف" :value="$user->phone" placeholder="+972 59 431 8545"   />
    </div>

    <div class="form-group col-md-6">
        <label for="role_id">الصلاحية</label>
        <select name="role_id" label="الصلاحية" class="form-control">
            <option value="">اختر الصلاحية</option>
            @foreach ($roles as $role)
                <option value="{{$role->id}}" {{old('role_id', ($user->roles()->first() != null ? $user->roles()->first()->id : null )) == $role->id ? 'selected' : ''}}>{{$role->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
        <x-form.input type="file" class="form-control-file" name="avatarFile" label="الصورة الشخصية"/>
        @if ($user->avatar)
            <img class="mt-3" src="{{$user->avatar_url}}" alt="..." height="100px">
        @endif
    </div>


</div>
<div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary m-0">
        @if (isset($btn_label))
            <i class="fa-solid fa-pen-to-square"></i>
            {{$btn_label}}
        @else
            <i class="fa-solid fa-plus"></i>
            اضافة
        @endif
    </button>

</div>
