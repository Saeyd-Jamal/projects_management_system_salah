<x-front-layout>
    @push('styles')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}
        <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('css/dataTables.dataTables.css')}}">
        <link rel="stylesheet" href="{{asset('css/buttons.dataTables.css')}}">
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
            tbody td{
                padding: 2px 5px !important;
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
            .dt-layout-row{
                margin: 0 !important;
            }
            .dt-search{
                display: none !important;
            }
            .organization{
                width: 130px !important;
                overflow: hidden;
                display: block;

                transition: all 0.5s ease-in-out;
            }
            .organization:hover {
                width: 100% !important;
            }
        </style>
    @endpush
    <x-slot:extra_nav>
        <li class="nav-item">
            <button type="button" class="btn btn-success text-white" id="excel-export" title="تصدير excel">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16">
                    <path d="M64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-288-128 0c-17.7 0-32-14.3-32-32L224 0 64 0zM256 0l0 128 128 0L256 0zM155.7 250.2L192 302.1l36.3-51.9c7.6-10.9 22.6-13.5 33.4-5.9s13.5 22.6 5.9 33.4L221.3 344l46.4 66.2c7.6 10.9 5 25.8-5.9 33.4s-25.8 5-33.4-5.9L192 385.8l-36.3 51.9c-7.6 10.9-22.6 13.5-33.4 5.9s-13.5-22.6-5.9-33.4L162.7 344l-46.4-66.2c-7.6-10.9-5-25.8 5.9-33.4s25.8-5 33.4 5.9z"/>
                </svg>
            </button>
        </li>
        @can('create', 'App\\Models\Allocation')
        <li class="nav-item">
            <button type="button" class="btn btn-icon text-success my-2" id="createNew">
                <i class="fe fe-plus fe-16"></i>
            </button>
        </li>
        @endcan
        <li class="nav-item dropdown d-flex align-items-center justify-content-center mx-2">
            <a class="nav-link dropdown-toggle text-white pr-0" href="#" id="navbarDropdownMenuLink"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="avatar avatar-sm mt-2">
                    <i class="fe fe-filter fe-16"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <button class="btn btn-nav" id="filterBtn">تصفية</button>
                <button class="btn btn-nav" id="filterBtnClear">إزالة التصفية</button>
            </div>
        </li>
        <li class="nav-item d-flex align-items-center justify-content-center mx-2">
            <button type="button" class="btn" id="refreshData"><span class="fe fe-refresh-ccw fe-16 text-white"></span></button>
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
                                <th class="sticky" style="right: 0px;" id="nth1">
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>تاريخ التخصيص</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="padding: 0; margin: 0; border: none;" type="button" id="date_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                <th class="sticky" style="right: 132px;" id="nth2">
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>رقم <br> الموازنة</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="padding: 0; margin: 0; border: none;" type="button" id="budget_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                <th class="sticky" style="right:  220px;" id="nth3">
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>الاسم المختصر</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn" style="padding: 0; margin: 0; border: none;" type="button" id="broker_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                                <button class="btn" style="padding: 0; margin: 0; border: none;" type="button" id="organization_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                                <button class="btn" style="padding: 0; margin: 0; border: none;" type="button" id="project_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                                <button class="btn" style="padding: 0; margin: 0; border: none;" type="button" id="item_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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



    <!-- Fullscreen modal -->
    <div class="modal fade modal-full" id="editAllocation" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <button aria-label="" type="button" class="close px-2" data-dismiss="modal" aria-hidden="true">
            <span aria-hidden="true">×</span>
        </button>
        <div class="modal-dialog modal-dialog-centered w-100" role="document" style="max-width: 95%;">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <form id="editForm">
                        @include('dashboard.projects.allocations.editModal')
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- small modal -->
    @can('import','App\\Models\Allocation')
    <div class="modal fade" id="import_excel" tabindex="-1" role="dialog" aria-labelledby="import_excelTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="import_excelTitle">رفع ملف اكسيل</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Excel  --}}
                    <div class="col-12">
                        <form action="{{route('allocations.import')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" class="form-control">
                            <button type="submit" class="btn btn-primary mt-3">
                                رفع البيانات
                            </button>
                            <a href="{{asset('filesExcel/templateAllocation.xlsx')}}" class='nav-link' download="نموذج بيانات التخصيصات.xlsx" >
                                تحميل نموذج البيانات
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan

    @push('scripts')
        <!-- DataTables JS -->
        <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/dataTables.js')}}"></script>
        <script src="{{asset('js/dataTables.buttons.js')}}"></script>
        <script src="{{asset('js/buttons.dataTables.js')}}"></script>
        <script src="{{asset('js/jszip.min.js')}}"></script>
        <script src="{{asset('js/pdfmake.min.js')}}"></script>
        <script src="{{asset('js/vfs_fonts.js')}}"></script>
        <script src="{{asset('js/buttons.html5.min.js')}}"></script>
        <script src="{{asset('js/buttons.print.min.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                let formatNumber = (number,min = 0) => {
                    // التحقق إذا كانت القيمة فارغة أو غير صالحة كرقم
                    if (number === null || number === undefined || isNaN(number)) {
                        return ''; // إرجاع قيمة فارغة إذا كان الرقم غير صالح
                    }
                    return new Intl.NumberFormat('en-US', { minimumFractionDigits: min, maximumFractionDigits: 2 }).format(number);
                };
                let width1 = $('#nth1').width();
                let width2 = $('#nth2').width();
                let width3 = $('#nth3').width();
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
                    layout: {
                        topStart: {
                            buttons: [
                                {
                                    extend: 'excelHtml5',
                                    text: 'تصدير Excel',
                                    title: 'بيانات ips', // تخصيص العنوان عند التصدير
                                    className: 'd-none', // إخفاء الزر الأصلي
                                    exportOptions: {
                                        columns: [1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21], // تحديد الأعمدة التي سيتم تصديرها (يمكن تعديلها حسب الحاجة)
                                        modifier: {
                                            search: 'applied', // تصدير البيانات المفلترة فقط
                                            order: 'applied',  // تصدير البيانات مع الترتيب الحالي
                                            page: 'all'        // تصدير جميع الصفحات المفلترة
                                        }
                                    }
                                },
                            ]
                        }
                    },
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
                            // let link = `<a href="{{ route('allocations.edit', ':allocation') }}"
                            // class="btn btn-sm btn-icon text-primary"><i class="fe fe-edit"></i></a>`.replace(':allocation', data);
                            @can('update','App\\Models\Allocation')
                            let link = `<button class="btn btn-sm btn-icon text-primary edit_row"  data-id=":allocation"><i class="fe fe-edit"></i></button>`.replace(':allocation', data);
                            return link ;
                            @else
                            return '';
                            @endcan
                        }
                        },
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false}, // عمود الترقيم التلقائي
                        { data: 'date_allocation', name: 'date_allocation'  , orderable: false, class: 'sticky'},
                        { data: 'budget_number', name: 'budget_number' , orderable: false, class: 'sticky'},
                        { data: 'broker_name', name: 'broker_name' , orderable: false, class: 'sticky' },
                        { data: 'organization_name', name: 'organization_name' , orderable: false, render: function(data, type, row) {
                            return  `<span class="organization">${data}</span>`;
                        }},
                        { data: 'project_name', name: 'project_name', orderable: false, searchable: false},
                        { data: 'item_name', name: 'item_name'  , orderable: false},
                        { data: 'quantity', name: 'quantity'  , orderable: false},
                        { data: 'price', name: 'price'  , orderable: false},
                        { data: 'total_dollar', name: 'total_dollar'  , orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'allocation', name: 'allocation'  , orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'currency_allocation_name', name: 'currency_allocation_name'  , orderable: false},
                        { data: 'amount', name: 'amount'  , orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'number_beneficiaries', name: 'number_beneficiaries'  , orderable: false},
                        { data: 'implementation_items', name: 'implementation_items'  , orderable: false},
                        { data: 'date_implementation', name: 'date_implementation'  , orderable: false},
                        { data: 'implementation_statement', name: 'implementation_statement'  , orderable: false,},
                        { data: 'amount_received', name: 'amount_received'  , orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'notes', name: 'notes'  , orderable: false},
                        { data: 'user_name', name: 'user_name'  , orderable: false},
                        { data: 'manager_name', name: 'manager_name'  , orderable: false},
                        {
                            data: 'delete',
                            name: 'delete',
                            orderable: false,
                            searchable: false,
                            render: function (data, type, row) {
                                @can('delete','App\\Models\Allocation')
                                return `
                                    <button
                                        class="btn btn-icon text-danger delete_row"
                                        data-id="${data}">
                                        <i class="fe fe-trash"></i>
                                    </button>`;
                                @else
                                return '';
                                @endcan
                            },
                        },
                    ],
                    columnDefs: [
                        { targets: 1, searchable: false, orderable: false } // تعطيل الفرز والبحث على عمود الترقيم
                    ],
                    drawCallback: function(settings) {
                        // تطبيق التنسيق على خلايا العمود المحدد
                        $('#allocations-table tbody tr').each(function() {
                            $(this).find('td').eq(2).css('right', '0px');
                            $(this).find('td').eq(3).css('right', `${width1}px`);
                            $(this).find('td').eq(4).css('right', `${width1 + width2}px`);
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
                // عندما يتم رسم الجدول (بعد تحميل البيانات أو تحديثها)
                table.on('draw', function() {
                    // التمرير إلى آخر سطر في الجدول
                    let tableContainer = $('#allocations-table');
                    tableContainer.scrollTop(tableContainer[0].scrollHeight);
                });
                // نسخ وظيفة الزر إلى الزر المخصص
                $('#excel-export').on('click', function () {
                    table.button('.buttons-excel').trigger(); // استدعاء وظيفة الزر الأصلي
                });
                $('#print-btn').on('click', function () {
                    table.button('.buttons-print').trigger(); // استدعاء وظيفة الطباعة الأصلية
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
                $(document).on('click', '#refreshData', function() {
                    table.ajax.reload();
                });
                $(document).on('click', '#filterBtnClear', function() {
                    $('.filter-dropdown').slideUp();
                    $('#filterBtn').text('تصفية');
                    $('.filterDropdownMenu input').val('');
                    table.columns().search('').draw(); // إعادة رسم الجدول بدون فلاتر
                });
                $(document).on('click', '.edit_row', function () {
                    const id = $(this).data('id'); // الحصول على ID الصف
                    editAllocationForm(id); // استدعاء وظيفة الحذف
                });
                const allocation = {
                    id: '',
                    date_allocation : '',
                    budget_number : '',
                    broker_name : '',
                    organization_name : '',
                    project_name : '',
                    item_name : '',
                    quantity : '',
                    price : '',
                    total_dollar : '',
                    allocation : '',
                    currency_allocation : '',
                    currency_allocation_name : '',
                    currency_allocation_value : '',
                    amount : '',
                    number_beneficiaries : '',
                    implementation_items : '',
                    date_implementation : '',
                    implementation_statement : '',
                    amount_received : '',
                    notes : '',
                    user_name : '',
                    manager_name : '',
                    user : '',
                }
                function editAllocationForm(id) {
                    $.ajax({
                        url: '{{ route("allocations.edit", ":id") }}'.replace(':id', id),
                        method: 'GET',
                        success: function (response) {
                            allocation.id = response.id;
                            allocation.date_allocation = response.date_allocation;
                            allocation.budget_number = response.budget_number;
                            allocation.broker_name = response.broker_name;
                            allocation.organization_name = response.organization_name;
                            allocation.project_name = response.project_name;
                            allocation.item_name = response.item_name;
                            allocation.quantity = response.quantity;
                            allocation.price = response.price;
                            allocation.total_dollar = response.total_dollar;
                            allocation.allocation = response.allocation;
                            allocation.currency_allocation = response.currency_allocation;
                            allocation.currency_allocation_name = response.currency_allocation_name;
                            allocation.amount = response.amount;
                            allocation.number_beneficiaries = response.number_beneficiaries;
                            allocation.implementation_items = response.implementation_items;
                            allocation.date_implementation = response.date_implementation;
                            allocation.implementation_statement = response.implementation_statement;
                            allocation.amount_received = response.amount_received;
                            allocation.notes = response.notes;
                            allocation.user_name = response.user_name;
                            allocation.manager_name = response.manager_name;
                            allocation.user = response.user;
                            $.each(allocation, function(key, value) {
                                const input = $('#' + key); // البحث عن العنصر باستخدام id
                                if (input.length) { // التحقق إذا كان العنصر موجودًا
                                    input.val(value); // تعيين القيمة
                                }
                            });
                            $('#addAllocation').remove();
                            $('#update').remove();
                            $('#btns_form').append(`
                                <button type="button" id="update" class="btn btn-primary mx-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    تعديل
                                </button>
                            `);
                            $('.editForm').css('display','block');
                            $('#editAllocation').modal('show');
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        },
                    })
                }
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
                // التعديلات الحاصلة على النموذج
                $('#quantity, #price').on('input blur', function () {
                    // جلب القيم من الحقول
                    let quantity = $('#quantity').val();
                    let price = $('#price').val();

                    if(quantity != '' && price != ''){
                        quantity = parseFloat(quantity);
                        price = parseFloat(price);
                        let totalDollar = quantity * price;
                        let currencyAllocation = parseFloat($('#currency_allocation option:selected').data('val')) || 0; //إذا كان الحقل فارغًا، اعتبر القيمة 0
                        $('#total_dollar').val(totalDollar);
                        $('#allocation').val(totalDollar);
                        $('#amount').val(totalDollar * currencyAllocation);
                    }
                });
                $('#allocation, #currency_allocation').on('input blur', function () {
                    // جلب القيم من الحقول
                    var allocation = parseFloat($('#allocation').val()) || 0; // إذا كان الحقل فارغًا، اعتبر القيمة 0
                    var currencyAllocation = parseFloat($('#currency_allocation option:selected').data('val')) || 0; //إذا كان الحقل فارغًا، اعتبر القيمة 0
                    var amount = allocation * currencyAllocation;
                    $('#amount').val(amount);
                });
                $(document).on('click', '#update', function () {
                    $.each(allocation, function(key, value) {
                        const input = $('#' + key); // البحث عن العنصر باستخدام id
                        if(key == 'id'){
                            //
                        }else{
                            allocation[key] = input.val();
                        }
                    });
                    $.ajax({
                        url: "{{ route('allocations.update', ':id') }}".replace(':id', allocation.id),
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: allocation,
                        success: function (response) {
                            $('#editAllocation').modal('hide');
                            table.ajax.reload();
                            alert('تم التعديل بنجاح');
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        },
                    })
                });
                $(document).on('click', '#createNew', function () {
                    $.ajax({
                        url: '{{ route("allocations.create") }}',
                        method: 'GET',
                        success: function (response) {
                            allocation.id = response.id;
                            allocation.date_allocation = response.date_allocation;
                            allocation.budget_number = response.budget_number;
                            allocation.broker_name = response.broker_name;
                            allocation.organization_name = response.organization_name;
                            allocation.project_name = response.project_name;
                            allocation.item_name = response.item_name;
                            allocation.quantity = response.quantity;
                            allocation.price = response.price;
                            allocation.total_dollar = response.total_dollar;
                            allocation.allocation = response.allocation;
                            allocation.currency_allocation = response.currency_allocation;
                            allocation.currency_allocation_name = response.currency_allocation_name;
                            allocation.amount = response.amount;
                            allocation.number_beneficiaries = response.number_beneficiaries;
                            allocation.implementation_items = response.implementation_items;
                            allocation.date_implementation = response.date_implementation;
                            allocation.implementation_statement = response.implementation_statement;
                            allocation.amount_received = response.amount_received;
                            allocation.notes = response.notes;
                            allocation.user_name = response.user_name;
                            allocation.manager_name = response.manager_name;
                            $.each(allocation, function(key, value) {
                                const input = $('#' + key); // البحث عن العنصر باستخدام id
                                if (input.length) { // التحقق إذا كان العنصر موجودًا
                                    input.val(value); // تعيين القيمة
                                }
                            });
                            $('#addAllocation').remove();
                            $('#update').remove();
                            $('#btns_form').append(`
                                <button type="button" id="addAllocation" class="btn btn-primary mx-2">
                                    <i class="fe fe-plus"></i>
                                    أضف
                                </button>
                            `);
                            $('.editForm').css('display','none');
                            $('#editAllocation').modal('show');
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        },
                    })
                });
                $(document).on('click', '#addAllocation', function () {
                    const id = $(this).data('id'); // الحصول على ID الصف
                    createAllocationForm(id);
                });
                function createAllocationForm(id){
                    $.each(allocation, function(key, value) {
                        const input = $('#' + key); // البحث عن العنصر باستخدام id
                        if(key == 'id'){
                            allocation['id'] = null;
                        }else{
                            allocation[key] = input.val();
                        }
                    });
                    console.log(allocation);
                    $.ajax({
                        url: "{{ route('allocations.store') }}",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: allocation,
                        success: function (response) {
                            $('#editAllocation').modal('hide');
                            table.ajax.reload();
                            alert('تم إضافة التخصيص بنجاح');
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        },
                    })
                };
            });
        </script>
        <script>
            $(document).ready(function() {
                $(document).on('click', '#filterBtn', function() {
                    let text = $(this).text();
                    if (text != 'تصفية') {
                        $(this).text('تصفية');
                    }else{
                        $(this).text('إخفاء التصفية');
                    }
                    $('.filter-dropdown').slideToggle();
                });
                if (curentTheme == "light") {
                    $('#stickyTableLight').prop('disabled', false); // تشغيل النمط Light
                    $('#stickyTableDark').prop('disabled', true);  // تعطيل النمط Dark
                } else {
                    $('#stickyTableLight').prop('disabled', true);  // تعطيل النمط Light
                    $('#stickyTableDark').prop('disabled', false); // تشغيل النمط Dark
                }
                $(document).on('click', '#import_excel_btn', function() {
                    $('#editAllocation').modal('hide');
                    $('#import_excel').modal('show');
                })
            });
        </script>
    @endpush
</x-front-layout>
