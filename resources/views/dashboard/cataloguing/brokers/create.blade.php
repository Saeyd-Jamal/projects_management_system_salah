<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark">الوسطاء</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">إضافة وسيط جديد</li>
    </x-slot:breadcrumb>

    <div class="row">
        <form  id="UploadfileID" action="{{ route('brokers.store') }}" method="post"  enctype="multipart/form-data">
            @csrf
            @include('dashboard.cataloguing.brokers._form')

        </form>

    </div>
</x-front-layout>
