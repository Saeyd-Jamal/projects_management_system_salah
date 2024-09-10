<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark">التخصيصات</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">إضافة تخصيص جديد</li>
    </x-slot:breadcrumb>

    <div class="row">
        <form  id="UploadfileID" action="{{ route('allocations.store') }}" method="post"  enctype="multipart/form-data">
            @csrf
            <livewire:allocation-form :allocation="$allocation" />
        </form>

    </div>
    <h3>رفع ملف اكسيل</h3>
    <div class="row">
        {{-- Excel  --}}
        <div class="col-lg-3 col-sm-6 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <form action="{{route('allocations.import')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" class="form-control">
                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="fa-solid fa-upload"></i>
                            تحميل البيانات
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
