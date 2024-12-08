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
                                {{ $allocations_count }}
                            </span>
                            <p class=" mb-0 text-white">عدد التخصيصات</p>
                            {{-- <span class="badge badge-pill badge-success">+15.5%</span> --}}
                        </div>
                        <div class="col-auto ">
                            <span class="fe fe-32 fe-trello text-white mb-0"></span>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-12">
                            <table class="table align-items-center mb-0 table-bordered">
                                <tbody  style=" color: #fff;">
                                    <tr>
                                        <th  style="background: #27AE60;">المبالغ المخصصة</th>
                                        <td  style="background: #ddd; color: #000;">
                                            {{ number_format($total_amount, 2) ?? 0 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th  style="background: #27AE60;">المبالغ المستلمة</th>
                                        <td  style="background: #ddd; color: #000;">
                                            {{ number_format($total_amount_received, 2) ?? 0 }}
                                        </td>
                                    </tr>
                                    <tr style="background: #ddd; color: #000;">
                                        <th >المتبقي</th>
                                        <td >
                                            {{ number_format($total_amount - $total_amount_received, 2) ?? 0 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        @php
                                            $total_amount = $total_amount == 0 ? 1 : $total_amount;
                                        @endphp
                                        <th style="background: #C0392B;">نسبة التحصيل</th>
                                        <td style="color: #C0392B; background: #ddd;">
                                            <span class="remaining_percent">
                                                {{ number_format(($total_amount_received / $total_amount) * 100, 2) ?? 0 }}
                                            </span>%
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
                                {{ $executives_count }}
                            </span>
                            <p class=" text-white mb-0">عدد التنفيذات</p>
                            {{-- <span class="badge badge-pill badge-success">+15.5%</span> --}}
                        </div>
                        <div class="col-auto">
                            <span class="fe fe-32 fe-watch text-white mb-0"></span>
                        </div>
                    </div>
                    <div class="row justify-content-end my-3">
                        <div class="col-12">
                            <table class="table align-items-center mb-0 table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th style="background: #27AE60;color: #000">بالشيكل</th>
                                        <th style="background: #C0392B;color: #fff !important;">بالدولار</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th style="background: #27AE60;">اجمالي مبالغ شيكل</th>
                                        <td style="background: #17a2b8; color: #fff;" class="total_total_ils">
                                            {{ number_format($total_ils, 2) ?? 0 }}
                                        </td>
                                        <td class="total_total_dollars" style="background: #ddd; color: #000;">
                                            {{ number_format($total_ils / $ILS, 2) ?? 0 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="background: #27AE60;">اجمالي الدفعات شيكل</th>
                                        <td style="background: #17a2b8;  color: #fff;" class="total_amount_payments">
                                            {{ number_format($total_amount_payments, 2) ?? 0 }}
                                        </td>
                                        <td class="total_amount_payments_dollars" style="background: #ddd; color: #000;">
                                            {{ number_format($total_amount_payments / $ILS, 2) ?? 0 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="background: #27AE60;">الرصيد المتبقي شيكل</th>
                                        <td  style="background: #17a2b8;  color: #fff;" class="remaining">
                                            {{ number_format($total_ils - $total_amount_payments, 2) ?? 0 }}
                                        </td>
                                        <td class="remaining_dollars" style="background: #ddd; color: #000;">
                                            {{ number_format(($total_ils - $total_amount_payments) / $ILS, 2) ?? 0 }}
                                        </td>
                                    </tr>
                                    <tr class="text-danger" style="background: #ddd">
                                        <th colspan="2">سعر الدولار / الشيكل</th>
                                        <td>
                                            {{number_format(1 / $ILS,2) ?? 0}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
