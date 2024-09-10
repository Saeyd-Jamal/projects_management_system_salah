<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark">المستخدمين</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">انشاء مستخدم جديد</li>
    </x-slot:breadcrumb>

    <div class="row">
        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('dashboard.users._form')
        </form>
    </div>
</x-front-layout>
