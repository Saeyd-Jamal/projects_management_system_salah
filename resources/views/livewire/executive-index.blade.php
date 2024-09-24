<div class="table-responsive">
    @push('styles')
        <link rel="stylesheet" href="{{asset('css/stickyTable.css')}}">
        <!-- إضافة بعض CSS المخصص لتحسين المظهر -->
        <style>
            /* تنسيق حقل البحث */
            .search-container {
                position: relative;
                width: 100%;
            }

            .searchInput {
                width: 100%;
                padding: 10px;
                border: 1px solid #ced4da;
                border-radius: 5px;
                outline: none;
            }

            /* تنسيق القائمة المنسدلة */
            .dropdown-list {
                position: absolute;
                width: 100%;
                max-height: 150px;
                border: 1px solid #ced4da;
                border-radius: 0 0 5px 5px;
                background-color: #fff;
                z-index: 1000;
                overflow-y: auto;
                display: none;
                /* مخفية بشكل افتراضي */
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            }

            .dropdown-list option {
                padding: 10px;
                cursor: pointer;
            }

            .dropdown-list option:hover {
                background-color: #f1f1f1;
            }

            /* عند فتح القائمة */
            .dropdown-list.show {
                display: block;
            }
        </style>
    @endpush


    <div class="d-flex justify-content-end p-3 align-items-start">
        <button type="button" class="btn btn-secondary" style="margin-left: 10px" id="expandBtn">
            <i class="fa-solid fa-maximize"></i>
        </button>
        <button type="button" class="btn btn-warning" style="margin-left: 10px" id="filterBtn" wire:click="filterBox">
            <i class="fa-solid fa-filter"></i>
        </button>
        @can('create','App\\Models\Executive')
        <a href="{{route('executives.create')}}" class="btn btn-primary m-0">
            <i class="fa-solid fa-plus"></i>
        </a>
        @endcan
    </div>
    <div class="container-fluid mb-3" id="filter" style="@if($filterB == true) display: block; @else display: none; @endif">
        <form method="post" class="col-12">
            @csrf
            <div class="row">
                <div class="form-group col-md-3">
                    <x-form.input type="date" name="from_implementation_date" label="من تاريخ" required wire:model="filterArray.from_implementation_date" wire:input="filter" />
                </div>
                <div class="form-group col-md-3">
                    <x-form.input type="date" name="to_implementation_date" label="الى تاريخ" required wire:model="filterArray.to_implementation_date" wire:input="filter" />
                </div>
                <div class="form-group col-md-3">
                    <label for="broker_name">الإسم المختصر</label>
                    <!-- حاوية لحقل البحث والقائمة المنسدلة -->
                    <div class="search-container">
                        <input type="text" class="searchInput form-control mb-2" data-target="broker_name"
                            placeholder="ابحث...">
                        <!-- قائمة الخيارات المنسدلة المرتبطة -->
                        <select id="broker_name" class="dropdown-list form-control" size="5"
                            wire:model="filterArray.broker_name" wire:input="filter">
                            <option value="">الكل</option>
                            @foreach ($brokers as $broker)
                                <option value="{{ $broker }}">{{ $broker }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="account_name">الحساب</label>
                    <div class="search-container">
                        <input type="text" class="searchInput form-control mb-2" data-target="account_name"
                            placeholder="ابحث...">
                        <!-- قائمة الخيارات المنسدلة المرتبطة -->
                        <select id="account_name" class="dropdown-list form-control" size="5"
                            wire:model="filterArray.account_name" wire:input="filter">
                            <option value="">الكل</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account }}">{{ $account }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="affiliate_name">الاسم</label>
                    <div class="search-container">
                        <input type="text" class="searchInput form-control mb-2" data-target="affiliate_name"
                            placeholder="ابحث...">
                        <!-- قائمة الخيارات المنسدلة المرتبطة -->
                        <select id="affiliate_name" class="dropdown-list form-control" size="5"
                            wire:model="filterArray.affiliate_name" wire:input="filter">
                            <option value="">الكل</option>
                            @foreach ($affiliates as $affiliate)
                                <option value="{{ $affiliate }}">{{ $affiliate }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="project_name">المشروع</label>
                    <div class="search-container">
                        <input type="text" class="searchInput form-control mb-2" data-target="project_name"
                            placeholder="ابحث...">
                        <!-- قائمة الخيارات المنسدلة المرتبطة -->
                        <select id="project_name" class="dropdown-list form-control" size="5"
                            wire:model="filterArray.project_name" wire:input="filter">
                            <option value="">الكل</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project }}">{{ $project }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="item_name">الصنف</label>
                    <div class="search-container">
                        <input type="text" class="searchInput form-control mb-2" data-target="item_name"
                            placeholder="ابحث...">
                        <!-- قائمة الخيارات المنسدلة المرتبطة -->
                        <select id="item_name" class="dropdown-list form-control" size="5"
                            wire:model="filterArray.item_name" wire:input="filter">
                            <option value="">الكل</option>
                            @foreach ($items as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="received_name">المستلم</label>
                    <div class="search-container">
                        <input type="text" class="searchInput form-control mb-2" data-target="received_name"
                            placeholder="ابحث...">
                        <!-- قائمة الخيارات المنسدلة المرتبطة -->
                        <select id="received_name" class="dropdown-list form-control" size="5"
                            wire:model="filterArray.received_name" wire:input="filter">
                            <option value="">الكل</option>
                            @foreach ($receiveds as $received)
                                <option value="{{ $received }}">{{ $received }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="paginationItems">عدد السجلات</label>
                    <select class="form-control" name="paginationItems" id="paginationItems" wire:model="paginationItems"
                        wire:input="filter">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="all">الكل</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="reset" class="btn btn-warning" wire:click="filter">مسح التصفية</button>
            </div>
        </form>
    </div>
    <div class="table-container">
        <table class="table align-items-center mb-0 table-hover table-bordered" id="sticky">
            <thead>
                <tr>
                    <th class="text-secondary opacity-7 text-center">#</th>
                    <th  class="sticky" style="right: 0px;">التاريخ</th>
                    {{-- <th>رقم الموازنة</th> --}}
                    <th  class="sticky" style="right: 142px;">المؤسسة</th>
                    <th class="sticky" style="right: 284px;" >الحساب</th>
                    <th class="sticky" style="right: 426px;">الاسم</th>
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
                table input,table select,table textarea{
                    max-width: 100% !important;
                    text-align: center !important;
                    border: none !important;
                    width: 125px !important;
                }
                table textarea{
                    text-align: right !important;
                    width: 200px !important;
                }
            </style>
            <tbody>
                @foreach ($executives as $index => $executive)
                    <livewire:executive-table :executive="$executive"  :index="$index" wire:key="executive-{{ $executive->id }}"  />
                @endforeach
            </tbody>
        </table>
        <div>
            @if ($executives instanceof \Illuminate\Pagination\LengthAwarePaginator)
                @if ($filterCheck != true)
                    {{ $executives->links() }}
                @endif
            @else
                {{-- إذا لم يكن هناك روابط --}}
            @endif
        </div>
    </div>
    {{-- مجموع المبالغ --}}
    <div class="row justify-content-end m-3">
        <div class="col-3">
            <table class="table align-items-center mb-0 table-hover table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>بالشيكل</th>
                        <th>بالدولار</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th>اجمالي مبالغ شيكل</th>
                        <td>
                            {{number_format($total_amounts,2) ?? 0}}
                        </td>
                        <td class="text-danger">
                            {{number_format($total_amounts * $ILS,2) ?? 0}}
                        </td>
                    </tr>
                    <tr>
                        <th>اجمالي الدفعات شيكل</th>
                        <td>
                            {{number_format($total_payments,2) ?? 0}}
                        </td>
                        <td class="text-danger">
                            {{ number_format($ILS * $total_payments,2) ?? 0}}
                        </td>
                    </tr>
                    <tr>
                        <th>الرصيد المتبقي شيكل</th>
                        <td>
                            {{number_format($remaining_balance,2) ?? 0}}
                        </td>
                        <td class="text-danger">
                            {{ number_format($ILS * $remaining_balance,2) ?? 0}}
                        </td>
                    </tr>
                    <tr class="text-danger">
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
        <!-- إضافة كود jQuery لتفعيل البحث الحي لجميع الحقول -->
        <script>
            $(document).ready(function() {
                // عند الكتابة في حقل البحث
                $('.searchInput').on('keyup', function() {
                    var filter = $(this).val().toLowerCase();
                    var target = $(this).data('target');
                    var $dropdown = $('#' + target);

                    $dropdown.find('option').each(function() {
                        $(this).toggle($(this).text().toLowerCase().includes(filter));
                    });
                });

                $('.searchInput').on('focus', function() {
                    var target = $(this).data('target');
                    var $dropdown = $('#' + target);
                    $('.dropdown-list').removeClass('show');
                    $dropdown.addClass('show');
                });

                // عند اختيار عنصر من القائمة
                $('.dropdown-list').on('click', 'option', function() {
                    var selectedValue = $(this).text();
                    var $input = $(this).closest('.search-container').find('.searchInput');

                    // وضع القيمة المختارة في حقل الإدخال
                    $input.val(selectedValue);

                    // إخفاء القائمة بعد الاختيار
                    $(this).parent().removeClass('show');
                });

                // إخفاء القائمة عند النقر خارجها
                $(document).on('click', function(event) {
                    if (!$(event.target).closest('.search-container').length) {
                        $('.dropdown-list').removeClass('show');
                    }
                });
            });
        </script>
    @endpush
</div>
