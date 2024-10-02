<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="{{ route('executives.index') }}">التنفيذات</a></li>
        <li><a href="#">تعديل التنفيذ</a></li>
    </x-slot:breadcrumb>


    <div class="row">
        <form id="UploadfileID" action="{{ route('executives.update', $executive->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <livewire:executive-form :executive="$executive" :btn_label="__('تعديل')" :editForm="true"  />
        </form>
        <livewire:files :files="$files" :obj="$executive" />
    </div>
</x-front-layout>
