@include('layouts.partials.header', ['title' => Config::get('app.name', 'دار اليتيم الفلسطيني')])
<div class="wrapper vh-100">
    <div class="align-items-center h-100 d-flex w-50 mx-auto">
        <div class="mx-auto text-center">
            <h1 class="display-1 m-0 font-weight-bolder text-danger" style="font-size:80px;">500</h1>
            <h1 class="mb-1 text-muted font-weight-bold">OOPS!</h1>
            <h4 class="mb-3 text-black">حدث خطأ يرجى المحاولة أو التواصل مع المهندس المختص (لا تخرج من الصفحة أبقى عليها)</h4>
            <a href="{{ route('home')}}" class="btn btn-lg btn-primary px-5">العودة للصفحة الرئيسية</a>
        </div>
    </div>
</div>
@include('layouts.partials.footer')

