<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedule\StoreRequest;
use App\Models\Employee;
use App\Models\Schedule;
use App\Helpers\GeneticAlgorithm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request): View
    {
        $search = $request->search;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $schedules = Schedule::where(function ($query) use ($search) {
            $query->search('title', $search)->orSearch('description', $search);
        })
            ->filterByDate($fromDate, $toDate, 'start_date')
            ->latest()
            ->withCount('employees')
            ->paginate();

        return view('admin.schedule.index', compact('schedules'));
    }

    public function create(): View
    {
        $employees = Employee::oldest('name')->get();

        return view('admin.schedule.create', compact('employees'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $schedule = Schedule::create(Arr::except($data, 'employees'));

        $assignments = (new GeneticAlgorithm($data['employees'], $data['start_date'], $data['end_date'], $data['staff_counts'], $data['shifts']))->generateSchedule();

        $schedule_id = $schedule->id;

        $employeeSchedules = [];

        foreach ($assignments as $assignment) {
            $date = $assignment['date'];
            $shift = $assignment['shift'];
            $employees = $assignment['staff'];

            foreach ($employees as $employee_id) {
                $employeeSchedules[] = [
                    'employee_id' => $employee_id,
                    'schedule_id' => $schedule_id,
                    'shift' => $shift,
                    'date' => $date,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('employee_schedules')->insert($employeeSchedules);

        return to_route('schedule.show', $schedule_id);
    }

    public function show(Request $request,$id): View
    {
        $schedule = Schedule::with(['employeeSchedules.employee'])->withCount('employeeSchedules')->find($id);

        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $employeeName = $request->input('search');

        $employeeSchedules = $schedule->employeeSchedules();

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

        return view('admin.schedule.show', compact('schedule', 'appointments'));
    }
}
