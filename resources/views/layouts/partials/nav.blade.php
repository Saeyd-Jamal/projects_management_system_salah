<style>
    .navbar-light .navbar-nav .nav-item > .nav-link{
        color: #fff !important;
        transition: all 0.3s ease-in-out;
    }
    .navbar-light .navbar-nav .nav-item > .nav-link:hover {
        color: #fff !important;
        background-color: #303030 !important;
    }
    .dropdown-menu .nav-link{
        color: #000 !important;
    }
    .dropdown-menu .nav-link:hover{
        color: #fff !important;
        background-color: #303030 !important;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-dark flex-row border-bottom shadow" style="position: fixed; width: 100%; top: 0; z-index: 99;padding: 0; margin: 0;">
    <div class="container-fluid">
        <a class="navbar-brand mx-lg-1 mr-0 my-0 py-0"  href="{{ route('home') }}">
            <img src="{{ asset('img/logo.png') }}" style="max-width: 46px;">
        </a>
        <button class="navbar-toggler mt-2 mr-auto toggle-sidebar text-muted">
            <i class="fe fe-menu navbar-toggler-icon"></i>
        </button>
        <div class="navbar-slide bg-dark text-white ml-lg-4 my-0" id="navbarSupportedContent">
            <a href="#" class="btn toggle-sidebar d-lg-none text-muted m-0 p-0" data-toggle="toggle">
                <i class="fe fe-x"><span class="sr-only"></span></i>
            </a>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{route('home')}}">
                        <i class="fe fe-home fe-16"></i>
                        <span class="ml-3 item-text">الصفحة الرئيسية</span>
                    </a>
                </li>
                @can('view','App\\Models\AccreditationProject')
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{route('accreditations.index')}}">
                            <i class="fe fe-folder fe-16"></i>
                            <span class="ml-3 item-text">الإعتمادية</span>
                            <span id="accreditations_count" class="badge badge-primary py-2 px-3  mx-2 d-none {{App\Models\AccreditationProject::count() > 0 ? 'd-block' : ''}}" style="font-size: 17px;">{{App\Models\AccreditationProject::count()}}</span>
                        </a>
                    </li>
                @endcan
                @push('scripts')
                    <script>
                        $(document).ready(function () {
                            setInterval(function () {
                                let accreditations = $.ajax({
                                    url: "{{route('accreditations.checkNew')}}",
                                    method: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}"
                                    },
                                    success: function (data) {
                                        if (data > 0) {
                                            $('#accreditations_count').addClass('d-block');
                                            $('#accreditations_count').text(data);
                                        }
                                    }
                                })
                            }, 10000);
                        });
                    </script>
                @endpush
                @can('view','App\\Models\Allocation')
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{route('allocations.index')}}">
                            <i class="fe fe-trello fe-16"></i>
                            <span class="ml-3 item-text">التخصيصات</span>
                        </a>
                    </li>
                @endcan
                @can('view','App\\Models\Executive')
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{route('executives.index')}}">
                            <i class="fe fe-watch fe-16"></i>
                            <span class="ml-3 item-text">التنفيذات</span>
                        </a>
                    </li>
                @endcan
                @can('reports.view')
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{route('reports.index')}}">
                            <i class="fe fe-file fe-16"></i>
                            <span class="ml-3 item-text">التقارير</span>
                        </a>
                    </li>
                @endcan
                <li class="nav-item dropdown">
                    <a href="#" id="dashboardDropdown" class="dropdown-toggle nav-link" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ml-lg-2">إعدادات النظام</span><span class="sr-only">(current)</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dashboardDropdown">
                        @can('view','App\\Models\User')
                            <a class="nav-link pl-lg-2" href="{{route('users.index')}}"><span class="ml-1">المستخدمين</span></a>
                        @endcan
                        @can('view','App\\Models\Currency')
                            <a class="nav-link pl-lg-2" href="{{route('currencies.index')}}"><span class="ml-1">العملات</span></a>
                        @endcan
                        @can('view','App\\Models\Broker')
                            <a class="nav-link pl-lg-2" href="{{route('brokers.index')}}"><span class="ml-1">المؤسسات</span></a>
                        @endcan
                        @can('view','App\\Models\Item')
                            <a class="nav-link pl-lg-2" href="{{route('items.index')}}"><span class="ml-1">الأصناف</span></a>
                        @endcan
                        @can('view','App\\Models\Logs')
                            <a class="nav-link pl-lg-2" href="{{route('logs.index')}}"><span class="ml-1">الأحداث</span></a>
                        @endcan
                    </div>
                </li>
                {{-- <li class="nav-item dropdown more">
                    <a class="dropdown-toggle more-horizontal nav-link" href="#" id="moreDropdown"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ml-2 sr-only">More</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="moreDropdown">
                        <a class="nav-link pl-lg-2" href="{{route('users.index')}}"><span class="ml-1">المستخدمين</span></a>
                        <a class="nav-link pl-lg-2" href="{{route('constants.index')}}"><span class="ml-1">ثوابت النظام</span></a>
                        <a class="nav-link pl-lg-2" href="{{route('currencies.index')}}"><span class="ml-1">العملات</span></a>
                    </ul>
                </li> --}}
            </ul>
        </div>
        <ul class="navbar-nav d-flex align-items-center flex-row nav">
            {{ $extra_nav ?? '' }}
            @auth
            <li class="nav-item dropdown d-flex align-items-center justify-content-center ">
                <a class="nav-link dropdown-toggle text-muted p-0 m-0" href="#" id="navbarDropdownMenuLink"
                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="avatar avatar-sm mt-2">
                        <img src="{{ Auth::user()->avatar_url }}" alt="..." class="avatar-img rounded-circle">
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('users.profile', Auth::user()->id) }}">الملف الشخصي</a>
                    {{-- <a class="dropdown-item" href="#">Settings</a> --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">تسجيل الخروج</button>
                    </form>
                </div>
            </li>
            @endauth
        </ul>
    </div>
</nav>
