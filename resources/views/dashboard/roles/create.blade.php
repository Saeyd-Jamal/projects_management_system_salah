<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark">الصلاحيات</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">إضافة صلاحية جديدة</li>
    </x-slot:breadcrumb>

    <div class="row">
        <form action="{{ route('roles.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('dashboard.roles._form')
        </form>
    </div>
</x-front-layout>
