<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark">المشاريع</li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">تعديل المشروع</li>
    </x-slot:breadcrumb>


    <div class="row">
        <form id="UploadfileID" action="{{ route('projects.update', $project->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            @include('dashboard.cataloguing.projects._form')
        </form>
        <livewire:files :files="$files" :obj="$project" />
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
