<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="{{ route('items.index')}}">الأصناف</a></li>
        <li><a href="#">إضافة  تخصيص لصنف جديد</a></li>
    </x-slot:breadcrumb>

    <div class="row">
        <form action="{{ route('items.store') }}" method="post">
            @csrf
            @include('dashboard.cataloguing.items._form')

        </form>
    </div>
</x-front-layout>
