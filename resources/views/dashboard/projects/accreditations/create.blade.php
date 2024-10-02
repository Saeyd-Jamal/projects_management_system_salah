<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="{{ route('accreditations.index') }}">مشاريع الإعتماد</a></li>
        <li><a href="#">إضافة مشروع جديد</a></li>
    </x-slot:breadcrumb>

    <div class="row">
        <livewire:dynamic-form-loader />
    </div>
</x-front-layout>
