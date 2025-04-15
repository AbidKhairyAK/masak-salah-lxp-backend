<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TopicContentController extends Controller
{
    /**
     * Get the content of a topic based on its type
     *
     * @param int $topicId
     * @return JsonResponse
     */
    public function show($topicId): JsonResponse
    {
        $topic = Topic::with('lesson')->findOrFail($topicId);
        
        // Get the lesson's content based on type
        $lesson = $topic->lesson;
        if ($lesson) {
            $content = $lesson->children_model()->first();
            $lesson = [
                'type' => $lesson->type,
                $lesson->type => $content
            ];
        }

        return response()->json([
            'id' => $topic->id,
            'title' => $topic->title,
            'lesson' => $lesson ?? null
        ]);
    }
} 