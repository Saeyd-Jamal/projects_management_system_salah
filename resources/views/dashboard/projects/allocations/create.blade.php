<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="{{ route('allocations.index') }}">التخصيصات</a></li>
        <li><a href="{{ route('allocations.create') }}">اضافة تخصيص جديد</a></li>
    </x-slot:breadcrumb>

    <div class="row">
        <form  id="UploadfileID" action="{{ route('allocations.store') }}" method="post"  enctype="multipart/form-data">
            @csrf
            <livewire:allocation-form :allocation="$allocation" />
        </form>
    </div>
    <hr>
    @can('import','App\\Models\Allocation')
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
                            تحميل البيانات
                        </button>
                        <a href="{{asset('filesExcel/templateAllocation.xlsx')}}" class='nav-link' download="نموذج بيانات التنفيذ.xlsx" >
                            تحميل نموذج البيانات
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan

</x-front-layout>
