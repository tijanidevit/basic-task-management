@extends('admin.layout.app')

@section('body')
    <div class="content container-fluid pb-0">

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome Admin!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa-solid fa-users"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$employees_count}}</h3>
                            <span>Employees</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa-solid fa-cubes"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$schedules_count}}</h3>
                            <span>Schedules</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Employees</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-nowrap custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Total schedules</th>
                                        <th>Added date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($employees as $employee)
                                    <tr>
                                        <td>{{$employee->name}}</td>
                                        <td>{{$employee->email}}</td>
                                        <td>{{$employee->schedules_count}}</td>
                                        <td>{{$employee->created_at->format('d M, Y')}}</td>
                                    </tr>
                                    @empty
                                        <x-empty-table colspan="3" />
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('employee.index')}}">View all employees</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Schedules</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-nowrap custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Start date</th>
                                        <th>End date</th>
                                        <th>Total employees</th>
                                        <th>Added date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($schedules as $schedule)
                                    <tr>
                                        <td>{{$schedule->title}}</td>
                                        <td>{{$schedule->start_date->format('d m, Y')}}</td>
                                        <td>{{$schedule->end_date->format('d m, Y')}}</td>
                                        <td>{{$schedule->employees_count}}</td>
                                        <td>{{$schedule->created_at->format('d M, Y')}}</td>
                                    </tr>
                                    @empty
                                        <x-empty-table colspan="3" />
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('schedule.index')}}">View all schedules</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
