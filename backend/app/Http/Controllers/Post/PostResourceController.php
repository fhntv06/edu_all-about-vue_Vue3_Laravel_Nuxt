<?php

namespace App\Http\Controllers\Post;

use App\Events\Post\PostCreated;
use App\Events\Post\PostDeleted;
use App\Events\Post\PostGetted;
use App\Events\Post\PostUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\UserStoreRequest;
use App\Http\Requests\Post\UserUpdateRequest;
use App\Jobs\ProcessPost;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Events\Dispatcher as Event;

class PostResourceController extends Controller
{
    private Event $event;

    function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Display a listing of the resource.
     *
     * GET /api/posts
     */
    public function index(Request $request): JsonResponse
    {
        // Базовый запрос
        $collection = Post::query();

        // Поиск по заголовку и содержанию
        if ($request->filled('search')) {
            $search = $request->input('search');
            $collection->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Фильтрация по автору
        if ($request->filled('author')) {
            $collection->where('author', 'like', "%{$request->input('author')}%");
        }

        // Фильтрация по статусу
        if ($request->filled('status')) {
            $collection->where('status', $request->input('status'));
        }

        // Фильтрация по дате
        if ($request->filled('start_date')) {
            $collection->whereDate('date', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $collection->whereDate('date', '<=', $request->input('end_date'));
        }

        // Сортировка
        $sortField = $request->input('sort', 'created_at');
        $sortOrder = $request->input('order', 'desc');
        $collection->orderBy($sortField, $sortOrder);

        // Пагинация
        $perPage = $request->input('per_page', 15);
        $posts = $collection->paginate($perPage);

        ProcessPost::dispatch($posts->all());
        event(new PostGetted($posts->all()));
//        $this->event->dispatch(new PostGetted($posts->all()));

        // Возвращаем коллекцию с мета-данными
        return response()->json([
            'data' => $collection->get(),
            'meta' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem(),
            ],
            'links' => [
                'first' => $posts->url(1),
                'last' => $posts->url($posts->lastPage()),
                'prev' => $posts->previousPageUrl(),
                'next' => $posts->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * POST /api/posts
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            // Создание поста с автоматическим заполнением полей
            $post = Post::create($data);

            event(new PostCreated($post));
//            $this->event->dispatch(new PostCreated($post));

            return response()->json([
                'message' => 'Post created successfully',
                'post' => $post,
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            \Log::error('Post creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'message' => 'Failed to create post',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * GET /api/posts/{post}
     */
    public function show(Post $post): JsonResponse
    {
        try {
            // Увеличиваем счетчик просмотров
            $post->increment('view_count');

            // Загружаем связанные данные, если нужно
            // $post->load(['comments', 'author', 'tags']);

            return response()->json([
                'post' => $post,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve post',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * PUT/PATCH /api/posts/{post}
     */
    public function update(UserUpdateRequest $request, Post $post): JsonResponse
    {
        $data = $request->validated();

        try {
            // Обновление поста
            $post->update($data);

            // Загружаем свежие данные
            $post->refresh();

            $this->event->dispatch(new PostUpdated($post));

            return response()->json([
                'message' => 'Post updated successfully',
                'post' => $post,
            ]);

        } catch (\Exception $e) {
            \Log::error('Post update failed: ' . $e->getMessage(), [
                'exception' => $e,
                'post_id' => $post->id,
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'message' => 'Failed to update post',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * DELETE /api/posts/{post}
     */
    public function destroy(Post $post): JsonResponse
    {
        try {
            // Удаление поста
            $post->delete();

            // Дополнительные действия после удаления
             $this->event->dispatch(new PostDeleted($post));

            \Log::info('Post deleted', [
                'post_id' => $post->id,
                'post_title' => $post->title,
                'deleted_by' => auth()->id(),
                'deleted_at' => now(),
            ]);

            return response()->json([
                'message' => 'Post deleted successfully',
            ], Response::HTTP_NO_CONTENT);

        } catch (\Exception $e) {
            \Log::error('Post deletion failed: ' . $e->getMessage(), [
                'exception' => $e,
                'post_id' => $post->id,
            ]);

            return response()->json([
                'message' => 'Failed to delete post',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
