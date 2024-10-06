@extends('admin.layout.app')

@section('body')
    <div class="content container-fluid pb-0">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">{{ $employee->name }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee Details</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{ route('schedule.index') }}" class="btn add-btn"><i class="fa-solid fa-cubes"></i> All
                        Employees</a>
                </div>
            </div>
        </div>

        <div>
            <div class="col-12 mb-3">
                Email: {{ $employee->email }}
            </div>

            <form class="row filter-row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="input-block mb-3 form-focus">
                        <input type="text" name="search" value="{{ request()->search }}" class="form-control floating">
                        <label class="focus-label">Schedule name or description</label>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-3">
                    <div class="input-block mb-3 form-focus">
                        <input type="date" name="from_date" value="{{ request()->from_date }}"
                            class="form-control floating">
                        <label class="focus-label">Filter from date</label>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-3">
                    <div class="input-block mb-3 form-focus">
                        <input type="date" name="to_date" value="{{ request()->to_date }}" class="form-control floating">
                        <label class="focus-label">Filter to date</label>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-3">
                    <button class="btn btn-success w-100"> Search </button>
                </div>
            </form>

            @foreach ($appointments as $date => $employeeSchedules)
                <h4 class="card-title mb-2">Date: {{ $date }}</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Shift</th>
                            <th>Employee Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeSchedules as $employeeSchedule)
                            <tr>
                                <td class="text-capitalize">{{ $employeeSchedule->shift }}</td>
                                <td>{{ $employeeSchedule->schedule->title }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
@endsection
