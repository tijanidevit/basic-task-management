<?php

namespace App\Services;

use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\{Log};

class ScheduleService {
    use ResponseTrait;

    public function __construct(protected Schedule $schedule) {
    }


    public function index($data) : JsonResponse {
        try {
            $name = $data['name'] ?? null;
            $limit = $data['limit'] ?? null;
            $fromDate = $data['from_date'] ?? null;
            $toDate = $data['to_date'] ?? null;

            $employees = $this->schedule
                    ->where(function ($query) use($name, $fromDate, $toDate) {
                        $query->search('name',$name)
                        ->filterByDate($fromDate, $toDate);
                    })
                    ->latest()
                    ->paginate($limit);

            return $this->paginatedCollection("Schedules retrieved successfully", ScheduleResource::collection($employees));
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to retrieve employees. Please try again");
        }
    }

    public function store($data) : JsonResponse {
        try {
            $schedule = $this->schedule->create($data);
            return $this->createdResponse("Schedule created successfully", new ScheduleResource($schedule));
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to create schedule. Please try again");

        }
    }

    public function show($id) : JsonResponse {
        try {
            $schedule = $this->schedule->find($id);

            if (!$schedule) {
                return $this->notFoundResponse("Schedule not found");
            }

            return $this->successResponse("Schedule retrieved successfully", new ScheduleResource($schedule));
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to retrieve schedule. Please try again ");
        }
    }

    public function update($data) : JsonResponse {
        try {
            $id = $data['employee_id'];
            unset($data['employee_id']);

            $this->schedule->whereId($id)->update($data);

            return $this->successResponse("Schedule updated successfully");
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to update schedule. Please try again ");
        }
    }

    public function delete($id) : JsonResponse {
        try {
            $schedule = $this->schedule->find($id);

            if (!$schedule) {
                return $this->notFoundResponse("Schedule not found");
            }

            $schedule->delete();
            return $this->successResponse("Schedule deleted successfully");
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to delete schedule. Please try again ");
        }
    }

    public function toggleStatus($id) : JsonResponse {
        try {
            $schedule = $this->schedule->find($id);

            if (!$schedule) {
                return $this->notFoundResponse("Schedule not found");
            }

            $newStatus = $schedule->status == ScheduleStatusEnum::PENDING->value ? ScheduleStatusEnum::COMPLETED->value : ScheduleStatusEnum::PENDING->value;
            $schedule->status = $newStatus;
            $schedule->save();

            return $this->successResponse("Schedule status toggled successfully");
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to status toggle schedule. Please try again ");
        }
    }
}
