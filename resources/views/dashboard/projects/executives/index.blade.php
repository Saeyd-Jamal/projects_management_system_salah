<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">التنفيذات</li>
    </x-slot:breadcrumb>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <div class="d-flex justify-content-end p-3 align-items-start">
                        <button type="button" class="btn btn-secondary" style="margin-left: 10px" id="expandBtn">
                            <i class="fa-solid fa-maximize"></i>
                        </button>
                        @can('create','App\\Models\Executive')
                        <a href="{{route('executives.create')}}" class="btn btn-primary m-0">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                        @endcan
                    </div>
                    <div>
                        <table class="table align-items-center mb-0 table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-secondary opacity-7 text-center">#</th>
                                    <th>التاريخ</th>
                                    {{-- <th>رقم الموازنة</th> --}}
                                    <th>المؤسسة</th>
                                    <th>الحساب</th>
                                    <th>الاسم</th>
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
                                input,select,textarea{
                                    max-width: 100% !important;
                                    text-align: center !important;
                                    border: none !important;
                                    width: 125px !important;
                                }
                                textarea{
                                    text-align: right !important;
                                    width: 200px !important;
                                }
                            </style>
                            <tbody>
                                @foreach ($executives as $index => $executive)
                                    <livewire:executive-table :executive="$executive"  :index="$index"  />
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $executives->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#expandBtn', function() {
                $('nav.navbar').css('display', 'none');
                $('aside').css('display', 'none');
                $('.main-content').css('margin', '0');
                $(this).html('<i class="fa-solid fa-minimize"></i>');
                $(this).attr('id', 'collapseBtn');
            });

            $(document).on('click', '#collapseBtn', function() {
                console.log('clicked');
                $('nav.navbar').css('display', 'block');
                $('aside').css('display', 'block');
                $('.main-content').css('margin-right', '17.125rem');
                $(this).html('<i class="fa-solid fa-maximize"></i>');
                $(this).attr('id', 'expandBtn');
            });
        });
    </script>
    @endpush
</x-front-layout>
