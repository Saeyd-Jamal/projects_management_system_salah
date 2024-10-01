<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark">الأصناف</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">تعديل الصنف : {{ $item->name }}</li>
    </x-slot:breadcrumb>


    <div class="row">
        <form id="UploadfileID" action="{{ route('items.update', $item->id) }}" method="post">
            @csrf
            @method('put')
            @include('dashboard.cataloguing.items._form')
        </form>
    </div>
</x-front-layout>
