<?php

namespace App\Http\Controllers;

use App\Http\Requests\Schedule\StoreRequest;
use App\Services\ScheduleService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct(protected ScheduleService $taskService) {
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

    public function delete($id) : JsonResponse {
        return $this->taskService->delete($id);
    }

    public function toggleStatus($id) : JsonResponse {
        return $this->taskService->toggleStatus($id);
    }
}
