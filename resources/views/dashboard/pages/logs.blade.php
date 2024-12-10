<x-front-layout>
    <div class="row justify-content-center">
        <x-slot:breadcrumb>
            <li><a href="#">الأحداث</a></li>
        </x-slot:breadcrumb>
        <div class="col-12">
            <style>
                table th, table td {
                    padding: 4px 8px !important;
                }
            </style>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- table -->
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الحدث</th>
                                        <th>الرسالة</th>
                                        <th>المستخدم</th>
                                        <th>تاريخ الحدث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
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
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
                                {{$logs->links()}}
                            </div>
                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
</x-front-layout>
