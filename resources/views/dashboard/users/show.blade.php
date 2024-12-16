<x-front-layout>

    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h3 mb-4 page-title">الصفحة الشخصية للمستخدم</h2>
            <div class="row mt-5 align-items-center">
                <div class="col-md-2 text-center mb-5">
                    <div class="avatar avatar-xl">
                        <img src="{{$user->avatar_url}}" alt="..." class="avatar-img rounded-circle">
                    </div>
                </div>
                <div class="col">
                    <div class="row align-items-start justify-content-between">
                        <div class="col-auto">
                            <h3 class="mb-3">
                                @if ($user->last_activity >= now()->subMinutes(5))
                                    <i class="fe fe-circle text-success bg-success rounded-circle"></i>
                                @else
                                    <i class="fe fe-circle"></i>
                                @endif
                                {{$user->name}}
                            </h3>
                            <p class="mb-3">أخر تواجد الساعة : <span style="font-size: 15px;" class="badge badge-{{$user->last_activity >= now()->subMinutes(5) ? 'success' : 'danger'}}">{{$user->last_activity}}</span></p>
                        </div>
                        <div class="col-auto">
                            <a href="{{route('users.edit', $user->id)}}" class="btn btn-info"><i class="fe fe-edit"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <h6 class="mb-3">الأحداث</h6>
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-striped table-bordered ">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>الحدث</th>
                                <th>الرسالة</th>
                                <th>المستخدم</th>
                                <th>تاريخ الحدث</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                @php
                                    $color = '';
                                    $type ='';
                                    if($log->type == 'create'){
                                        $type = 'اضافة';
                                        $color = 'success';
                                    }elseif($log->type == 'update'){
                                        $type = 'تعديل';
                                        $color = 'warning';
                                    }elseif($log->type == 'delete'){
                                        $type = 'حذف';
                                        $color = 'danger';
                                    }elseif($log->type == 'adoption'){
                                        $type = 'إعتماد';
                                        $color = 'secondary';
                                    }elseif($log->type == 'print'){
                                        $type = 'طباعة';
                                        $color = 'info';
                                    }
                                @endphp
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>
                                    <span class="badge badge-pill badge-{{$color}}" style="font-size: 17px;">{{$type }}</span>
                                </td>
                                <td>{{$log->message}}</td>
                                <td>{{$log->user_name}}</td>
                                <td>{{$log->created_at}}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">لم يصدر المستخدم أي حدث في أخر فترة</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- /.col-12 -->
    </div> <!-- .row -->

</x-front-layout>
