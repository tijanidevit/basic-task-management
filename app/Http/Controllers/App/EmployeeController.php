<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreRequest;
use App\Http\Requests\Employee\UpdateRequest;
use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
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
        $limit = $request->limit;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $employees = Employee::where(function ($query) use ($search) {
            $query->search('email', $search)->orSearch('name', $search);
        })
            ->filterByDate($fromDate, $toDate)
            ->latest()
            ->paginate($limit);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        return $this->taskService->store($request->validated());
    }

    public function show($id): JsonResponse
    {
        return $this->taskService->show($id);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        return $this->taskService->update($request->validated());
    }

    public function delete($id): JsonResponse
    {
        return $this->taskService->delete($id);
    }

    public function toggleStatus($id): JsonResponse
    {
        return $this->taskService->toggleStatus($id);
    }
}
