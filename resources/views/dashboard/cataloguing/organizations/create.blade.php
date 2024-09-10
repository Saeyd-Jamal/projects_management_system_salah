<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark">المؤسسات</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">إضافة مؤسسة جديدة</li>
    </x-slot:breadcrumb>

    <div class="row">
        <form action="{{ route('organizations.store') }}" method="post"  enctype="multipart/form-data">
            @csrf
            @include('dashboard.cataloguing.organizations._form')

        </form>
    </div>
</x-front-layout>
