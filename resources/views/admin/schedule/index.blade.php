@extends('admin.layout.app')

@section('body')
    <div class="content container-fluid pb-0">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Schedule</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">All Schedules</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{ route('schedule.create') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add
                        Schedule</a>
                </div>
            </div>
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
                    <input type="date" name="from_date" value="{{ request()->from_date }}" class="form-control floating">
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

        <div class="row">
            <div class="col-md-12 d-flex">
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
                                        <th>Date</th>
                                        <th>Shifts</th>
                                        <th>Total employees</th>
                                        <th>Added date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($schedules as $schedule)
                                        <tr>
                                            <td>{{ $schedule->title }}</td>
                                            <td>{{ $schedule->start_date->format('d M, Y') }} - {{ $schedule->end_date->format('d M, Y') }}</td>
                                            <td class="">{{ $schedule->shifts }}</td>
                                            <td>{{ $schedule->employees_count }}</td>
                                            <td>{{ $schedule->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <a href="{{route('schedule.show', $schedule->id)}}" class="btn btn-primary">
                                                    <i class="fas fa-bell me-2"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <x-empty-table colspan="5" />
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div>
                {{ $schedules->appends([
                    'search' => request()->search,
                    'from_date' => request()->from_date,
                    'to_date' => request()->to_date
                ])->links() }}
            </div>
        </div>
    </div>
@endsection
