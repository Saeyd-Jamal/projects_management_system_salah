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
        </style>
    @endpush
    <x-slot:extra_nav>
        <li class="nav-item">
            <a href="{{ route('allocations.create') }}" class="btn btn-info btn-icon text-white my-2">
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
                    <table id="allocations-table" class="table table-striped table-bordered table-hover sticky" style="width:100%; height: calc(100vh - 100px);">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-white opacity-7 text-center">#</th>
                                <th class="sticky" style="right: 0px;">
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>تاريخ التخصيص</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="border:1px solid #ced4da;" type="button" id="date_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-filter text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="date_filter">
                                                    <div>
                                                        <input type="date" id="from_date" name="from_date_allocation" class="form-control mr-2" style="width: 200px"/>
                                                        <input type="date" id="to_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" name="to_date_allocation" class="form-control mr-2 mt-2" style="width: 200px"/>
                                                    </div>
                                                    <div>
                                                        <button id="filter-date-btn" class='btn btn-success text-white filter-apply-btn-data' data-target="2" data-field="date_name">
                                                            <i class='fe fe-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th class="sticky" style="right: 132px;">
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>رقم <br> الموازنة</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="border:1px solid #ced4da;" type="button" id="budget_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-filter text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="budget_filter">
                                                    <input type="number" min="0" name="budget_name" class="form-control mr-2  py-0 px-2" style="width: 200px"/>
                                                    <div>
                                                        <button class='btn btn-success text-white filter-apply-btn' data-target="3" data-field="budget_name">
                                                            <i class='fe fe-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th class="sticky" style="right:  220px;">
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
                                </th>
                                <th>
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>المؤسسة</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="border:1px solid #ced4da;" type="button" id="organization_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-filter text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="organization_filter">
                                                    <input type="text" name="organization_name" class="form-control mr-2  py-0 px-2" list="organizations_list" style="width: 200px"/>
                                                    <datalist id="organizations_list">
                                                        @foreach ($organizations as $organization)
                                                            <option value="{{$organization}}" >
                                                        @endforeach
                                                    </datalist>
                                                    <div>
                                                        <button class='btn btn-success text-white filter-apply-btn' data-target="5" data-field="organization_name">
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
                                                        <button class='btn btn-success text-white filter-apply-btn' data-target="7" data-field="item_name">
                                                            <i class='fe fe-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
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
                                <th>ملاحظات</th>
                                <th>اسم المستخدم</th>
                                <th>المدير المستلم</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td class="text-white opacity-7 text-center" id="count_allocations"></td>
                                <td class='sticky text-right' colSpan="3">المجموع</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class='text-white' id="total_quantity"></td>
                                <td></td>
                                <td></td>
                                <td class='text-white' id="total_allocation"></td>
                                <td></td>
                                <td class='text-white total_amount'></td>
                                <td class='text-white' id="total_number_beneficiaries"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class='text-white total_amount_received'></td>
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
    <div class="row justify-content-end m-3">
        <div class="col-3">
            <table class="table align-items-center mb-0 table-bordered">
                <tbody  style=" color: #fff;">
                    <tr>
                        <th  style="background: #27AE60;">المبالغ المخصصة</th>
                        <td  style="background: #17a2b8;" class="total_amount">
                        </td>
                    </tr>
                    <tr>
                        <th  style="background: #27AE60;">المبالغ المستلمة</th>
                        <td  style="background: #17a2b8;" class="total_amount_received">
                        </td>
                    </tr>
                    <tr style="background: #ddd; color: #000;">
                        <th >المتبقي</th>
                        <td class="remaining">
                        </td>
                    </tr>
                    <tr>
                        <th style="background: #C0392B;">نسبة التحصيل</th>
                        <td style="color: #C0392B; background: #ddd;">
                            <span class="remaining_percent"></span>%
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
            let formatNumber = (number,min = 0) => {
                // التحقق إذا كانت القيمة فارغة أو غير صالحة كرقم
                if (number === null || number === undefined || isNaN(number)) {
                    return ''; // إرجاع قيمة فارغة إذا كان الرقم غير صالح
                }
                return new Intl.NumberFormat('en-US', { minimumFractionDigits: min, maximumFractionDigits: 2 }).format(number);
            };

            let table = $('#allocations-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                paging: false,              // تعطيل الترقيم
                searching: true,            // الإبقاء على البحث إذا كنت تريده
                // ordering: true,             // الإبقاء على خاصية الفرز
                info: false,                // تعطيل النص السفلي الذي يوضح عدد السجلات
                lengthChange: false,        // تعطيل قائمة تغيير عدد المدخلات
                // scrollY: "500px",           // إضافة شريط تمرير إذا كانت البيانات طويلة
                // scrollCollapse: true,       // تمكين الشريط عند الحاجة فقط
                // lengthMenu: [
                //     [10,100, -1], // القيم الفعلية لعدد الصفوف
                //     [10,100, "عرض الكل"] // النصوص الظاهرة للمستخدم
                // ],
                // pageLength: 100, // العدد الافتراضي للمدخلات عند تحميل الصفحة
                "language": {
                    "url": "{{ asset('files/Arabic.json')}}"
                },
                ajax: {
                    url: '{{ route("allocations.index") }}',
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
                        // return ` <button class="btn btn-sm btn-primary open-modal" data-bs-toggle="modal" data-id="${data}">تعديل <i class="fa fa-edit"></i></button>`;}
                        let link = `<a href="{{ route('allocations.edit', ':allocation') }}"
                        class="btn btn-sm btn-primary">تعديل <i class="fa fa-edit"></i></a>`.replace(':allocation', data);
                        return link ;
                    }
                    },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false}, // عمود الترقيم التلقائي
                    { data: 'date_allocation', name: 'date_allocation'  , orderable: false, class: 'sticky'},
                    { data: 'budget_number', name: 'budget_number' , orderable: false, class: 'sticky'},
                    { data: 'broker_name', name: 'broker_name' , orderable: false, class: 'sticky' },
                    { data: 'organization_name', name: 'organization_name' , orderable: false,},
                    { data: 'project_name', name: 'project_name', orderable: false, searchable: false },
                    { data: 'item_name', name: 'item_name'  , orderable: false,},
                    { data: 'quantity', name: 'quantity'  , orderable: false,},
                    { data: 'price', name: 'price'  , orderable: false,},
                    { data: 'total_dollar', name: 'total_dollar'  , orderable: false,},
                    { data: 'allocation', name: 'allocation'  , orderable: false,},
                    { data: 'currency_allocation_name', name: 'currency_allocation_name'  , orderable: false,},
                    { data: 'amount', name: 'amount'  , orderable: false,},
                    { data: 'number_beneficiaries', name: 'number_beneficiaries'  , orderable: false,},
                    { data: 'implementation_items', name: 'implementation_items'  , orderable: false,},
                    { data: 'date_implementation', name: 'date_implementation'  , orderable: false,},
                    { data: 'implementation_statement', name: 'implementation_statement'  , orderable: false,},
                    { data: 'amount_received', name: 'amount_received'  , orderable: false,},
                    { data: 'notes', name: 'notes'  , orderable: false,},
                    { data: 'user_name', name: 'user_name'  , orderable: false,},
                    { data: 'manager_name', name: 'manager_name'  , orderable: false,},
                    // { data: 'delete', name: 'delete', orderable: false, searchable: false, render: function(data, type, row)
                    //     {
                    //         return `<button onclick="deleteRow(${data})" class='btn btn-danger text-white delete_row'><i class='fe fe-trash'></i></button>`;
                    //     }
                    // },
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
                    { targets: 0, searchable: false, orderable: false } // تعطيل الفرز والبحث على عمود الترقيم
                ],
                drawCallback: function(settings) {
                    // تطبيق التنسيق على خلايا العمود المحدد
                    $('#allocations-table tbody tr').each(function() {
                        $(this).find('td').eq(2).css('right', '0px'); // العمود الأول
                        $(this).find('td').eq(3).css('right', '132px'); // العمود الأول
                        $(this).find('td').eq(4).css('right', '220px'); // العمود الأول
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
                    // count_allocations 1
                    var rowCount = display.length;
                    // total_quantity 8
                    var total_quantity_sum = api
                        .column(8, { page: 'current' }) // العمود الرابع
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // total_allocation 11
                    var total_allocation_sum = api
                        .column(11, { page: 'current' }) // العمود الرابع
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // total_amount 13
                    var total_amount_sum = api
                        .column(13, { page: 'current' }) // العمود الرابع
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // total_number_beneficiaries 14
                    var total_number_beneficiaries_sum = api
                        .column(14, { page: 'current' }) // العمود الرابع
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // total_amount_received 18
                    var total_amount_received_sum = api
                        .column(18, { page: 'current' }) // العمود الخامس
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // المتبقي
                    let remaining = total_amount_sum - total_amount_received_sum;
                    let remaining_percent = ((total_amount_sum - total_amount_received_sum) / total_amount_sum) * 100;
                    // 4. عرض النتائج في `tfoot`

                    $('#count_allocations').html(formatNumber(rowCount));
                    $('#total_quantity').html(formatNumber(total_quantity_sum));
                    $('#total_allocation').html(formatNumber(total_allocation_sum,2));
                    $('.total_amount').html(formatNumber(total_amount_sum,2));
                    $('#total_number_beneficiaries').html(formatNumber(total_number_beneficiaries_sum));
                    $('.total_amount_received').html(formatNumber(total_amount_received_sum,2));

                    $('.remaining').html(formatNumber(remaining,2));
                    $('.remaining_percent').html(formatNumber(remaining_percent,2));


                    // $('#allocations-table_filter').addClass('d-none');
                }
            });
            $('#allocations-table_filter').addClass('d-none');
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
                    url: '{{ route("allocations.destroy", ":id") }}'.replace(':id', id),
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
