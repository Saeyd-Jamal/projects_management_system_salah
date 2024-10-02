<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="{{ route('allocations.index')}}">التخصيصات</a></li>
        <li><a href="#">تعديل التخصيص رقم {{ $allocation->budget_number }}</a></li>
    </x-slot:breadcrumb>


    <div class="row">
        <form id="UploadfileID" action="{{ route('allocations.update', $allocation->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <livewire:allocation-form :allocation="$allocation" :btn_label="__('تعديل')" :editForm="true"  />
        </form>
        <livewire:files :files="$files" :obj="$allocation" />
    </div>
</x-front-layout>
