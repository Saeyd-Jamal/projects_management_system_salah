<div class="container-fluid">
    <div class="row">
        <h3>بيانات التخصيص</h3>
        <div class="form-group col-md-3">
            <x-form.input type="number" name="budget_number" label="رقم الموازنة" wire:model="budget_number" placeholder="رقم الموزانة : 1212" class="text-center" required wire:input="budget_number_check($event.target.value)" />
            <div id="budget_number_error" class="text-danger" >
                @if ($budget_number_error != '')
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span title="يمكنك جعل الرقم لتخصيص آخر هذا فقط تحذير">{{ $budget_number_error  }}</span>
                @endif
            </div>
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="date" name="date_allocation" label="تاريخ التخصيص" required wire:model="date_allocation" />
        </div>
        <div class="form-group col-md-3">
            <label for="broker_name">الإسم المختصر</label>
            <x-form.input name="broker_name" list="brokers_list" :value="$allocation->broker_name" required/>
            <datalist id="brokers_list">
                @foreach ($brokers as $broker)
                    <option value="{{ $broker }}">
                @endforeach
            </datalist>
        </div>
        <div class="form-group col-md-3">
            <label for="organization_name">المؤسسة</label>
            <x-form.input name="organization_name" list="organizations_list" :value="$allocation->organization_name" required/>
            <datalist id="organizations_list">
                @foreach ($organizations as $organization)
                    <option value="{{ $organization }}">
                @endforeach
            </datalist>
        </div>
        <div class="form-group col-md-3">
            <label for="project_name">المشروع</label>
            <x-form.input name="project_name" list="projects_list" :value="$allocation->project_name" required />
            <datalist id="projects_list">
                @foreach ($projects as $project)
                    <option value="{{ $project }}">
                @endforeach
            </datalist>
        </div>
        <div class="form-group col-md-3">
            <label for="item_name">الصنف</label>
            <x-form.input name="item_name" list="items_list" :value="$allocation->item_name" required />
            <datalist id="items_list">
                @foreach ($items as $item)
                    <option value="{{ $item }}">
                @endforeach
            </datalist>
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="number" min="0" name="quantity" label="الكمية" wire:model="quantity" wire:input="total"/>
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="number" min="0" step="0.01" name="price" label="سعر الوحدة$"  wire:model="price" wire:input="total"  />
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="number" min="0" step="0.01" name="total_dollar" label="الإجمالي ب $" wire:model="total_dollar" readonly/>
        </div>
        <div class="form-group col-md-3">
            <x-form.input  type="number" min="0" step="0.01" name="allocation" label="التخصيص" wire:model="allocation_field" wire:input="allocationFun" required />
        </div>
        <div class="form-group col-md-3">
            <label for="currency_allocation">العملة</label>
            <select class="form-select text-center" name="currency_allocation" id="currency_allocation" wire:model="currency_allocation" wire:input="allocationFun">
                <option label="فتح القائمة">
                @foreach ($currencies as $currency)
                    <option value="{{ $currency->code }}" @selected($currency->code == $allocation->currency_allocation || $currency->code == "USD")>{{ $currency->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="number" min="0" step="0.01" name="amount" label="المبلغ $" wire:model="amount" readonly/>
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="number" min="0" name="number_beneficiaries" label="عدد المستفيدين" :value="$allocation->number_beneficiaries"/>
        </div>
        <div class="form-group col-md-6">
            <x-form.textarea name="implementation_items" label="بنوذ التنفيد" :value="$allocation->implementation_items" />
        </div>
    </div>
    <hr>
    <div class="row">
        <h3>بنود القبض</h3>
        <div class="form-group col-md-3">
            <x-form.input type="date" name="date_implementation" label="تاريخ القبض" :value="$allocation->date_implementation" />
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="number" min="0" step="0.01" name="amount_received" label="المبلغ المقبوض" :value="$allocation->amount_received"/>
        </div>
        <div class="form-group col-md-3">
            <label for="currency_received">العملة</label>
            <select class="form-select text-center" name="currency_received" id="currency_received" wire:model="currency_received">
                <option label="فتح القائمة">
                @foreach ($currencies as $currency)
                    <option value="{{ $currency->code }}" @selected($currency->code == $allocation->currency_received || $currency->code == "USD")>{{ $currency->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <x-form.textarea name="implementation_statement" label="بيان" :value="$allocation->implementation_statement" />
        </div>
    </div>
    <hr>

    <div class="row">
        @if($editForm == true)
        <div class="form-group col-md-3">
            <x-form.input name="user_id" label="اسم المستخدم" :value="$allocation->user->name" disabled />
        </div>
        <div class="form-group col-md-3">
            <x-form.input name="manager_name" label="المدير المستلم" :value="$allocation->manager_name" disabled />
        </div>
        @endif
        <div class="form-group col-md-12">
            <x-form.textarea name="notes" label="ملاجظات عن التخصيص" :value="$allocation->notes" />
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary m-0">
            @if ($btn_label != null)
                <i class="fa-solid fa-pen-to-square"></i>
                {{$btn_label}}
            @else
                <i class="fa-solid fa-plus"></i>
                اضافة
            @endif
        </button>
    </div>
    <div class="form-group col-md-4">
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>
        <x-form.input type="file" name="filesArray[]" label="رفع ملفات للتخصيص" multiple />
    </div>

</div>
