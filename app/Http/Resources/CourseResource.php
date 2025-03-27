<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'instructor_id' => $this->instructor_id,
            'instructor' => $this->whenLoaded('instructor', function() {
                return [
                    'id' => $this->instructor->id,
                    'name' => $this->instructor->name,
                ];
            }),
            'title' => $this->title,
            'caption' => $this->caption,
            'description' => $this->description,
            'image' => $this->getFirstMediaUrl('images'),
            'topic_count' => $this->when(isset($this->topic_count), $this->topic_count),
            'lesson_count' => $this->when(isset($this->lesson_count), $this->lesson_count),
            'practice_count' => $this->when(isset($this->practice_count), $this->practice_count),
            'chapters' => $this->whenLoaded('chapters'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}