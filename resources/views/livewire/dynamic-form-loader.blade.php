<div class="container-fluid">
    <div class="row">
        <div class="form-group p-3 col-md-3">
            <label for="selectedForm">إختيار النموذج المطلوب</label>
            <select class="form-control" id="selectedForm" wire:model="selectedForm" wire:change="loadForm">
                <option label="فتح القائمة"></option>
                @can('allocation', 'App\\Models\AccreditationProject')
                    <option value="allocations">التخصيص</option>
                @endcan
                @can('execution', 'App\\Models\AccreditationProject')
                    <option value="executives">تنفيذ</option>
                @endcan
            </select>
        </div>
    </div>
    <div class="row">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    <div>
                        {{$errors}}
                    </div>
                    @foreach ($errors->all() as $key => $error)
                        <li>{{ $key }} : {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($selectedForm === 'allocations')
            @if ($allocation)
                <form action="{{ route('accreditations.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <livewire:allocation-form-create :allocation="$allocation" />
                    <input type="hidden" name="type" value="allocation">
                </form>
            @else
                <p>لا توجد بيانات للتخصيص.</p>
            @endif
        @elseif ($selectedForm === 'executives')
            @if ($executive)
                <form action="{{ route('accreditations.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <livewire:executive-form :executive="$executive" />
                    <input type="hidden" name="type" value="executive">
                </form>
            @else
                <p>لا توجد بيانات للتنفيذ.</p>
            @endif
        @endif
    </div>
</div>
