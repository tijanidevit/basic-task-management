<?php

namespace App\Services;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\Schedule;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\{Log};

class EmployeeService {
    use ResponseTrait;

    public function __construct(protected Employee $employee, protected Schedule $schedule) {
    }

    public function dashboard($data) : JsonResponse {
        try {
            $fromDate = $data['from_date'] ?? null;
            $toDate = $data['to_date'] ?? null;

            $employees_count = $this->employee->count();
            $schedules_count = $this->schedule->count();
            $schedules = $this->schedule->latest()->take(5)->get();


            return $this->successResponse("Dashboard retrieved successfully", compact('employees_count', 'schedules_count', 'schedules'));
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to retrieve dashboard. Please try again");
        }
    }

    public function index($data) : JsonResponse {
        try {
            $name = $data['name'] ?? null;
            $limit = $data['limit'] ?? null;
            $fromDate = $data['from_date'] ?? null;
            $toDate = $data['to_date'] ?? null;

            $employees = $this->employee
                    ->where(function ($query) use($name, $fromDate, $toDate) {
                        $query->search('name',$name)
                        ->filterByDate($fromDate, $toDate);
                    })
                    ->latest()
                    ->paginate($limit);

            return $this->paginatedCollection("Employees retrieved successfully", EmployeeResource::collection($employees));
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to retrieve employees. Please try again");
        }
    }

    public function store($data) : JsonResponse {
        try {
            $employee = $this->employee->create($data);
            return $this->createdResponse("Employee created successfully", new EmployeeResource($employee));
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to create employee. Please try again");

        }
    }

    public function show($id) : JsonResponse {
        try {
            $employee = $this->employee->with('schedules')->firstWhere('id',$id);

            if (!$employee) {
                return $this->notFoundResponse("Employee not found");
            }

            return $this->successResponse("Employee retrieved successfully", new EmployeeResource($employee));
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to retrieve employee. Please try again ". $ex->getMessage());
        }
    }

    public function update($data) : JsonResponse {
        try {
            $id = $data['employee_id'];
            unset($data['employee_id']);

            $this->employee->whereId($id)->update($data);

            return $this->successResponse("Employee updated successfully");
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to update employee. Please try again ");
        }
    }

    public function delete($id) : JsonResponse {
        try {
            $employee = $this->employee->find($id);

            if (!$employee) {
                return $this->notFoundResponse("Employee not found");
            }

            $employee->delete();
            return $this->successResponse("Employee deleted successfully");
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to delete employee. Please try again ");
        }
    }

    public function toggleStatus($id) : JsonResponse {
        try {
            $employee = $this->employee->find($id);

            if (!$employee) {
                return $this->notFoundResponse("Employee not found");
            }

            $newStatus = $employee->status == EmployeeStatusEnum::PENDING->value ? EmployeeStatusEnum::COMPLETED->value : EmployeeStatusEnum::PENDING->value;
            $employee->status = $newStatus;
            $employee->save();

            return $this->successResponse("Employee status toggled successfully");
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to status toggle employee. Please try again ");
        }
    }
}
