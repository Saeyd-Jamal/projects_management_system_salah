<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark">الأصناف</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">إضافة  تخصيص لصنف جديد</li>
    </x-slot:breadcrumb>

    <div class="row">
        <form action="{{ route('items.store') }}" method="post">
            @csrf
            @include('dashboard.cataloguing.items._form')

        </form>
    </div>
</x-front-layout>
