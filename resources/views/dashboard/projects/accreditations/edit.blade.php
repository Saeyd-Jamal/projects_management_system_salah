<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="{{ route('accreditations.index') }}">مشاريع الإعتماد</a></li>
        <li><a href="#">تعديل المشروع</a></li>
    </x-slot:breadcrumb>


    <div class="row">
        <form id="UploadfileID" action="{{ route('accreditations.update', $accreditation->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            @if ($selectedForm == 'allocation')
                    <livewire:allocation-form :allocation="$accreditation"  :btn_label="__('تعديل')" :editForm="true"  />
                    <input type="hidden" name="type" value="allocation">
            @elseif ($selectedForm == 'executive')
                    <livewire:executive-form :executive="$accreditation"  :btn_label="__('تعديل')" :editForm="true"  />
                    <input type="hidden" name="type" value="executive">
            @endif
            @can('adoption','App\\Models\AccreditationProject')
            <div class="d-flex justify-content-end">
                <button type="submit" name="adoption" value="true" class="btn btn-info m-0">
                    إعتماد
                </button>
            </div>
            @endcan
        </form>
        {{-- <livewire:files :files="$files" :obj="$accreditation" /> --}}
    </div>
</x-front-layout>
