<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="#">المستخدمين</a></li>
    </x-slot:breadcrumb>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <div class="d-flex justify-content-end p-3">
                        @can('create', 'App\Models\User')
                        <a href="{{route('users.create')}}" class="btn btn-primary m-0">
                            <i class="fe fe-plus"></i>
                        </a>
                        @endcan
                    </div>
                    <table class="table align-items-center mb-0 table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-secondary opacity-7 text-center">#</th>
                                <th class=" text-center ">
                                    حالة <br> النشاط
                                </th>
                                <th >
                                    الاسم
                                </th>
                                <th>
                                    اسم المستخدم
                                </th>
                                <th>
                                    رقم الهاتف
                                </th>
                                <th>
                                    البريد الالكتروني
                                </th>
                                <th>
                                    أخر نشاط
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <style>
                            #user-1{
                                display: none;
                            }
                        </style>
                        <tbody>
                            @foreach ($users as $user)
                            <tr id="user-{{$user->id}}">
                                <td  class="text-center">{{$loop->iteration - 1}}</td>
                                @if ($user->last_activity >= now()->subMinutes(5))
                                    <td class="text-center">
                                        <i class="fe fe-circle text-success bg-success rounded-circle"></i>
                                    </td>
                                @else
                                    <td  class="text-center">
                                        <i class="fe fe-circle"></i>
                                    </td>
                                @endif
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div>
                                            <img src="{{ $user->avatar_url }}" class="avatar avatar-sm me-3" width="50px">
                                        </div>
                                        <div class="ml-3">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ $user->username }}
                                </td>
                                <td class="align-middle ">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $user->phone }}</span>
                                </td>
                                <td class="align-middle ">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $user->email ?? '-' }}</span>
                                </td>
                                <td class="align-middle ">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $user->last_activity ?? '-' }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        @can('update','App\\Models\User')
                                        <a href="{{route('users.edit', $user->id)}}" class="text-secondary font-weight-bold text-xs"
                                            data-toggle="tooltip" data-original-title="Edit user">
                                            تعديل
                                        </a>
                                        @endcan
                                        @can('delete','App\\Models\User')
                                        <form action="{{route('users.destroy', $user->id)}}" method="post">
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

</x-front-layout>
