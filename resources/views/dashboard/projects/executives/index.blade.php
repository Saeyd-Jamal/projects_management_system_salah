<x-front-layout>
    @push('styles')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}
        <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.css')}}">
        <link id="stickyTableLight" rel="stylesheet" href="{{ asset('css/stickyTable.css') }}">
        <link id="stickyTableDark" rel="stylesheet" href="{{ asset('css/stickyTableDark.css') }}" disabled>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <style>
            body{
                font-family: 'Cairo', sans-serif;
            }
            .main-content{
                margin: 15px 0 0 0 !important;
            }
            table.dataTable th, table.dataTable td {
                box-sizing: content-box !important;
                white-space: nowrap !important;
            }
            /* تعطيل مؤشر الفرز لرأس العمود */
            th.no-sort::after {
                display: none !important;
            }
            .breadcrumb{
                display: none !important;
            }
            .filter-dropdown{
                display: none;
            }
            .dataTables_filter{
                display: none;
            }
            tbody tr td{
                padding: 3px 8px !important;
            }
        </style>
    @endpush
    <x-slot:extra_nav>
        <li class="nav-item">
            <a href="{{ route('executives.create') }}" class="btn btn-info btn-icon text-white my-2">
                <i class="fe fe-plus fe-16"></i>
            </a>
        </li>
        <li class="nav-item">
            <button class="btn btn-warning btn-icon text-white my-2 mx-3" id="filterBtn">
                <i class="fe fe-filter fe-16"></i>
            </button>
        </li>
    </x-slot:extra_nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-container p-0">
                    <table id="executives-table" class="table table-striped table-bordered table-hover sticky" style="width:100%; height: calc(100vh - 100px);">
                        <thead>
                                {{-- <th class="sticky" style="right:  220px;">
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>الاسم المختصر</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="border:1px solid #ced4da;" type="button" id="broker_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-filter text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="broker_filter">
                                                    <input type="text" name="broker_name" class="form-control mr-2  py-0 px-2" list="brokers_list" style="width: 200px"/>
                                                    <datalist id="brokers_list">
                                                        @foreach ($brokers as $broker)
                                                            <option value="{{$broker}}" >
                                                        @endforeach
                                                    </datalist>
                                                    <div>
                                                        <button class='btn btn-success text-white filter-apply-btn' data-target="4" data-field="broker_name">
                                                            <i class='fe fe-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th> --}}
                            <tr>
                                <th></th>
                                <th class="text-white  opacity-7 text-center sticky" style="right: 0px;">#</th>
                                <th class="sticky" style="right: 71.7px;">
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>التاريخ</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="border:1px solid #ced4da;" type="button" id="date_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-filter text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="date_filter">
                                                    <div>
                                                        <input type="date" id="from_date" name="from_implementation_date" class="form-control mr-2" style="width: 200px"/>
                                                        <input type="date" id="to_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" name="to_implementation_date" class="form-control mr-2 mt-2" style="width: 200px"/>
                                                    </div>
                                                    <div>
                                                        <button id="filter-date-btn" class='btn btn-success text-white filter-apply-btn-data' data-target="2" data-field="implementation_date">
                                                            <i class='fe fe-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th  class="sticky" style="right: 167.3px;">
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>المؤسسة</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="border:1px solid #ced4da;" type="button" id="broker_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-filter text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="broker_filter">
                                                    <input type="text" name="broker_name" class="form-control mr-2  py-0 px-2" list="brokers_list" style="width: 200px"/>
                                                    <datalist id="brokers_list">
                                                        @foreach ($brokers as $broker)
                                                            <option value="{{$broker}}" >
                                                        @endforeach
                                                    </datalist>
                                                    <div>
                                                        <button class='btn btn-success text-white filter-apply-btn' data-target="4" data-field="broker_name">
                                                            <i class='fe fe-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th class="sticky" style="right: 344px;">
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>الحساب</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="border:1px solid #ced4da;" type="button" id="account_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-filter text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="account_filter">
                                                    <input type="text" name="account_name" class="form-control mr-2  py-0 px-2" list="accounts_list" style="width: 200px"/>
                                                    <datalist id="accounts_list">
                                                        @foreach ($accounts as $account)
                                                            <option value="{{$account}}" >
                                                        @endforeach
                                                    </datalist>
                                                    <div>
                                                        <button class='btn btn-success text-white filter-apply-btn' data-target="5" data-field="account_name">
                                                            <i class='fe fe-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>الاسم</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="border:1px solid #ced4da;" type="button" id="affiliate_name_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-filter text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="affiliate_name_filter">
                                                    <input type="text" name="affiliate_name" class="form-control mr-2  py-0 px-2" list="affiliate_names_list" style="width: 200px"/>
                                                    <datalist id="affiliate_names_list">
                                                        @foreach ($affiliates as $affiliate)
                                                            <option value="{{$affiliate}}" >
                                                        @endforeach
                                                    </datalist>
                                                    <div>
                                                        <button class='btn btn-success text-white filter-apply-btn' data-target="5" data-field="affiliate_name">
                                                            <i class='fe fe-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>المشروع</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="border:1px solid #ced4da;" type="button" id="project_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-filter text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="project_filter">
                                                    <input type="text" name="project_name" class="form-control mr-2  py-0 px-2" list="projects_list" style="width: 200px"/>
                                                    <datalist id="projects_list">
                                                        @foreach ($projects as $project)
                                                            <option value="{{$project}}" >
                                                        @endforeach
                                                    </datalist>
                                                    <div>
                                                        <button class='btn btn-success text-white filter-apply-btn' data-target="6" data-field="project_name">
                                                            <i class='fe fe-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>التفصيل..</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="border:1px solid #ced4da;" type="button" id="detail_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-filter text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="detail_filter">
                                                    <input type="text" name="detail_name" class="form-control mr-2  py-0 px-2" list="details_list" style="width: 200px"/>
                                                    <datalist id="details_list">
                                                        @foreach ($details as $detail)
                                                            <option value="{{$detail}}" >
                                                        @endforeach
                                                    </datalist>
                                                    <div>
                                                        <button class='btn btn-success text-white filter-apply-btn' data-target="7" data-field="detail_name">
                                                            <i class='fe fe-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>الصنف</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="border:1px solid #ced4da;" type="button" id="item_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-filter text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="item_filter">
                                                    <input type="text" name="item_name" class="form-control mr-2  py-0 px-2" list="items_list" style="width: 200px"/>
                                                    <datalist id="items_list">
                                                        @foreach ($items as $item)
                                                            <option value="{{$item}}" >
                                                        @endforeach
                                                    </datalist>
                                                    <div>
                                                        <button class='btn btn-success text-white filter-apply-btn' data-target="8" data-field="item_name">
                                                            <i class='fe fe-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>الكمية</th>
                                <th>السعر ₪</th>
                                <th>إجمالي ₪</th>
                                <th>
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>المستلم</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="border:1px solid #ced4da;" type="button" id="received_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-filter text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="received_filter">
                                                    <input type="text" name="received_name" class="form-control mr-2  py-0 px-2" list="receiveds_list" style="width: 200px"/>
                                                    <datalist id="receiveds_list">
                                                        @foreach ($receiveds as $received)
                                                            <option value="{{$received}}" >
                                                        @endforeach
                                                    </datalist>
                                                    <div>
                                                        <button class='btn btn-success text-white filter-apply-btn' data-target="12" data-field="received_name">
                                                            <i class='fe fe-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>ملاحظات</th>
                                <th>الدفعات</th>
                                <th>آلية الدفع</th>
                                <th>اسم المستخدم</th>
                                <th>المدير المستلم</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td class="text-white opacity-7 text-center" id="count_executives"></td>
                                <td class='sticky text-right' colSpan="3">المجموع</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class='text-white' id="total_quantity"></td>
                                <td></td>
                                <td class='text-white total_total_ils'></td>
                                <td></td>
                                <td></td>
                                <td class='text-white total_amount_payments'></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- مجموع المبالغ --}}
    <div class="row justify-content-end m-3">
        <div class="col-3">
            <table class="table align-items-center mb-0 table-hover table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th style="background: #27AE60;color: #000">بالشيكل</th>
                        <th style="background: #C0392B;color: #fff !important;">بالدولار</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th style="background: #27AE60;">اجمالي مبالغ شيكل</th>
                        <td style="background: #17a2b8; color: #fff;" class="total_total_ils">
                        </td>
                        <td class="text-danger total_total_dollars" style="background: #ddd">
                        </td>
                    </tr>
                    <tr>
                        <th style="background: #27AE60;">اجمالي الدفعات شيكل</th>
                        <td style="background: #17a2b8;  color: #fff;" class="total_amount_payments">
                        </td>
                        <td class="text-danger total_amount_payments_dollars" style="background: #ddd">
                        </td>
                    </tr>
                    <tr>
                        <th style="background: #27AE60;">الرصيد المتبقي شيكل</th>
                        <td  style="background: #17a2b8;  color: #fff;" class="remaining">
                        </td>
                        <td class="text-danger remaining_dollars" style="background: #ddd">
                        </td>
                    </tr>
                    <tr class="text-danger" style="background: #ddd">
                        <th colspan="2">سعر الدولار / الشيكل</th>
                        <td>
                            {{number_format(1 / $ILS,2) ?? 0}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



    @push('scripts')
    <!-- DataTables JS -->
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            let ils = {{ $ILS }};
            let formatNumber = (number,min = 0) => {
                // التحقق إذا كانت القيمة فارغة أو غير صالحة كرقم
                if (number === null || number === undefined || isNaN(number)) {
                    return ''; // إرجاع قيمة فارغة إذا كان الرقم غير صالح
                }
                return new Intl.NumberFormat('en-US', { minimumFractionDigits: min, maximumFractionDigits: 2 }).format(number);
            };
            let table = $('#executives-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                paging: false,              // تعطيل الترقيم
                searching: true,            // الإبقاء على البحث إذا كنت تريده
                info: false,                // تعطيل النص السفلي الذي يوضح عدد السجلات
                lengthChange: false,        // تعطيل قائمة تغيير عدد المدخلات
                "language": {
                    "url": "{{ asset('files/Arabic.json')}}"
                },
                ajax: {
                    url: "{{ route('executives.index') }}",
                    data: function (d) {
                        // إضافة تواريخ التصفية إلى الطلب المرسل
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                    }
                },
                columns: [
                    { data: 'edit', name: 'edit', orderable: false, searchable: false, render: function(data, type, row) {
                            let link = `<a href="{{ route('executives.edit', ':executive') }}"
                            class="btn btn-sm btn-primary">تعديل <i class="fa fa-edit"></i></a>`.replace(':executive', data);
                            return link ;
                        }
                    },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, class: 'sticky'}, // عمود الترقيم التلقائي
                    { data: 'implementation_date', name: 'implementation_date'  , orderable: false, class: 'sticky'},
                    { data: 'broker_name', name: 'broker_name' , orderable: false, class: 'sticky' },
                    { data: 'account', name: 'account' , orderable: false, class: 'sticky' },
                    { data: 'affiliate_name', name: 'affiliate_name' , orderable: false},
                    { data: 'project_name', name: 'project_name', orderable: false, searchable: false },
                    { data: 'detail', name: 'detail'  , orderable: false},
                    { data: 'item_name', name: 'item_name'  , orderable: false},
                    { data: 'quantity', name: 'quantity'  , orderable: false},
                    { data: 'price', name: 'price'  , orderable: false},
                    { data: 'total_ils', name: 'total_ils'  , orderable: false},
                    { data: 'received', name: 'received'  , orderable: false},
                    { data: 'notes', name: 'notes'  , orderable: false,},
                    { data: 'amount_payments', name: 'amount_payments'  , orderable: false},
                    { data: 'payment_mechanism', name: 'payment_mechanism'  , orderable: false},
                    { data: 'user_name', name: 'user_name'  , orderable: false,},
                    { data: 'manager_name', name: 'manager_name'  , orderable: false,},
                    {
                        data: 'delete',
                        name: 'delete',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `
                                <button
                                    class="btn btn-danger text-white delete_row"
                                    data-id="${data}">
                                    <i class="fe fe-trash"></i>
                                </button>`;
                        },
                    },
                ],
                columnDefs: [
                    { targets: 1, searchable: false, orderable: false } // تعطيل الفرز والبحث على عمود الترقيم
                ],
                drawCallback: function(settings) {
                    // تطبيق التنسيق على خلايا العمود المحدد
                    $('#executives-table tbody tr').each(function() {
                        $(this).find('td').eq(1).css('right', '0px'); // العمود الأول
                        $(this).find('td').eq(2).css('right', '71.7px'); // العمود الأول
                        $(this).find('td').eq(3).css('right', '167.3px'); // العمود الأول
                        $(this).find('td').eq(4).css('right', '344px'); // العمود الأول
                    });
                },
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();
                    // تحويل القيم النصية إلى أرقام
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            parseFloat(i.replace(/[\$,]/g, '')) :
                            typeof i === 'number' ? i : 0;
                    };
                    // 1. حساب عدد الأسطر في الصفحة الحالية
                    // count_executives 1
                    var rowCount = display.length;

                    // total_quantity 9
                    var total_quantity_sum = api
                        .column(9, { page: 'current' }) // العمود الرابع
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // total_total_ils 11
                    var total_total_ils_sum = api
                        .column(11, { page: 'current' }) // العمود الرابع
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // total_amount_payments 14
                    var total_amount_payments_sum = api
                        .column(14, { page: 'current' }) // العمود الرابع
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    let remaining = total_total_ils_sum - total_amount_payments_sum;

                    // 4. عرض النتائج في `tfoot`
                    $('#count_executives').html(formatNumber(rowCount)); // عدد الأسطر
                    $('#total_quantity').html(formatNumber(total_quantity_sum));
                    $('.total_total_ils').html(formatNumber(total_total_ils_sum,2));
                    $('.total_total_dollars').html(formatNumber((total_total_ils_sum * ils),2));
                    $('.total_amount_payments').html(formatNumber(total_amount_payments_sum,2));
                    $('.total_amount_payments_dollars').html(formatNumber((total_amount_payments_sum * ils),2));
                    $('.remaining').html(formatNumber(remaining,2));
                    $('.remaining_dollars').html(formatNumber((remaining * ils),2));
                }
            });


            $('#executives-table_filter').addClass('d-none');

            // تطبيق الفلترة عند الضغط على زر "check"
            $('.filter-apply-btn').on('click', function() {
                let target = $(this).data('target');
                let field = $(this).data('field');
                var filterValue = $("input[name="+ field + "]").val();
                table.column(target).search(filterValue).draw();
            });

            // تطبيق التصفية عند النقر على زر "Apply"
            $('#filter-date-btn').on('click', function () {
                const fromDate = $('#from_date').val();
                const toDate = $('#to_date').val();
                table.ajax.reload(); // إعادة تحميل الجدول مع التواريخ المحدثة
            });

             // تفويض حدث الحذف على الأزرار الديناميكية
            $(document).on('click', '.delete_row', function () {
                const id = $(this).data('id'); // الحصول على ID الصف
                if (confirm('هل أنت متأكد من حذف العنصر؟')) {
                    deleteRow(id); // استدعاء وظيفة الحذف
                }
            });

            // وظيفة الحذف
            function deleteRow(id) {
                $.ajax({
                    url: '{{ route("executives.destroy", ":id") }}'.replace(':id', id),
                    method: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        alert('تم حذف العنصر بنجاح');
                        table.ajax.reload(); // إعادة تحميل الجدول بعد الحذف
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        alert('هنالك خطاء في عملية الحذف.');
                    },
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '#filterBtn', function() {
                $('.filter-dropdown').slideToggle();
            });
            if (curentTheme == "light") {
                $('#stickyTableLight').prop('disabled', false); // تشغيل النمط Light
                $('#stickyTableDark').prop('disabled', true);  // تعطيل النمط Dark
            } else {
                $('#stickyTableLight').prop('disabled', true);  // تعطيل النمط Light
                $('#stickyTableDark').prop('disabled', false); // تشغيل النمط Dark
            }
        });
    </script>
    @endpush
</x-front-layout>
