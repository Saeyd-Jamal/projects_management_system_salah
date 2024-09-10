<div class="container-fluid">
    <div class="row">
        <h3>بيانات التنفيذ</h3>
        {{-- <div class="form-group col-md-3">
            <x-form.input type="number" name="budget_number" label="رقم الموازنة" wire:model="budget_number" placeholder="رقم الموزانة : 1212" class="text-center" required wire:input="budget_number_check($event.target.value)" />
            <div id="budget_number_error" class="text-danger" >
                @if ($budget_number_error != '')
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span title="يمكنك جعل الرقم لتخصيص آخر هذا فقط تحذير">{{ $budget_number_error  }}</span>
                @endif
            </div>
        </div> --}}
        <div class="form-group col-md-3">
            <x-form.input type="date" name="implementation_date" label="التاريخ" required wire:model="implementation_date" />
        </div>
        <div class="form-group col-md-3">
            <label for="broker_name">الإسم المختصر</label>
            <x-form.input name="broker_name" list="brokers_list" :value="$executive->broker_name" required />
            <datalist id="brokers_list">
                @foreach ($brokers as $broker)
                    <option value="{{ $broker }}">
                @endforeach
            </datalist>
        </div>
        <div class="form-group col-md-3">
            <x-form.input name="account" label="الحساب" list="account_list" :value="$executive->account" required />
            <datalist id="account_list">
                @foreach ($accounts as $account)
                    <option value="{{ $account }}">
                @endforeach
            </datalist>
        </div>
        <div class="form-group col-md-3">
            <x-form.input name="affiliate_name" label="الاسم" list="affiliate_name_list" :value="$executive->affiliate_name" required />
            <datalist id="affiliate_name_list">
                @foreach ($affiliate_names as $affiliate_name)
                    <option value="{{ $affiliate_name }}">
                @endforeach
            </datalist>
        </div>
        <div class="form-group col-md-3">
            <label for="project_name">المشروع</label>
            <x-form.input name="project_name" list="projects_list" :value="$executive->project_name" required />
            <datalist id="projects_list">
                @foreach ($projects as $project)
                    <option value="{{ $project }}">
                @endforeach
            </datalist>
        </div>
        <div class="form-group col-md-3">
            <x-form.input name="detail" label="التفصيل.." list="detail_list" :value="$executive->detail" />
            <datalist id="detail_list">
                @foreach ($details as $detail)
                    <option value="{{ $detail }}">
                @endforeach
            </datalist>
        </div>
        <div class="form-group col-md-3">
            <label for="item_name">الصنف</label>
            <x-form.input name="item_name" list="items_list" :value="$executive->item_name" required />
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
            <x-form.input type="number" min="0" step="0.01" name="price" label="سعر الوحدة ₪"  wire:model="price" wire:input="total"/>
        </div>
        <div class="form-group col-md-3">
            <x-form.input type="number" min="0" step="0.01" name="total_ils" label="الإجمالي ب ₪" wire:model="total_ils"/>
        </div>
        <div class="form-group col-md-3">
            <x-form.input name="received" label="المستلم" list="received_list" :value="$executive->received" />
            <datalist id="received_list">
                @foreach ($receiveds as $received)
                    <option value="{{ $received }}">
                @endforeach
            </datalist>
        </div>
        <div class="form-group col-md-12">
            <x-form.textarea name="notes" label="ملاجظات" :value="$executive->notes" rows="2" />
        </div>
    </div>
    <hr>
    <div class="row">
        <h3>بنود الدفع</h3>
        <div class="form-group col-md-3">
            <x-form.input type="number" min="0" step="0.01" name="amount_payments" label="الدفعات" :value="$executive->amount_payments"/>
        </div>
        <div class="form-group col-md-6">
            <x-form.textarea name="payment_mechanism" label="آلية الدفع" :value="$executive->payment_mechanism" rows="2"  />
        </div>
    </div>
    <hr>

    <div class="row">
        @if($editForm == true)
        <div class="form-group col-md-3">
            <x-form.input name="user_id" label="اسم المستخدم" :value="$executive->user->name" disabled />
        </div>
        <div class="form-group col-md-3">
            <x-form.input name="manager_name" label="المدير المستلم" :value="$executive->manager_name" disabled />
        </div>
        @endif
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
        <x-form.input type="file" name="filesArray[]" label="رفع ملفات للتنفيذ" multiple />
    </div>

</div>
