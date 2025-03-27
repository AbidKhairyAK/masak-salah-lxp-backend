<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Http\Resources\TopicCollection;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TopicController extends Controller implements HasMiddleware
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
     * Display a listing of the topics.
     */
    public function index(Request $request, Chapter $chapter = null)
    {
        $query = Topic::query()->with('chapter');
        
        // Filter by chapter_id if provided in the URL
        if ($chapter) {
            $query->where('chapter_id', $chapter->id);
        }
        // Filter by chapter_id if provided as a query parameter
        elseif ($request->has('chapter_id')) {
            $query->where('chapter_id', $request->chapter_id);
        }
        
        // Order by sort_order by default
        $topics = $query->orderBy('sort_order')->get();
        
        return new TopicCollection($topics);
    }

    /**
     * Store a newly created topic in storage.
     */
    public function store(TopicRequest $request)
    {
        // Get next sort order if not provided
        $data = $request->validated();
        if (!isset($data['sort_order'])) {
            $maxOrder = Topic::where('chapter_id', $data['chapter_id'])->max('sort_order');
            $data['sort_order'] = $maxOrder ? $maxOrder + 1 : 1;
        }

        $topic = Topic::create($data);

        return (new TopicResource($topic))
            ->additional([
                'status' => 'success',
                'message' => 'Topic created successfully'
            ])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified topic.
     */
    public function show(string $id)
    {
        $topic = Topic::with(['chapter', 'lesson', 'practice'])
            ->findOrFail($id);
        
        return new TopicResource($topic);
    }

    /**
     * Update the specified topic in storage.
     */
    public function update(TopicRequest $request, string $id)
    {
        $topic = Topic::findOrFail($id);
        
        $topic->update($request->validated());

        return (new TopicResource($topic))
            ->additional([
                'status' => 'success',
                'message' => 'Topic updated successfully'
            ]);
    }

    /**
     * Remove the specified topic from storage.
     */
    public function destroy(string $id)
    {
        $topic = Topic::findOrFail($id);
        
        // Delete any associated child models
        $topic->delete_children();
        
        // Delete the topic itself
        $topic->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Topic deleted successfully'
        ]);
    }
    
    /**
     * Update the sort order of topics.
     */
    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'topics' => 'required|array',
            'topics.*.id' => 'required|exists:topics,id',
            'topics.*.sort_order' => 'required|integer|min:1'
        ]);
        
        foreach ($request->topics as $topicData) {
            $topic = Topic::findOrFail($topicData['id']);
            $topic->update(['sort_order' => $topicData['sort_order']]);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Topic sort order updated successfully'
        ]);
    }
} 