<x-front-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">الوسطاء</li>
    </x-slot:breadcrumb>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <div class="d-flex justify-content-end p-3">
                        @can('create','App\\Models\Broker')
                        <a href="{{route('brokers.create')}}" class="btn btn-primary m-0">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                        @endcan
                    </div>
                    <table class="table align-items-center mb-0 table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-secondary opacity-7 text-center">#</th>
                                <th>الاسم</th>
                                <th>الإيميل</th>
                                <th>الجوال</th>
                                <th>العنوان</th>
                                <th>ملاحظات</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brokers as $broker)
                            <tr>
                                <td  class="text-center">{{$loop->iteration}}</td>
                                <td>{{ $broker->name }}</td>
                                <td>{{ $broker->email }}</td>
                                <td>{{ $broker->phone }}</td>
                                <td>{{ $broker->address }}</td>
                                <td>{{ $broker->notes }}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        @can('update','App\\Models\Broker')
                                        <a href="{{route('brokers.edit', $broker->slug)}}" class="text-secondary font-weight-bold text-xs"
                                            data-toggle="tooltip" >
                                            تعديل
                                        </a>
                                        @endcan
                                        @can('delete','App\\Models\Broker')
                                        <form action="{{route('brokers.destroy', $broker->slug)}}" method="post">
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
                    <div>
                        {{ $brokers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-front-layout>
