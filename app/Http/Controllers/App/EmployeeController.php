<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreRequest;
use App\Http\Requests\Employee\UpdateRequest;
use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct()
    {
    }

    public function dashboard(Request $request): View
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $employees_count = Employee::count();
        $schedules_count = Schedule::count();
        $employees = Employee::latest()->withCount('schedules')->take(5)->get();
        $schedules = Schedule::latest()->withCount('employees')->take(5)->get();

        return view('admin.dashboard', compact('employees_count', 'schedules_count', 'schedules', 'employees'));
    }

    public function index(Request $request): View
    {
        $search = $request->search;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $employees = Employee::where(function ($query) use ($search) {
            $query->search('email', $search)->orSearch('name', $search);
        })
            ->filterByDate($fromDate, $toDate)
            ->latest()
            ->withCount('schedules')
            ->paginate();

        return view('admin.employee.index', compact('employees'));
    }

    public function create(): View
    {
        return view('admin.employee.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        Employee::create($request->validated());

        return back()->with('success', 'Employee added successfully');
    }

    public function show(Request $request,$id): View
    {
        $employee = Employee::with(['employeeSchedules.schedule'])->withCount('employeeSchedules')->find($id);

        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $employeeName = $request->input('search');

        $employeeSchedules = $employee->employeeSchedules();

        if ($fromDate && $toDate) {
            $employeeSchedules = $employeeSchedules->whereBetween('date', [$fromDate, $toDate]);
        }

        if ($employeeName) {
            $employeeSchedules = $employeeSchedules->whereHas('employee', function ($query) use ($employeeName) {
                $query->where('name', 'like', '%' . $employeeName . '%');
            });
        }

        $employeeSchedules = $employeeSchedules->get();

        $appointments = $employeeSchedules->groupBy('date');

        return view('admin.employee.show', compact('employee', 'appointments'));
    }
}
