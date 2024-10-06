@extends('admin.layout.app')

@section('body')
    <div class="content container-fluid pb-0">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">New Employee</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add a new Employee</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{ route('employee.index') }}" class="btn add-btn"><i class="fa-solid fa-users"></i> All
                        Employee</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Employee Form</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('employee.store')}}" method="POST">
                            <x-alert />
                            @csrf
                            <div class="input-block mb-3">
                                <label class="col-form-label mb-2">Name</label>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="name"> <i class="fa fa-user"></i> </span>
                                        <input type="text" name="name" required class="form-control" placeholder="Fullname"
                                            aria-label="Fullname" value="{{old('name')}}" aria-describedby="name">
                                    </div>
                                    <x-error-message record='name' />
                                </div>
                            </div>


                            <div class="input-block mb-3">
                                <label class="col-form-label mb-2">Email address</label>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                                        <input type="email" name="email" required class="form-control" placeholder="Email"
                                            aria-label="Email" value="{{old('email')}}" aria-describedby="basic-addon1">
                                    </div>
                                    <x-error-message record='email' />
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
