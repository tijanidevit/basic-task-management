<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Services\TaskService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService) {
    }

    public function index(Request $request) : JsonResponse {
        return $this->taskService->index($request->all());
    }

    public function store(StoreRequest $request) : JsonResponse {
        return $this->taskService->store($request->validated());
    }

    public function show($id) : JsonResponse {
        return $this->taskService->show($id);
    }

    public function update(UpdateRequest $request) : JsonResponse {
        return $this->taskService->update($request->validated());
    }

    public function delete($id) : JsonResponse {
        return $this->taskService->delete($id);
    }

    public function toggleStatus($id) : JsonResponse {
        return $this->taskService->toggleStatus($id);
    }
}
