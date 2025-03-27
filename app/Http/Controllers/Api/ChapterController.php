<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChapterRequest;
use App\Http\Resources\ChapterCollection;
use App\Http\Resources\ChapterResource;
use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ChapterController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', only: ['store', 'update', 'destroy']),
            new Middleware('role:admin|instructor', only: ['store', 'update', 'destroy']),
        ];
    }

    /**
     * Display a listing of the chapters.
     */
    public function index(Request $request, Course $course = null)
    {
        $query = Chapter::query()->with('course');
        
        // Filter by course_id if provided in the URL
        if ($course) {
            $query->where('course_id', $course->id);
        }
        // Filter by course_id if provided as a query parameter
        elseif ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        
        $chapters = $query->get();
        
        return new ChapterCollection($chapters);
    }

    /**
     * Store a newly created chapter in storage.
     */
    public function store(ChapterRequest $request)
    {
        $chapter = Chapter::create($request->validated());

        return (new ChapterResource($chapter))
            ->additional([
                'status' => 'success',
                'message' => 'Chapter created successfully'
            ])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified chapter.
     */
    public function show(string $id)
    {
        $chapter = Chapter::with(['course', 'topics'])
            ->findOrFail($id);
        
        return new ChapterResource($chapter);
    }

    /**
     * Update the specified chapter in storage.
     */
    public function update(ChapterRequest $request, string $id)
    {
        $chapter = Chapter::findOrFail($id);
        
        $chapter->update($request->validated());

        return (new ChapterResource($chapter))
            ->additional([
                'status' => 'success',
                'message' => 'Chapter updated successfully'
            ]);
    }

    /**
     * Remove the specified chapter from storage.
     */
    public function destroy(string $id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Chapter deleted successfully'
        ]);
    }
} 