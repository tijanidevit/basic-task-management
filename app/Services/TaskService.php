<?php

namespace App\Services;

use App\Enums\TaskStatusEnum;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\{Log};
use Illuminate\Support\Str;

class TaskService {
    use ResponseTrait;

    public function __construct(protected Task $task) {
    }

    public function index($data) : JsonResponse {
        try {
            $name = $data['name'] ?? null;
            $status = $data['status'] ?? null;
            $limit = $data['limit'] ?? null;
            $fromDate = $data['from_date'] ?? null;
            $toDate = $data['to_date'] ?? null;

            $tasks = auth()->user()->tasks()
                    ->where(function ($query) use($name, $status, $fromDate, $toDate) {
                        $query->search('name',$name)
                        ->filterBy('status',$status)
                        ->filterByDate($fromDate, $toDate);
                    })
                    ->latest()
                    ->paginate($limit);

            return $this->paginatedCollection("Tasks retrieved successfully", TaskResource::collection($tasks));
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to retrieve tasks. Please try again");
        }
    }

    public function store($data) : JsonResponse {
        try {
            $task = $this->task->create($data);
            return $this->createdResponse("Task created successfully", new TaskResource($task));
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to create task. Please try again" . $ex->getMessage());

        }
    }

    public function show($id) : JsonResponse {
        try {
            $task = auth()->user()->tasks()->find($id);

            if (!$task) {
                return $this->notFoundResponse("Task not found");
            }

            return $this->successResponse("Task retrieved successfully", new TaskResource($task));
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to retrieve task. Please try again ");
        }
    }

    public function update($data) : JsonResponse {
        try {
            $id = $data['task_id'];
            unset($data['task_id']);

            $this->task->whereId($id)->update($data);

            return $this->successResponse("Task updated successfully");
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to update task. Please try again ");
        }
    }

    public function delete($id) : JsonResponse {
        try {
            $task = auth()->user()->tasks()->find($id);

            if (!$task) {
                return $this->notFoundResponse("Task not found");
            }

            $task->delete();
            return $this->successResponse("Task deleted successfully");
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to delete task. Please try again ");
        }
    }

    public function toggleStatus($id) : JsonResponse {
        try {
            $task = auth()->user()->tasks()->find($id);

            if (!$task) {
                return $this->notFoundResponse("Task not found");
            }

            $newStatus = $task->status == TaskStatusEnum::PENDING->value ? TaskStatusEnum::COMPLETED->value : TaskStatusEnum::PENDING->value;
            $task->status = $newStatus;
            $task->save();

            return $this->successResponse("Task status toggled successfully");
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            return $this->errorResponse("Unable to status toggle task. Please try again ");
        }
    }
}
