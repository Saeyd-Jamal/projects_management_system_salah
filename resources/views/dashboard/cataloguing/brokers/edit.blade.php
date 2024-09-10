<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark">الوسطاء</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">تعديل الوسيط</li>
    </x-slot:breadcrumb>


    <div class="row">
        <form id="UploadfileID" action="{{ route('brokers.update', $broker->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            @include('dashboard.cataloguing.brokers._form')
        </form>
        <livewire:files :files="$files" :obj="$broker" />
    </div>
    @push('scripts')
    <script>
        $(function () {
            $(document).ready(function () {
                var message = $('.success__msg');
                $('#UploadfileID').ajaxForm({
                    beforeSend: function () {
                        var percentage = '0';
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        var percentage = percentComplete;
                        $('.progress .progress-bar').css("width", percentage+'%', function() {
                            return $(this).attr("aria-valuenow", percentage) + "%";
                        })
                    },
                    complete: function (xhr) {
                        location.reload();
                    }
                });
            });
        });
    </script>
    @endpush
</x-front-layout>
