<aside
    class="bodyPage sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-end me-3 rotate-caret bg-white "
    id="sidenav-main" style=" transition: all 0.15s ease;">
    <div class="sidenav-header" style="height: auto;">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute start-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 p-0" href="{{route('home')}}" style="display: flex; flex-direction: column; align-items: center;">
            <img src="{{asset('img/logo.png')}}" class="navbar-brand-img" style="max-height: 100%" width="77%" alt="main_logo">
            <h1 class="me-1 h4">{{config('app.name')}}</h1>
        </a>
    </div>
    
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse px-0 w-auto  max-height-vh-100 h-100" id="sidenav-collapse-main">
        @foreach (app('nav') as $nav)
        <div class="row align-items-center  flex-nowrap" style="margin: 5px;">
            <i style="width: 18px" class="{{$nav['icon']}}"></i>
            <span>{{$nav['title']}}</span>
        </div>
        <ul class="navbar-nav">
            @foreach ($nav['items'] as $item)
                @can($item['permission'], $item['model'])
                <li class="nav-item">
                    <a class="nav-link {{ Str::startsWith(url()->current(), route($item['route'])) ? 'active' : '' }}" href="{{route($item['route'])}}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center ms-2 d-flex align-items-center justify-content-center">
                            <i class="{{$item['icon']}}"></i>
                        </div>
                        <span class="nav-link-text me-1">{{$item['title']}}</span>
                    </a>
                </li>
                @endcan
            @endforeach
        </ul>
        @endforeach
    </div>
</aside>
