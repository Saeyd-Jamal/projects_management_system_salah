@if (session()->has($type))
    <style>
        .alert {
            animation: slide-left 2s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        }
        @keyframes slide-left {
            0% {
                -webkit-transform: translateX(-100px);
                        transform: translateX(-100px);
            }
            100% {
                -webkit-transform: translateX(0);
                        transform: translateX(0);
            }
        }

    </style>
    <div class="alert alert-{{ $type }} alert-dismissible fade show position-absolute" role="alert" style="width: 300px; top: 15px; z-index: 999;">
        <span class="alert-icon">
            <i class="ni ni-like-2"></i>
        </span>
        <span class="alert-text">
            {{ session($type) }}
        </span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif
