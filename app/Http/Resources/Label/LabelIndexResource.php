<?php

namespace App\Http\Resources\Label;

use App\Http\Resources\Task\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LabelIndexResource extends JsonResource
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
            'date' => $this->created_at->diffForHumans(),
            'updated_date' => $this->updated_at->diffForHumans(),
            'color' => $this->color,
        ];
    }
}
