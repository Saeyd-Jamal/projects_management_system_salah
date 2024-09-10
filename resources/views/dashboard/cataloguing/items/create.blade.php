<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark">المشاريع</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">إضافة مشروع جديد</li>
    </x-slot:breadcrumb>

    <div class="row">
        <form action="{{ route('items.store') }}" method="post"  enctype="multipart/form-data">
            @csrf
            @include('dashboard.cataloguing.items._form')

        </form>
    </div>
</x-front-layout>
