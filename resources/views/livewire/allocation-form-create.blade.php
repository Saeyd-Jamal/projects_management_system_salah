@push('styles')
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
@endpush
<div class="container-fluid">
    <h3>بيانات التخصيص</h3>
    {{-- البيانات المشتركة --}}
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
                    <option value="{{ $broker }}" @selected($broker == $allocation->broker_name)>{{ $broker }}</option>
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



    {{-- المتعددة هنا --}}
    <div>
        <h3 class="mb-4">التخصيصات</h3>
        <input type="hidden" name="num_allo" value="{{ count($field) }}">
        @foreach ($field as $i => $input)
            <div class="row mb-4 border p-3">
                <h4 class="col-12">التخصيص رقم: {{ $i + 1 }}</h4>
    
                <div class="form-group col-md-3">
                    <label for="project_name_{{ $i }}">المشروع</label>
                    <x-form.input name="project_name_{{ $i }}" list="projects_list_{{ $i }}" required />
                    <datalist id="projects_list_{{ $i }}">
                        @foreach ($projects as $project)
                            <option value="{{ $project }}"></option>
                        @endforeach
                    </datalist>
                </div>
    
                <div class="form-group col-md-3">
                    <label for="item_name_{{ $i }}">الصنف</label>
                    <x-form.input name="item_name_{{ $i }}" list="items_list_{{ $i }}" required />
                    <datalist id="items_list_{{ $i }}">
                        @foreach ($items as $item)
                            <option value="{{ $item }}"></option>
                        @endforeach
                    </datalist>
                </div>
    
                <div class="form-group col-md-3">
                    <x-form.input type="text" min="0" name="quantity_{{ $i }}" label="الكمية" 
                        wire:model="field.{{ $i }}.quantity" 
                        wire:input="total({{ $i }})" 
                        wire:blur="calculate({{ $i }}, 'quantity')" />
                </div>
    
                <div class="form-group col-md-3">
                    <x-form.input type="text" min="0" step="0.01" name="price_{{ $i }}" label="سعر الوحدة" 
                        wire:model="field.{{ $i }}.price" 
                        wire:input="total({{ $i }})" 
                        wire:blur="calculate({{ $i }}, 'price')" />
                </div>
    
                <div class="form-group col-md-3">
                    <x-form.input type="text" min="0" step="0.01" name="total_dollar_{{ $i }}" label="الإجمالي" 
                        wire:model="field.{{ $i }}.total_dollar" readonly />
                </div>
    
                <div class="form-group col-md-3">
                    <x-form.input type="text" min="0" step="0.01" name="allocation_{{ $i }}" label="التخصيص" 
                        wire:model="field.{{ $i }}.allocation_field" 
                        wire:input="allocationFun({{ $i }})" 
                        wire:blur="calculate({{ $i }}, 'allocation_field')" />
                </div>
    
                <div class="form-group col-md-3">
                    <label for="currency_allocation_{{ $i }}">العملة</label>
                    <select class="form-control text-center" name="currency_allocation_{{ $i }}" 
                        wire:model="field.{{ $i }}.currency_allocation" 
                        wire:input="changeCurrency({{ $i }})">
                        <option label="اختر العملة"></option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->code }}">{{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>
    
                <div class="form-group col-md-3">
                    <x-form.input type="text" min="0" step="0.01" name="currency_allocation_value_{{ $i }}" label="سعر الدولار للعملة" 
                        wire:model="field.{{ $i }}.currency_allocation_value" 
                        wire:input="allocationFun({{ $i }})" 
                        wire:blur="calculate({{ $i }}, 'currency_allocation_value')" />
                </div>
    
                <div class="form-group col-md-3">
                    <x-form.input type="number" min="0" step="0.0000001" name="amount_{{ $i }}" label="المبلغ $" 
                        wire:model="field.{{ $i }}.amount" readonly />
                </div>
    
                <div class="form-group col-md-3">
                    <x-form.input type="text" min="0" class="calculation" name="number_beneficiaries_{{ $i }}" 
                        label="عدد المستفيدين" />
                </div>
    
                <div class="form-group col-md-6">
                    <x-form.textarea name="implementation_items_{{ $i }}" label="بنود التنفيذ" />
                </div>
    
                <!-- زر الحذف -->
                <div class="form-group col-md-3">
                    <button type="button" class="btn btn-danger mt-3" wire:click="removeAllocation({{ $i }})">حذف</button>
                </div>
            </div>
        @endforeach
    
        <!-- زر الإضافة -->
        <div class="text-center mt-3">
            <button type="button" class="btn btn-primary" wire:click="addAllocation">إضافة تخصيص جديد</button>
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
@push('scripts')
<script>
    const csrf_token = "{{csrf_token()}}";
    const app_link = "{{config('app.url')}}";
</script>
<script src='{{asset('js/select2.min.js')}}'></script>
<script>
    $('#broker_name').select2();
</script>
@endpush
