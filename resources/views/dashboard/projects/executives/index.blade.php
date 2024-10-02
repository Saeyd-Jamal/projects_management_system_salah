<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="#">التنفيذات</a></li>
    </x-slot:breadcrumb>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <livewire:executive-index />
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#expandBtn', function() {
                $('nav.navbar').css('display', 'none');
                $('aside').css('display', 'none');
                $('.main-content').css('margin', '0');
                $(this).html('<i class="fe fe-minimize"></i>');
                $(this).attr('id', 'collapseBtn');
            });

            $(document).on('click', '#collapseBtn', function() {
                $('nav.navbar').css('display', 'flex');
                $('aside').css('display', 'block');
                $('.main-content').css('margin-right', '17.125rem');
                $(this).html('<i class="fe fe-maximize"></i>');
                $(this).attr('id', 'expandBtn');
            });
            $(document).on('click', '#filterBtn', function() {
                $('#filter').slideToggle();
            });
        });

    </script>
    @endpush
</x-front-layout>
