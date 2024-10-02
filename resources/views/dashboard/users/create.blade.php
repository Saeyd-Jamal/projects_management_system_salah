<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="{{ route('users.index') }}">المستخدمين</a></li>
        <li><a href="#">انشاء مستخدم جديد</a></li>
    </x-slot:breadcrumb>

    <div class="row">
        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('dashboard.users._form')
        </form>
    </div>
</x-front-layout>
