<div class="table-responsive">
    @push('styles')
        <link rel="stylesheet" href="{{asset('css/stickyTable.css')}}">
    @endpush



    <div class="d-flex justify-content-end p-3 align-items-start">
        <button type="button" class="btn btn-secondary" style="margin-left: 10px" id="expandBtn">
            <i class="fa-solid fa-maximize"></i>
        </button>
        <button type="button" class="btn btn-warning" style="margin-left: 10px" id="filterBtn" wire:click="filterBox">
            <i class="fa-solid fa-filter"></i>
        </button>
        @can('create', 'App\\Models\Allocation')
            <a href="{{ route('allocations.create') }}" class="btn btn-primary m-0">
                <i class="fa-solid fa-plus"></i>
            </a>
        @endcan
    </div>
    <div class="container-fluid mb-3" id="filter" style="@if ($filterB == true) display: block; @else display: none; @endif">
        <form method="post" class="col-12">
            @csrf
            <div class="row">
                <div class="form-group col-3">
                    <x-form.input type="number" name="budget_number" label="رقم الموازنة"
                        wire:model="filterArray.budget_number" placeholder="رقم الموزانة : 1212" class="text-center"
                         />
                </div>
                <div class="form-group col-md-3">
                    <x-form.input type="date" name="from_date_allocation" label="من تاريخ التخصيص" required
                        wire:model="filterArray.from_date_allocation"  />
                </div>
                <div class="form-group col-md-3">
                    <x-form.input type="date" name="to_date_allocation" label="الى تاريخ التخصيص" required
                        wire:model="filterArray.to_date_allocation"  />
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
                    <label for="organization_name">المؤسسة</label>
                    <x-form.input name="organization_name" list="organizations_list" wire:model="filterArray.organization_name"/>
                    <datalist id="organizations_list">
                        @foreach ($organizations as $organization)
                            <option value="{{ $organization }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <label for="project_name">المشروع</label>
                    <x-form.input name="project_name" list="projects_list" wire:model="filterArray.project_name"  />
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
        <table class="table align-items-center mb-0 table-hover table-bordered"  id="sticky">
            <thead>
                <tr>
                    <th class="text-secondary opacity-7 text-center">#</th>
                    <th  class="sticky" style="right: 0px;">تاريخ التخصيص</th>
                    <th  class="sticky" style="right: 142px;">رقم الموازنة</th>
                    <th  class="sticky" style="right: 284px;">الاسم المختصر</th>
                    <th  class="sticky" style="right: 426px;">المؤسسة</th>
                    <th  class="sticky" style="right: 568px;">المشروع</th>
                    <th>الصنف</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>إجمالي $</th>
                    <th>التخصيص</th>
                    <th>العملة</th>
                    <th>المبلغ $</th>
                    <th>عدد المستفيدين</th>
                    <th>بنود التنفيد</th>
                    <th>تاريخ القبض</th>
                    <th>بيان</th>
                    <th>المبلغ المقبوض</th>
                    <th>العملة</th>
                    <th>ملاحظات</th>
                    <th>اسم المستخدم</th>
                    <th>المدير المستلم</th>
                    <th></th>
                </tr>
            </thead>
            <style>
                table input,
                table select,
                table textarea {
                    max-width: 100% !important;
                    text-align: center !important;
                    border: none !important;
                    width: 125px !important;
                }

                table textarea {
                    text-align: right !important;
                    width: 200px !important;
                }
            </style>
            <tbody>
                @foreach ($allocations as $index => $allocation)
                    <livewire:allocation-table :allocation="$allocation" :index="$index"
                        wire:key="allocation-{{ $allocation->id }}" />
                @endforeach
            </tbody>
        </table>
        <div>
            @if ($allocations instanceof \Illuminate\Pagination\LengthAwarePaginator)
                @if ($filterCheck != true)
                    {{ $allocations->links() }}
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
                <tbody>
                    <tr>
                        <th>المبالغ المخصصة</th>
                        <td>
                            {{ number_format($amounts_allocated, 2) ?? 0 }}
                        </td>
                    </tr>
                    <tr>
                        <th>المبالغ المستلمة</th>
                        <td>
                            {{ number_format($amounts_received, 2) ?? 0 }}
                        </td>
                    </tr>
                    <tr style="background: #ddd;">
                        <th>المتبقي</th>
                        <td>
                            {{ number_format($remaining, 2) ?? 0 }}
                        </td>
                    </tr>
                    <tr class="text-danger">
                        <th>نسبة التحصيل</th>
                        <td>
                            {{ number_format($collection_rate, 2) ?? 0 }} %
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
