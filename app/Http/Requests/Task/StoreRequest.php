<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'string|nullable',
            'category_id' => 'nullable|integer|exists:categories,id',
            'is_completed' => 'required|integer|between:0,1',
            'selectedLabels' => 'array',
            'selectedLabels.*.id' => 'exists:labels,id',
        ];
    }
}
