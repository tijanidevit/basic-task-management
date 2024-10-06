@extends('admin.layout.app')

@section('body')
    <div class="content container-fluid pb-0">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Employee</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">All Employees</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{route('employee.create')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Employee</a>
                </div>
            </div>
        </div>

        <form class="row filter-row">
            <div class="col-sm-9 col-md-9">
                <div class="input-block mb-3 form-focus">
                    <input type="text" name="search" value="{{request()->search}}" class="form-control floating">
                    <label class="focus-label">Employee name or email address</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <button class="btn btn-success w-100"> Search </button>
            </div>
        </form>

        <div class="row">
            <div class="col-md-12 d-flex">
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($employees as $employee)
                                    <tr>
                                        <td>{{$employee->name}}</td>
                                        <td>{{$employee->email}}</td>
                                        <td>{{$employee->schedules_count}}</td>
                                        <td>{{$employee->created_at->format('d M, Y')}}</td>
                                        <td>
                                            <a href="{{route('employee.show', $employee->id)}}" class="btn btn-primary">
                                                <i class="fas fa-bell me-2"></i>View
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                        <x-empty-table colspan="4" />
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div>
                {{$employees->appends(['search' => request()->search])->links()}}
            </div>
        </div>
    </div>
@endsection
