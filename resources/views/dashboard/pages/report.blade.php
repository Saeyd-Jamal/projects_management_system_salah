<x-front-layout>
    @push('styles')
    <link rel="stylesheet" href="{{asset('css/select2.css')}}">
    @endpush
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">التقارير</li>
    </x-slot:breadcrumb>
    <div class="card">
        <div class="card-header pb-0">
            <h2 class="h page-title">إنتاج التقارير</h2>
        </div>
        <div class="card-body">
            <div class="row justify-content-between">
                <form action="{{route('reports.export')}}" method="post" class="col-12" target="_blank">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3">
                            <x-form.input type="month" :value="date('Y-m')" name="month" label="الشهر المطلوب (الشهر الاول)" />
                        </div>
                        <div class="form-group col-md-3">
                            <x-form.input type="month"  name="to_month" label="الى شهر" />
                        </div>
                        <div class="form-group col-md-3">
                            <label for="broker">الاسم المختصر</label>
                            <select name="broker[]" id="broker" class="form-control select2-multi" multiple>
                                @foreach ($brokers as $broker)
                                    <option value="{{ $broker }}">{{ $broker }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="organization">المؤسسة</label>
                            <select name="organization[]" id="organization" class="form-control select2-multi" multiple>
                                @foreach ($organizations as $organization)
                                    <option value="{{ $organization }}">{{ $organization }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="project">المشروع</label>
                            <select name="project[]" id="project" class="form-control select2-multi" multiple>
                                @foreach ($projects as $project)
                                    <option value="{{ $project }}">{{ $project }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="item">الصنف</label>
                            <select name="item[]" id="item" class="form-control select2-multi" multiple>
                                @foreach ($items as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="account">الحساب</label>
                            <select name="account[]" id="account" class="form-control select2-multi" multiple>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account }}">{{ $account }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="affiliate">الاسم</label>
                            <select name="affiliate[]" id="affiliate" class="form-control select2-multi" multiple>
                                @foreach ($affiliates as $affiliate)
                                    <option value="{{ $affiliate }}">{{ $affiliate }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="received">المستلم</label>
                            <select name="received[]" id="received" class="form-control select2-multi" multiple>
                                @foreach ($receiveds as $received)
                                    <option value="{{ $received }}">{{ $received }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- إضافات --}}
                        <div class="form-group col-md-3">
                            <label for="report_type">نوع الكشف</label>
                            <select class="form-control " name="report_type" id="report_type" required>
                                <option  value="" disabled selected>حدد نوع الكشف</option>
                                <optgroup label="الكشوفات الأساسية">
                                    <option value="brokers_balance">كشف ارصدة المؤسسات الداعمة</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="export_type">طريقة التصدير</label>
                            <select class="form-control " name="export_type" id="export_type">
                                <option selected="" value="view">معاينة</option>
                                <option value="export_pdf">PDF</option>
                                <option value="export_excel">Excel</option>
                            </select>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col">
                            <h2 class="h5 page-title"></h2>
                        </div>
                        <div class="col-auto">
                            <button type="reset"  class="btn btn-danger">
                                مسح
                            </button>
                            <button type="submit"  class="btn btn-primary">
                                تصدير
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        const csrf_token = "{{csrf_token()}}";
        const app_link = "{{config('app.url')}}";
    </script>
    {{-- <script src="{{asset('js/report.js')}}"></script> --}}
    <script src='{{asset('js/select2.min.js')}}'></script>
    <script>
        $('.select2-multi').select2(
        {
            multiple: true,
        });
    </script>
    @endpush

</x-front-layout>
