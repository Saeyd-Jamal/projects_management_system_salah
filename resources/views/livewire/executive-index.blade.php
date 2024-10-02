<div class="table-responsive"  style="overflow: hidden;">
    @push('styles')
        <link rel="stylesheet" href="{{asset('css/stickyTable.css')}}">
    @endpush


    <div class="d-flex justify-content-end p-3 align-items-start">
        <button type="button" class="btn btn-secondary" style="margin-left: 10px" id="expandBtn">
            <i class="fe fe-maximize"></i>
        </button>
        <button type="button" class="btn btn-warning" style="margin-left: 10px" id="filterBtn" wire:click="filterBox">
            <i class="fe fe-filter"></i>
        </button>
        @can('create','App\\Models\Executive')
        <a href="{{route('executives.create')}}" class="btn btn-primary m-0">
            <i class="fe fe-plus"></i>
        </a>
        @endcan
    </div>
    <div class="container-fluid mb-3" id="filter" style="@if($filterB == true) display: block; @else display: none; @endif">
        <form method="post" class="col-12">
            @csrf
            <div class="row">
                <div class="form-group col-md-3">
                    <x-form.input type="date" name="from_implementation_date" label="من تاريخ" required wire:model="filterArray.from_implementation_date" />
                </div>
                <div class="form-group col-md-3">
                    <x-form.input type="date" name="to_implementation_date" label="الى تاريخ" required wire:model="filterArray.to_implementation_date" />
                </div>
                <div class="form-group col-md-3">
                    <label for="broker_name">الإسم المختصر</label>
                    <x-form.input name="broker_name" list="brokers_list" wire:model="filterArray.broker_name" />
                    <datalist id="brokers_list">
                        @foreach ($brokers as $broker)
                            <option value="{{ $broker }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input name="account" label="الحساب" list="account_list" wire:model="filterArray.account" />
                    <datalist id="account_list">
                        @foreach ($accounts as $account)
                            <option value="{{ $account }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input name="affiliate_name" label="الاسم" list="affiliate_name_list" wire:model="filterArray.affiliate_name" />
                    <datalist id="affiliate_name_list">
                        @foreach ($affiliates as $affiliate_name)
                            <option value="{{ $affiliate_name }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <label for="project_name">المشروع</label>
                    <x-form.input name="project_name" list="projects_list" wire:model="filterArray.project_name" />
                    <datalist id="projects_list">
                        @foreach ($projects as $project)
                            <option value="{{ $project }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <label for="item_name">الصنف</label>
                    <x-form.input name="item_name" list="items_list" wire:model="filterArray.item_name" />
                    <datalist id="items_list">
                        @foreach ($items as $item)
                            <option value="{{ $item }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input name="received" label="المستلم" list="received_list" wire:model="filterArray.received_name" />
                    <datalist id="received_list">
                        @foreach ($receiveds as $received)
                            <option value="{{ $received }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <label for="paginationItems">عدد السجلات</label>
                    <select class="form-control" name="paginationItems" id="paginationItems" wire:model="paginationItems"
                        wire:input="filter">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="all">الكل</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="reset" class="btn btn-warning" style="margin-left: 15px" wire:click="filter">مسح التصفية</button>
                <button type="button" class="btn btn-info" wire:click="filter">بحث</button>
            </div>
        </form>
    </div>
    <div class="table-container">
        <table class="table align-items-center mb-0 table-hover table-bordered" id="sticky">
            <thead>
                <tr>
                    <th class="text-secondary opacity-7 text-center">#</th>
                    <th  class="sticky" style="right: 0px;">التاريخ</th>
                    {{-- <th>رقم الموازنة</th> --}}
                    <th  class="sticky" style="right: 142px;">المؤسسة</th>
                    <th class="sticky" style="right: 284px;" >الحساب</th>
                    <th class="sticky" style="right: 426px;">الاسم</th>
                    <th>المشروع</th>
                    <th>التفصيل..</th>
                    <th>الصنف</th>
                    <th>الكمية</th>
                    <th>السعر ₪</th>
                    <th>إجمالي ₪</th>
                    <th>المستلم</th>
                    <th>ملاحظات</th>
                    <th>الدفعات</th>
                    <th>آلية الدفع</th>
                    <th>اسم المستخدم</th>
                    <th>المدير المستلم</th>
                    <th></th>
                </tr>
            </thead>
            <style>
                table input,table select,table textarea{
                    max-width: 100% !important;
                    text-align: center !important;
                    border: none !important;
                    width: 125px !important;
                }
                table textarea{
                    text-align: right !important;
                    width: 200px !important;
                }
            </style>
            <tbody>
                @foreach ($executives as $index => $executive)
                    <livewire:executive-table :executive="$executive"  :index="$index" wire:key="executive-{{ $executive->id }}"  />
                @endforeach
            </tbody>
        </table>
        <div>
            @if ($executives instanceof \Illuminate\Pagination\LengthAwarePaginator)
                @if ($filterCheck != true)
                    {{ $executives->links() }}
                @endif
            @else
                {{-- إذا لم يكن هناك روابط --}}
            @endif
        </div>
    </div>
    {{-- مجموع المبالغ --}}
    <div class="row justify-content-end m-3">
        <div class="col-3">
            <table class="table align-items-center mb-0 table-hover table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>بالشيكل</th>
                        <th>بالدولار</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th>اجمالي مبالغ شيكل</th>
                        <td>
                            {{number_format($total_amounts,2) ?? 0}}
                        </td>
                        <td class="text-danger">
                            {{number_format($total_amounts * $ILS,2) ?? 0}}
                        </td>
                    </tr>
                    <tr>
                        <th>اجمالي الدفعات شيكل</th>
                        <td>
                            {{number_format($total_payments,2) ?? 0}}
                        </td>
                        <td class="text-danger">
                            {{ number_format($ILS * $total_payments,2) ?? 0}}
                        </td>
                    </tr>
                    <tr>
                        <th>الرصيد المتبقي شيكل</th>
                        <td>
                            {{number_format($remaining_balance,2) ?? 0}}
                        </td>
                        <td class="text-danger">
                            {{ number_format($ILS * $remaining_balance,2) ?? 0}}
                        </td>
                    </tr>
                    <tr class="text-danger">
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
