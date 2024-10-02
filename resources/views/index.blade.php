<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="#">الرئيسية</a></li>
    </x-slot:breadcrumb>
    <h2 class="mt-4">الإحصائيات</h2>
    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <div class="card shadow bg-info">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <span class="h2 mb-0 ">
                                {{ App\Models\Allocation::count() }}
                            </span>
                            <p class=" mb-0 text-white">عدد التخصيصات</p>
                            {{-- <span class="badge badge-pill badge-success">+15.5%</span> --}}
                        </div>
                        <div class="col-auto ">
                            <span class="fe fe-32 fe-trello text-white mb-0"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow bg-success">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <span class="h2 mb-0">
                                {{ App\Models\Executive::count() }}
                            </span>
                            <p class=" text-white mb-0">عدد التنفيذات</p>
                            {{-- <span class="badge badge-pill badge-success">+15.5%</span> --}}
                        </div>
                        <div class="col-auto">
                            <span class="fe fe-32 fe-watch text-white mb-0"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm bg-primary">
                                <i class="fe fe-16 fe-bar-chart-2 text-white mb-0"></i>
                            </span>
                        </div>
                        <div class="col">
                            <p class="small text-muted mb-0">عدد المؤسسات</p>
                            <span class="h3 mb-0">
                                {{ count(App\Models\Allocation::select('broker_name')->distinct()->pluck('broker_name')->toArray()) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm bg-primary">
                                <i class="fe fe-16 fe-activity text-white mb-0"></i>
                            </span>
                        </div>
                        <div class="col">
                            <p class="small text-muted mb-0">عدد المشاريع</p>
                            <span class="h3 mb-0">
                                {{ count(App\Models\Allocation::select('project_name')->distinct()->pluck('project_name')->toArray()) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm bg-primary">
                                <i class="fe fe-16 fe-users text-white mb-0"></i>
                            </span>
                        </div>
                        <div class="col">
                            <p class="small text-muted mb-0">عدد التجار</p>
                            <span class="h3 mb-0">
                                {{ count(App\Models\Executive::select('account')->distinct()->pluck('account')->toArray()) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mt-4">العام</h2>
    <div class="row mt-4">
        <div class="col-lg-3 col-sm-6 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <a href="{{ route('accreditations.create') }}" class="d-flex flex-column align-items-center p-3">
                        <i class="fe fe-plus" style="font-size: 65px;"></i>
                        <h3> إضافة مشروع جديد</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>



</x-front-layout>
