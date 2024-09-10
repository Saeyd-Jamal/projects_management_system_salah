@include('layouts.partials.header')
@include('layouts.partials.aside')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg overflow-hidden">
        <!-- Navbar -->
        @include('layouts.partials.nav')
        <!-- End Navbar -->
        <div class="container-fluid py-4 bodyPage">
            <x-alert type="success" />
            <x-alert type="info" />
            <x-alert type="warning" />
            <x-alert type="danger" />
        </div>

        <div class="container-fluid py-4 bodyPage" style="height: 89vh;">

            {{ $slot }}

@include('layouts.partials.footer')
