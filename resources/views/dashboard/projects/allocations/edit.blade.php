<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark">التخصيصات</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">تعديل التخصيص</li>
    </x-slot:breadcrumb>


    <div class="row">
        <form id="UploadfileID" action="{{ route('allocations.update', $allocation->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <livewire:allocation-form :allocation="$allocation" :btn_label="__('تعديل')" :editForm="true"  />
        </form>
        <livewire:files :files="$files" :obj="$allocation" />
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
