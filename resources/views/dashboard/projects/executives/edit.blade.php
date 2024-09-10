<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark">التنفيذات</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">تعديل التنفيذ</li>
    </x-slot:breadcrumb>


    <div class="row">
        <form id="UploadfileID" action="{{ route('executives.update', $executive->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <livewire:executive-form :executive="$executive" :btn_label="__('تعديل')" :editForm="true"  />
        </form>
        <livewire:files :files="$files" :obj="$executive" />
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
