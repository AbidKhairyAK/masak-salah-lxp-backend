<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CourseController extends Controller implements HasMiddleware
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
     * Display a listing of the courses.
     */
    public function index()
    {
        $courses = Course::withDetails()->with('instructor')->get();
        
        return new CourseCollection($courses);
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(CourseRequest $request)
    {
        $course = Course::create($request->only([
            'instructor_id', 'title', 'caption', 'description'
        ]));

        // Handle image upload if provided
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $course->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        return new CourseResource($course);
    }

    /**
     * Display the specified course.
     */
    public function show(string $id)
    {
        $course = Course::withDetails()
            ->with(['instructor', 'chapters.topics'])
            ->findOrFail($id);
        
        return new CourseResource($course);
    }

    /**
     * Update the specified course in storage.
     */
    public function update(CourseRequest $request, string $id)
    {
        $course = Course::findOrFail($id);
        
        $course->update($request->only([
            'instructor_id', 'title', 'caption', 'description'
        ]));

        // Handle image upload if provided
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Clear previous images
            $course->clearMediaCollection('images');
            // Add new image
            $course->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        return (new CourseResource($course))
            ->additional([
                'status' => 'success',
                'message' => 'Course updated successfully'
            ]);
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Course deleted successfully'
        ]);
    }
}