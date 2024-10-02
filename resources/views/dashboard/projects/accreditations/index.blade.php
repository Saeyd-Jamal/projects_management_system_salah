<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="{{ route('accreditations.index') }}">مشاريع الإعتماد</a></li>
    </x-slot:breadcrumb>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <div class="d-flex justify-content-end p-3 align-items-start">
                        @can('create','App\\Models\AccreditationProject')
                        <a href="{{route('accreditations.create')}}" class="btn btn-primary m-0">
                            <i class="fe fe-plus"></i>
                        </a>
                        @endcan
                    </div>
                    <div>
                        <table class="table align-items-center mb-0 table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-secondary opacity-7 text-center">#</th>
                                    <th>النوع</th>
                                    <th>المؤسسة (الاسم المختصر)</th>
                                    <th>المشروع</th>
                                    <th>الصنف</th>
                                    <th>الكمية</th>
                                    <th>المبلغ الإجمالي</th>
                                    <th>ملاحظات</th>
                                    <th>اسم المستخدم</th>
                                    <th>المدير المستلم</th>
                                    <th>تاريخ الإضافة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accreditations as $accreditation)
                                <tr>
                                    <td class="text-center">
                                        @can('update', 'App\\Models\AccreditationProject')
                                        <a href="{{route('accreditations.edit', $accreditation->id)}}" class="btn btn-success btn-sm p-2">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        @endcan
                                        @can('delete', 'App\\Models\AccreditationProject')
                                        <form action="{{route('accreditations.destroy', $accreditation->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm p-2">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td>{{ ($accreditation->type == 'allocation') ? 'تخصيص' : 'تنفيذ' }}</td>
                                    <td>{{ $accreditation->broker_name }}</td>
                                    <td>{{ $accreditation->project_name }}</td>
                                    <td>{{ $accreditation->item_name }}</td>
                                    <td>{{ $accreditation->quantity }}</td>
                                    <td>{{ ($accreditation->amount != null) ? $accreditation->amount : $accreditation->total_ils }}</td>
                                    <td>{{ $accreditation->notes }}</td>
                                    <td>{{ $accreditation->user->name }}</td>
                                    <td>{{ $accreditation->manager_name }}</td>
                                    <td>{{ $accreditation->created_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $accreditations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
