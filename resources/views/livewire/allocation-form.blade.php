<div class="container-fluid">
    <h3>بيانات التخصيص</h3>
    <div class="row">
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
            <label for="broker_name">المؤسسة</label>
            <select class="form-control text-center" name="broker_name" id="broker_name" wire:model="broker_name">
                <option label="فتح القائمة">
                @foreach ($brokers as $broker)
                    <option value="{{ $broker->name }}" @selected($broker->name == $allocation->broker_name)>{{ $broker->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3"></div>
        <div class="form-group col-md-3">
            <label for="organization_name">المتبرع</label>
            <x-form.input name="organization_name" list="organizations_listA" :value="$allocation->organization_name" required/>
            <datalist id="organizations_listA">
                @foreach ($organizations as $organization)
                    <option value="{{ $organization }}">
                @endforeach
            </datalist>
        </div>
    </div>
    <div class="row">
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
            <x-form.input type="text" min="0" name="quantity" label="الكمية" wire:model="quantity" wire:input="total"  wire:blur="calculate('quantity')" />
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="text" min="0" step="0.01" name="price" label="سعر الوحدة"  wire:model="price" wire:input="total" wire:blur="calculate('price')"  />
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="text" min="0" step="0.01" name="total_dollar" label="الإجمالي" wire:model="total_dollar" readonly/>
        </div>
        <div class="form-group col-md-3">
            <x-form.input  type="text" min="0" step="0.01" name="allocation" label="التخصيص" wire:model="allocation_field" wire:input="allocationFun" required wire:blur="calculate('allocation')"  />
        </div>
        <div class="form-group col-md-3">
            <label for="currency_allocation">العملة</label>
            <select class="form-control text-center" name="currency_allocation" id="currency_allocation" wire:model="currency_allocation" wire:input="changeCurrency">
                <option label="فتح القائمة">
                @foreach ($currencies as $currency)
                    <option value="{{ $currency->code }}" @selected($currency->code == $allocation->currency_allocation || $currency->code == "USD")>{{ $currency->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="text" min="0" required name="currency_allocation_value" label="سعر الدولار للعملة" wire:model="currency_allocation_value" wire:input="allocationFun" wire:blur="calculate('currency_allocation_value')" />
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="number" min="0" step="0.0000001" name="amount" label="المبلغ $" wire:model="amount" readonly/>
            {{-- <x-form.input type="text" name="amount" label="المبلغ $" wire:model="amount" readonly/> --}}
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="text" min="0"  class="calculation" name="number_beneficiaries" label="عدد المستفيدين" :value="$allocation->number_beneficiaries" />
        </div>
        <div class="form-group col-md-6">
            <x-form.textarea name="implementation_items" label="بنوذ التنفيد" :value="$allocation->implementation_items" />
        </div>
    </div>
    <hr>
    <h3>بنود القبض</h3>
    <div class="row">
        <div class="form-group col-md-3">
            <x-form.input type="date" name="date_implementation" label="تاريخ القبض" :value="$allocation->date_implementation" />
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="text" min="0" step="0.01" class="calculation" name="amount_received" label="المبلغ المقبوض" :value="$allocation->amount_received" />
        </div>
        <div class="form-group col-md-6">
            <x-form.textarea name="implementation_statement" label="بيان" :value="$allocation->implementation_statement" />
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="number" min="0" name="arrest_receipt_number" label="رقم إيصال القبض" :value="$allocation->arrest_receipt_number" />
        </div>
    </div>
    <hr>

    <div class="row">
        @if($editForm == true)
        <div class="form-group col-md-3">
            <x-form.input name="user_id" label="اسم المستخدم" :value="($allocation->user->name ?? '')" disabled />
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
    {{-- <div class="form-group col-md-4">
        <x-form.input type="file" name="filesArray[]" label="رفع ملفات للتخصيص" multiple />
    </div> --}}
    @push('scripts')
    <script>
        $(document).ready(function () {
            $('.calculation').on('blur keypress', function (event) {
                // تحقق إذا كان الحدث هو الضغط على مفتاح
                if (event.type == 'keypress' && event.key != "Enter") {
                    return;
                }
                // استرجاع القيمة المدخلة
                var input = $(this).val();
                try {
                    // استخدام eval لحساب الناتج (مع الاحتياطات الأمنية)
                    var result = eval(input);
                    // عرض الناتج في الحقل
                    $(this).val(result);
                } catch (e) {
                    // في حالة وجود خطأ (مثل إدخال غير صحيح)
                    alert('يرجى إدخال معادلة صحيحة!');
                }
            });
        });
    </script>
    @endpush
</div>
