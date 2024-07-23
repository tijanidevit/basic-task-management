<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'task_id' => [
                'required',
                Rule::exists('tasks','id')->where('user_id', auth()->id()),
            ],
            'name' => 'required|string',
            'description' => 'sometimes|nullable|string',
            'status' => [
                'sometimes',
                'nullable',
                'string',
                Rule::in(TaskStatusEnum::toArray())
            ]
        ];
    }
}
