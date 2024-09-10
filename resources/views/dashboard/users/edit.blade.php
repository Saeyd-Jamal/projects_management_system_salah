<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark">المستخدمين</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">تعديل المستخدم</li>
    </x-slot:breadcrumb>

    <div class="row">
        <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            @include('dashboard.users._form')
        </form>
    </div>
</x-front-layout>
