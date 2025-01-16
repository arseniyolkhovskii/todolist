<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\Label\LabelTasks;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category?->title ?? 'Без категории',
            'is_completed' => $this->is_completed,
            'labels' => $this->labels->toArray(),
            'date' => $this->created_at->diffForHumans(),
            'updated_date' => $this->updated_at->diffForHumans(),

        ];
    }
}
