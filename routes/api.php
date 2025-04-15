<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChapterController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\CourseStructureController;
use App\Http\Controllers\Api\TopicContentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Placeholder API
Route::get('/', function () {
    return response('success');
});

// Example API
Route::get('/example', function () {
    return response()->json([
        'message' => 'success'
    ]);
});

// Course API Routes
Route::apiResource('courses', CourseController::class);

// Chapter API Routes
Route::apiResource('chapters', ChapterController::class);

// Nested route for course chapters
Route::get('courses/{course}/chapters', [ChapterController::class, 'index']);

// Topic API Routes
Route::apiResource('topics', TopicController::class);

// Nested route for chapter topics
Route::get('chapters/{chapter}/topics', [TopicController::class, 'index']);

// Route for updating topic sort order
Route::put('topics/sort-order', [TopicController::class, 'updateSortOrder']);

// New routes
Route::get('/courses/{course}/structure', [CourseStructureController::class, 'show']);
Route::get('/topics/{topic}/content', [TopicContentController::class, 'show']);
