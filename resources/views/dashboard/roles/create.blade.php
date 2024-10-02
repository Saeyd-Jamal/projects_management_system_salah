<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="{{ route('roles.index') }}">الصلاحيات</a></li>
        <li><a href="#">إضافة صلاحية جديدة</a></li>
    </x-slot:breadcrumb>

    <div class="row">
        <form action="{{ route('roles.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('dashboard.roles._form')
        </form>
    </div>
</x-front-layout>
