<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="{{ route('roles.index') }}">الصلاحيات</a></li>
        <li><a href="#">تعديل الصلاحية : {{ $role->name }}</a></li>
    </x-slot:breadcrumb>

    <div class="row">
        <form action="{{ route('roles.update', $role->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            @include('dashboard.roles._form')
        </form>
    </div>
</x-front-layout>
