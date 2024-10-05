<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\StoreRequest;
use App\Http\Requests\Employee\UpdateRequest;
use App\Services\EmployeeService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(protected EmployeeService $taskService) {
    }

    public function dashboard(Request $request) : JsonResponse {
        return $this->taskService->dashboard($request->all());
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
