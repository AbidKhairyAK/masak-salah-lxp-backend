<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
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
                'id' => $lesson->id,
                'type' => $lesson->type,
                $lesson->type => $content
            ];
        }

        $practice = $topic->practice;

        return response()->json([
            'id' => $topic->id,
            'title' => $topic->title,
            'lesson' => $lesson ?? null,
            'practice' => $practice ?? null,
        ]);
    }

    public function navigation($topicId): JsonResponse
    {
        $topic = Topic::findOrFail($topicId);
        $courseId = $topic->chapter->course_id;
        $courses = Course::with(['chapters.topics'])->findOrFail($courseId);
        $topics = $courses->chapters
        ->flatMap(function ($chapter) {
            return $chapter->topics;
        })
        ->sortBy([
            'chapter.id', 
            'sort_order'           
        ]);

        $currentIndex = $topics->search(function ($topic) use ($topicId) {
            return $topic->id == $topicId;
        });

        $prevTopic = $currentIndex > 0 ? $topics[$currentIndex - 1] : null;
        $nextTopic = $currentIndex < $topics->count() - 1 ? $topics[$currentIndex + 1] : null;
        return response()->json([
            'course_id' => $courseId,
            'prev_topic_id' => $prevTopic?->id,
            'next_topic_id' => $nextTopic?->id,
        ]);
    }


} 