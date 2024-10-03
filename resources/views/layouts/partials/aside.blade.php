<style>
    .simplebar-wrapper{
        border-radius: 13px;
        margin: 4px 7px 5px 0;
        background: #e2f9fb;
        color: white;
    }
</style>
<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="row justify-content-center" style="text-align:center;">
            <div class="w-100 d-flex">
                <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{route('home')}}">
                    <img src="{{asset('img/logo.png')}}" class="navbar-brand-img mx-auto" alt="..." style="width: 75%">
                </a>
            </div>

            <h2 class="text-center h4">{{Config::get('app.name')}}</h2>
        </div>
        @foreach (app('nav') as $nav)
        <p class="text-muted nav-heading mt-4 mb-1">
            <i style="width: 18px" class="{{$nav['icon']}}"></i>
            <span>{{$nav['title']}}</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            @foreach ($nav['items'] as $item)
                @if(isset($item['model']))
                    @can($item['permission'], $item['model'])
                        <li class="nav-item w-100">
                            <a class="nav-link" href="{{route($item['route'])}}">
                                <i class="{{$item['icon']}}"></i>
                                <span class="ml-3 item-text">{{$item['title']}}</span>
                                @if (isset($item['badge']))
                                    @if ($item['badge']['type']== 'count')
                                        @if ($item['model']::count() != 0)
                                            <span class="badge badge-pill badge-{{$item['badge']['color']}}">
                                                {{$item['model']::count()}}
                                            </span>
                                        @else
                                            <span></span>
                                        @endif
                                    @endif
                                @else
                                    <span></span>
                                @endif
                            </a>
                        </li>
                    @endcan
                @else
                    @can($item['permission'])
                        <li class="nav-item w-100">
                            <a class="nav-link" href="{{route($item['route'])}}">
                                <i class="{{$item['icon']}}"></i>
                                <span class="ml-3 item-text">{{$item['title']}}</span>
                                @if (isset($item['badge']))
                                    @if ($item['badge']['type']== 'count')
                                        @if ($item['model']::count() != 0)
                                            <span class="badge badge-pill badge-{{$item['badge']['color']}}">
                                                {{$item['model']::count()}}
                                            </span>
                                        @else
                                            <span></span>
                                        @endif
                                    @endif
                                @else
                                    <span></span>
                                @endif
                            </a>
                        </li>
                    @endcan
                @endif
            @endforeach
        </ul>
        @endforeach

        <div class="btn-box w-100 mt-3 mb-1">
            <p class="text-muted font-weight-bold h6">© تم الإنشاء بواسطة <a href="https://saeyd-jamal.github.io/My_Portfolio/" target="_blank">م.السيد الأخرس</a></p>
        </div>
    </nav>
</aside>
