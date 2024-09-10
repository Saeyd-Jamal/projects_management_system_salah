@push('styles')
<style>
    #user-roles{
        display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-auto-rows: minmax(auto, auto);
    gap: 5px 75px;
    }
</style>
@endpush
<div class="row">
    <div class="form-group col-md-6">
        <x-form.input type="text" name="name" label="اسم الصلاحية" :value="$role->name" placeholder="إملأ الاسم" autofocus required />
    </div>

    <div class="form-group col-md-12">
        <x-form.textarea name="description" label="الوصف" placeholder="إملأ الوصف" :value="$role->description" />
    </div>
</div>
<div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary m-0">
        @if (isset($btn_label))
            <i class="fa-solid fa-pen-to-square"></i>
            {{$btn_label}}
        @else
            <i class="fa-solid fa-plus"></i>
            اضافة
        @endif
    </button>
</div>
<div class="row ml-3">
    <legend>الصلاحيات</legend>
    <fieldset id="user-roles" class="col-12">
        @foreach (app('abilities') as $abilities_name => $ability_array)
            <div class="mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row flex-column align-items-start pl-2 pr-2">
                            <div class="d-flex">
                                <input class="form-control-input abilities_all" type="checkbox" id="{{$abilities_name}}" >
                                <label class="h3 p-2" for="{{$abilities_name}}">{{$ability_array['name']}}</label>
                            </div>
                            @foreach ($ability_array as $ability_name => $ability)
                                @if ($ability_name != 'name')
                                <div class="custom-control custom-checkbox" style="margin-right: 0;">
                                    <input class="form-control-input abilities_{{$abilities_name}}" type="checkbox" name="abilities[]" id="ability-{{$abilities_name . '.' . $ability_name}}" value="{{$abilities_name . '.' . $ability_name}}" @checked(in_array($abilities_name . '.' . $ability_name, $role->permissions()->pluck('name')->toArray())) >
                                    <label class="custom-control-label" for="ability-{{$abilities_name . '.' . $ability_name}}">
                                        {{$ability}}
                                    </label>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </fieldset>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('input.abilities_all').on('click', function() {
                    $('fieldset#user-roles input.abilities_' + $(this).attr('id')).prop('checked', $(this).is(':checked'));
                });
            });
        </script>
    @endpush
</div>
