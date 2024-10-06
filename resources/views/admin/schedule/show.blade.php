@extends('admin.layout.app')

@section('body')
    <div class="content container-fluid pb-0">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">{{ $schedule->title }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Schedule Details</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{ route('schedule.index') }}" class="btn add-btn"><i class="fa-solid fa-cubes"></i> All
                        Schedules</a>
                </div>
            </div>
        </div>

        <div>
            <div class="col-12 mb-3">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button class="btn btn-outline-primary" id="openDetails">Details</button>
                    <button class="btn btn-outline-primary" id="openAssignment">Assignments</button>
                </div>
            </div>


            <div id="details">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-tile">{{ $schedule->title }}</h3>

                        <table class="my-3 table">
                            <tr>
                                <th>Start date:</th>
                                <td>{{ $schedule->start_date->format('d M, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Start date:</th>
                                <td>{{ $schedule->end_date->format('d M, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Total employees:</th>
                                <td>{{ $schedule->employee_schedules_count }}</td>
                            </tr>
                            <tr>
                                <th>Shifts:</th>
                                <td>{{ $schedule->shifts }}</td>
                            </tr>
                            <tr>
                                <th>Number of employees per shift:</th>
                                <td>{{ $schedule->staff_counts }}</td>
                            </tr>
                        </table>
                        <div>
                            <h5>Description</h5>
                            <p>{{ $schedule->description }}</p>
                        </div>
                    </div>
                </div>
            </div>


            <div style="display: none" id="appointments">
                <form class="row filter-row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="input-block mb-3 form-focus">
                            <input type="text" name="search" value="{{ request()->search }}" class="form-control floating">
                            <label class="focus-label">Schedule name or description</label>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3">
                        <div class="input-block mb-3 form-focus">
                            <input type="date" min="{{ $schedule->start_date }}" max="{{ $schedule->end_date }}"
                                name="from_date" value="{{ request()->from_date }}" class="form-control floating">
                            <label class="focus-label">Filter from date</label>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3">
                        <div class="input-block mb-3 form-focus">
                            <input type="date" min="{{ $schedule->start_date }}" max="{{ $schedule->end_date }}"
                                name="to_date" value="{{ request()->to_date }}" class="form-control floating">
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
                                    <td>{{ $employeeSchedule->employee->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $('#openAssignment').click(function (e) {
            $('#details').hide();
            $('#appointments').show();
        })

        $('#openDetails').click(function (e) {
            $('#appointments').hide();
            $('#details').show();
        })
    </script>
@endsection
