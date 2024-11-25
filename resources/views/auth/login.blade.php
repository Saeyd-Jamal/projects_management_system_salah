@include('layouts.partials.header', ['title' => Config::get('app.name', 'دار اليتيم الفلسطيني')])
<main class="main-content  m-0">
    <section>
        <div class="page-header min-vh-75">
            <div class="container" style="height: 100vh;">
                <div class="row h-100 align-items-center">
                    <div class="col-md-6"  style="height: 40%;">
                        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8 w-100">
                            <style>
                                #oblique-cover {
                                    background-size: cover;
                                    background-position: center;
                                    transition: all 0.3s;
                                }
                            </style>
                            <div id="oblique-cover" class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                                    >
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient">مرحبا بك</h3>
                                <p class="mb-0">أدخل البيانات لإكمال تسجيل الدخول</p>
                            </div>
                            <x-alert type="danger" />
                            <div class="card-body">
                                <form action="{{ route('login') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <x-form.input type="text" name="username" label="اسم المستخدم" placeholder="إملأ اسم المستخدم" autofocus required />
                                    </div>
                                    <div class="form-group">
                                        <x-form.input type="password" name="password" label="كلمة المرور" placeholder="إملأ كلمة المرور" required />
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe" checked="">
                                        <label class="form-check-label" for="rememberMe">تذكرني على هذا الجهاز</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">تسجيل الدخول</button>
                                    </div>
                                </form>
                            </div>
                            {{-- <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Don't have an account?
                                    <a href="javascript:;" class="text-info text-gradient font-weight-bold">Sign up</a>
                                </p>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@push('scripts')
    <script>
        const images = [
            "url("+"{{asset('img/curved-images/curved0.jpg')}}"+")",
            "url("+"{{asset('img/curved-images/curved1.jpg')}}"+")",
            "url("+"{{asset('img/curved-images/curved2.jpg')}}"+")",
            "url("+"{{asset('img/curved-images/curved3.jpg')}}"+")",
            // "url('../img/curved-images/curved0.jpg')",
            // "url('../img/curved-images/curved1.jpg')",
            // "url('../img/curved-images/curved2.jpg')",
            // "url('../img/curved-images/curved3.jpg')",
        ];

        let currentIndex = 0;

        function changeBackground() {
            const div = document.getElementById('oblique-cover');
            div.style.backgroundImage = images[currentIndex];
            // Increment the index to the next image
            currentIndex = (currentIndex + 1) % images.length;
        }
        setInterval(changeBackground, 1500);
        changeBackground();
    </script>
@endpush
@include('layouts.partials.footer')
