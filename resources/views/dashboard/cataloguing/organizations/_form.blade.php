<div class="row">
    <div class="form-group col-md-3">
        <x-form.input type="text" name="name" label="اسم المؤسسة" :value="$organization->name" placeholder="إملأ الاسم" autofocus required />
    </div>
    <div class="form-group col-md-3">
        <x-form.input type="email" name="email" label="الإيميل" :value="$organization->email" placeholder="إملأ الإيميل الخاص بالتواصل" />
    </div>
    <div class="form-group col-md-3">
        <x-form.input type="text" name="phone" label="رقم التواصل" :value="$organization->phone" placeholder="إملأ رقم الهاتف الخاص بالتواصل"  />
    </div>
    <div class="form-group col-md-3">
        <x-form.input type="text" name="address" label="العنوان" :value="$organization->address" placeholder="عنوان المؤسسة بالتفصيل" />
    </div>
    <div class="form-group col-md-12">
        <x-form.textarea name="notes" label="الملاحظات" placeholder="ملاجظات عن المؤسسة" :value="$organization->notes" />
    </div>
</div>
<div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary m-0">
        @if (isset($btn_label))
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
    <x-form.input type="file" name="filesArray[]" label="رفع ملفات المؤسسة" multiple />
</div>
