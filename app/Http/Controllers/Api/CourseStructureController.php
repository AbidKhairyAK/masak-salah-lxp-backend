<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CourseStructureController extends Controller
{
    /**
     * Get the structure of a course including chapters and topics
     *
     * @param int $courseId
     * @return JsonResponse
     */
    public function show($courseId): JsonResponse
    {
        $course = Course::findOrFail($courseId);
        
        $chapters = $course->chapters()
            ->with(['topics' => function($query) {
                $query->orderBy('sort_order', 'asc')
                    ->select('id', 'chapter_id', 'title', 'type');
            }])
            ->select('id', 'title')
            ->orderBy('sort_order', 'asc')
            ->get();

        return response()->json($chapters);
    }
} 