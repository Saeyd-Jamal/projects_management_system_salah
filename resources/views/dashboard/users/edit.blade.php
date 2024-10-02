<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="{{ route('users.index')}}">المستخدمين</a></li>
        <li><a href="#">تعديل المستخدم : {{ $user->name }}</a></li>
    </x-slot:breadcrumb>

    <div class="row">
        <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            @include('dashboard.users._form')
        </form>
    </div>
</x-front-layout>
