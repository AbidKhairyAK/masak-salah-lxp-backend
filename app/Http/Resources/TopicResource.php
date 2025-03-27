<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
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
            'chapter_id' => $this->chapter_id,
            'title' => $this->title,
            'sort_order' => $this->sort_order,
            'type' => $this->type,
            'chapter' => new ChapterResource($this->whenLoaded('chapter')),
            'lesson' => new LessonResource($this->whenLoaded('lesson')),
            'practice' => new PracticeResource($this->whenLoaded('practice')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
} 