<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
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
            'course_id' => $this->course_id,
            'course' => $this->whenLoaded('course', function() {
                return [
                    'id' => $this->course->id,
                    'title' => $this->course->title,
                ];
            }),
            'title' => $this->title,
            'topics' => $this->whenLoaded('topics'),
            'topics_count' => $this->whenLoaded('topics', function() {
                return $this->topics->count();
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
} 