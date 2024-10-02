<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="#">الملف الشخصي</a></li>
    </x-slot:breadcrumb>

    <div class="row">
        <form action="{{ route('users.update', auth()->user()->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="name">الاسم</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{old('name', $user->name)}}"
                        class="form-control form-control-alternative"
                        placeholder="إملأ الاسم هنا"
                        @cannot('update', User::class)
                            readonly
                        @endcannot
                        autofocus
                        required
                    >
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
                        @cannot('update', User::class)
                        readonly
                        @endcannot
                        required
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
                    <x-form.input type="file" class="form-control-file" name="avatarFile" label="الصورة الشخصية"/>
                    @if ($user->avatar)
                        <img class="mt-3" src="{{$user->avatar_url}}" alt="..." height="100px">
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary m-0">
                    تعديل
                </button>
            </div>
        </form>
    </div>
</x-front-layout>
