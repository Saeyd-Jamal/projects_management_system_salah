<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="#">الرئيسية</a></li>
    </x-slot:breadcrumb>

    {{-- <div class="row">
        <div class="col-lg-3 col-sm-6 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">أموال اليوم</p>
                                <h5 class="font-weight-bolder mb-0">
                                    $53,000
                                    <span class="text-success text-sm font-weight-bolder">+55%</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-start">
                            <div
                                class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">مستخدمو اليوم</p>
                                <h5 class="font-weight-bolder mb-0">
                                    2,300
                                    <span class="text-success text-sm font-weight-bolder">+33%</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-start">
                            <div
                                class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">عملاء جدد</p>
                                <h5 class="font-weight-bolder mb-0">
                                    +3,462
                                    <span class="text-danger text-sm font-weight-bolder">-2%</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-start">
                            <div
                                class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">مبيعات</p>
                                <h5 class="font-weight-bolder mb-0">
                                    $103,430
                                    <span class="text-success text-sm font-weight-bolder">+5%</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-start">
                            <div
                                class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <h2>العام</h2>
    <div class="row mt-4">
        <div class="col-lg-3 col-sm-6 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <a href="{{route('accreditations.create')}}" class="d-flex flex-column align-items-center p-3">
                        <i class="fe fe-plus" style="font-size: 65px;"></i>
                        <h3> إضافة مشروع جديد</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>

</x-front-layout>
