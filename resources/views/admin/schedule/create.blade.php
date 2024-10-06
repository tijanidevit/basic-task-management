@extends('admin.layout.app')

@section('body')
    <div class="content container-fluid pb-0">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">New Schedule</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add a new Schedule</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{ route('schedule.index') }}" class="btn add-btn"><i class="fa-solid fa-cubes"></i> All
                        Schedule</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Schedule Form</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('schedule.store') }}" method="POST">
                            @csrf

                            <x-alert />
                            <div class="input-block mb-2">
                                <label class="col-form-label mb-1">Title</label>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="title"> <i class="fa fa-cubes"></i> </span>
                                        <input type="text" name="title" required class="form-control"
                                            placeholder="Schedule title" aria-label="Schedule title"
                                            value="{{ old('title') }}" aria-describedby="title">
                                    </div>
                                    <x-error-message record='title' />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-block mb-2">
                                        <label class="col-form-label mb-1">Start Date</label>
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <span class="input-group-text" id="start_date"> <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="date" name="start_date" required class="form-control"
                                                    aria-label="Schedule start_date" value="{{ old('start_date') }}"
                                                    aria-describedby="start_date">
                                            </div>
                                            <x-error-message record='start_date' />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-block mb-2">
                                        <label class="col-form-label mb-1">End Date</label>
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <span class="input-group-text" id="end_date"> <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="date" name="end_date" required class="form-control"
                                                    aria-label="Schedule end_date" value="{{ old('end_date') }}"
                                                    aria-describedby="end_date">
                                            </div>
                                            <x-error-message record='end_date' />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-block mb-2">
                                        <label class="col-form-label mb-1">Shifts (separate muliple shifts with comma)</label>
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <span class="input-group-text" id="shifts"> <i class="fa fa-briefcase"></i>
                                                </span>
                                                <input placeholder="morning,afternoon" type="text" name="shifts" required class="form-control"
                                                    aria-label="Schedule shifts" value="{{ old('shifts') }}"
                                                    aria-describedby="shifts">
                                            </div>
                                            <x-error-message record='shifts' />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-block mb-2">
                                        <label class="col-form-label mb-1">Number of staff needed per shift</label>
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <span class="input-group-text" id="staff_counts"> <i class="fa fa-users"></i>
                                                </span>
                                                <input type="text" name="staff_counts" required class="form-control"
                                                    aria-label="Schedule staff_counts" placeholder="2" value="{{ old('staff_counts') }}"
                                                    aria-describedby="staff_counts">
                                            </div>
                                            <x-error-message record='staff_counts' />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="input-block mb-2">
                                <label class="col-form-label mb-1">Description</label>
                                <div class="col-lg-12">
                                    <textarea rows="5" name="description" required class="form-control" placeholder="Description"
                                        aria-label="description" aria-describedby="basic-addon1">{{ old('description') }}</textarea>
                                    <x-error-message record='description' />
                                </div>
                            </div>

                            <div class="input-block mb-2">
                                <label class="col-form-label mb-1">Select Employees</label>
                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <label for="select_all">
                                            <input type="checkbox" id="select_all"> Select All Employees
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    @forelse ($employees as $employee)
                                        <div class="col-6 col-lg-3">
                                            <label for="employees_{{ $employee->id }}">
                                                <input type="checkbox" name="employees[]" id="employees_{{ $employee->id }}"
                                                    value="{{ $employee->id }}"
                                                    {{ in_array($employee->id, old('employees', [])) ? 'checked' : '' }}>
                                                {{ $employee->name }}
                                            </label>
                                        </div>
                                    @empty
                                        <x-empty-table />
                                    @endforelse
                                </div>
                            </div>

                            <div>
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('select_all').addEventListener('change', function(e) {
            const isChecked = e.target.checked;
            document.querySelectorAll('input[name="employees[]"]').forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });
    </script>
@endsection
