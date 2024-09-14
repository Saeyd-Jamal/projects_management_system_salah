<div class="table-responsive">
    <div class="d-flex justify-content-end p-3 align-items-start">
        <button type="button" class="btn btn-secondary" style="margin-left: 10px" id="expandBtn">
            <i class="fa-solid fa-maximize"></i>
        </button>
        <button type="button" class="btn btn-warning" style="margin-left: 10px" id="filterBtn">
            <i class="fa-solid fa-filter"></i>
        </button>
        @can('create','App\\Models\Allocation')
        <a href="{{route('allocations.create')}}" class="btn btn-primary m-0">
            <i class="fa-solid fa-plus"></i>
        </a>
        @endcan
    </div>
    <div class="container-fluid mb-3" id="filter" style="display: none">
        <form method="post" class="col-12">
            @csrf
            <div class="row">
                <div class="form-group col-3">
                    <x-form.input type="number" name="budget_number" label="رقم الموازنة" wire:model="filterArray.budget_number" placeholder="رقم الموزانة : 1212" class="text-center" wire:input="filter"/>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input type="date" name="from_date_allocation" label="من تاريخ التخصيص" required wire:model="filterArray.from_date_allocation" wire:input="filter" />
                </div>
                <div class="form-group col-md-3">
                    <x-form.input type="date" name="to_date_allocation" label="الى تاريخ التخصيص" required wire:model="filterArray.to_date_allocation" wire:input="filter" />
                </div>
                <div class="form-group col-md-3">
                    <label for="broker">الاسم المختصر</label>
                    <select class="form-select text-center" name="broker" id="broker" wire:model="filterArray.broker_name" wire:input="filter">
                        <option label="فتح القائمة">
                        @foreach ($brokers as $broker_name)
                            <option value="{{ $broker_name }}">{{ $broker_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="organization">المؤسسة</label>
                    <select class="form-select text-center" name="organization" id="organization" wire:model="filterArray.organization_name" wire:input="filter">
                        <option label="فتح القائمة">
                        @foreach ($organizations as $organization_name)
                            <option value="{{ $organization_name }}">{{ $organization_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="project">المشروع</label>
                    <select class="form-select text-center" name="project" id="project" wire:model="filterArray.project_name" wire:input="filter">
                        <option label="فتح القائمة">
                        @foreach ($projects as $project_name)
                            <option value="{{ $project_name }}">{{ $project_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="item">الصنف</label>
                    <select class="form-select text-center" name="item" id="item" wire:model="filterArray.item_name" wire:input="filter">
                        <option label="فتح القائمة">
                        @foreach ($items as $item_name)
                            <option value="{{ $item_name }}">{{ $item_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div>
        <table class="table align-items-center mb-0 table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-secondary opacity-7 text-center">#</th>
                    <th>تاريخ التخصيص</th>
                    <th>رقم الموازنة</th>
                    <th>الاسم المختصر</th>
                    <th>المؤسسة</th>
                    <th>المشروع</th>
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
                @foreach ($allocations as  $index => $allocation)
                    <livewire:allocation-table :allocation="$allocation" :index="$index" wire:key="allocation-{{ $allocation->id }}"  />
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $allocations->links() }}
        </div>
    </div>
</div>
