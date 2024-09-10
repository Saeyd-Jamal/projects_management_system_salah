<x-front-layout>
    <x-slot:breadcrumb>
        {{-- <li class="breadcrumb-item text-sm text-dark">RTL</li> --}}
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">المستخدمين</li>
    </x-slot:breadcrumb>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <div class="d-flex justify-content-end p-3">
                        @can('create','App\\Models\Currency')
                        <button class="btn btn-primary m-0" data-bs-toggle="modal" data-bs-target="#createCurrency">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                    <table class="table align-items-center mb-0 table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-secondary opacity-7 text-center">#</th>
                                <th>الاسم</th>
                                <th>الرمز</th>
                                <th>القيمة مقابل الدولار</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($currencies as $currency)
                            <tr @can('update','App\\Models\Currency')data-bs-toggle="modal" data-bs-target="#editCurrency-{{$currency->id}}"@endcan >
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td>{{ $currency->name }}</td>
                                <td>{{ $currency->code }}</td>
                                <td>{{ $currency->value }}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        @can('delete','App\\Models\Currency')
                                        <form action="{{route('currencies.destroy', $currency->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-link text-danger text-gradient px-3 mb-0" data-toggle="tooltip" data-original-title="Delete user">
                                                حذف
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- create Item --}}
    @can('create','App\\Models\Currency')
    <div class="modal fade" id="createCurrency" tabindex="-1" aria-labelledby="createCurrencyLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createCurrencyLabel">إضافة عملة جديدة</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('currencies.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <x-form.input type="text" name="name" label="الاسم" placeholder="إملأ الاسم : الدولار" autofocus required />
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.input type="text" name="code" label="الرمز بالإنجليزي" placeholder="إملأ الرمز : USD"  required />
                        </div>
                        <div class="form-group col-md-12">
                            <x-form.input type="number" min="0" step="0.01" name="value" label="القيمة مقابل الدولار" placeholder="إملأ القيمة : 3.6"  required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">إضافة</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    @endcan
    {{-- edit Item --}}
    @can('update','App\\Models\Currency')
    @foreach ($currencies as $currency)
    <div class="modal fade" id="editCurrency-{{$currency->id}}" tabindex="-1" aria-labelledby="editCurrencyLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editCurrencyLabel">تعديل عملة {{$currency->name}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('currencies.update', $currency->id)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <x-form.input type="text" name="name" label="الاسم" :value="$currency->name" placeholder="إملأ الاسم : الدولار" autofocus required />
                            </div>
                            <div class="form-group col-md-6">
                                <x-form.input type="text" name="code" label="الرمز بالإنجليزي" :value="$currency->code" placeholder="إملأ الرمز : USD"  required />
                            </div>
                            <div class="form-group col-md-12">
                                <x-form.input type="number" min="0" step="0.01" name="value" label="الاسم" :value="$currency->value" placeholder="إملأ القيمة : 1.1" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer  flex-row-reverse justify-content-start align-items-start">
                        <button type="submit" class="btn btn-primary">تعديل</button>
                    </form>
                        @can('delete','App\\Models\Currency')
                            <form action="{{route('currencies.destroy', $currency->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        @endcan
                    </div>
            </div>
        </div>
    </div>
    @endforeach
    @endcan
</x-front-layout>
