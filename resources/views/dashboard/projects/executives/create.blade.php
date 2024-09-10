<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark">التنفيذات</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">إضافة تنفيذ جديد</li>
    </x-slot:breadcrumb>

    <div class="row">
        <form  id="UploadfileID" action="{{ route('executives.store') }}" method="post"  enctype="multipart/form-data">
            @csrf
            <livewire:executive-form :executive="$executive" />
        </form>
    </div>
</x-front-layout>
