<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="{{ route('items.index')}}">الأصناف</a></li>
        <li><a href="#">تعديل الصنف : {{ $item->name }}</a></li>
    </x-slot:breadcrumb>


    <div class="row">
        <form id="UploadfileID" action="{{ route('items.update', $item->id) }}" method="post">
            @csrf
            @method('put')
            @include('dashboard.cataloguing.items._form')
        </form>
    </div>
</x-front-layout>
