<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * GET /api/posts
     */
    public function index(Request $request): JsonResponse
    {
        // Валидация query параметров
        $validated = $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100',
            'search' => 'string|max:255',
            'author' => 'string|max:255',
            'status' => 'in:draft,published,archived',
            'sort' => 'in:title,date,created_at,updated_at,view_count',
            'order' => 'in:asc,desc',
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
        ]);

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
    public function store(StorePostRequest $request): JsonResponse
    {
        try {
            // Авторизация (если используете политики)
            // Gate::authorize('create', Post::class);

            // Создание поста с автоматическим заполнением полей
            $post = Post::create([
                'title' => $request->validated('title'),
                'author' => $request->validated('author'),
                'content' => $request->validated('content'),
                'date' => $request->validated('date', now()),
                // Поля created_at и updated_at заполнятся автоматически
            ]);

            // Дополнительные действия при создании
            // event(new PostCreated($post));

            return response()->json([
                'message' => 'Post created successfully',
                'data' => new PostResource($post),
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
            // Авторизация (если нужно)
            // Gate::authorize('view', $post);

            // Увеличиваем счетчик просмотров
            $post->increment('view_count');

            // Загружаем связанные данные, если нужно
            // $post->load(['comments', 'author', 'tags']);

            return response()->json([
                'data' => new PostResource($post),
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
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        try {
            // Авторизация
            // Gate::authorize('update', $post);

            // Проверка, можно ли обновлять опубликованный пост
            // if ($post->isPublished() && !$request->user()->isAdmin()) {
            //     return response()->json([
            //         'message' => 'Cannot update published post',
            //     ], Response::HTTP_FORBIDDEN);
            // }

            // Обновление полей
            $updateData = [];

            if ($request->has('title')) {
                $updateData['title'] = $request->validated('title');
            }

            if ($request->has('author')) {
                $updateData['author'] = $request->validated('author');
            }

            if ($request->has('content')) {
                $updateData['content'] = $request->validated('content');
            }

            if ($request->has('date')) {
                $updateData['date'] = $request->validated('date');
            }

            if ($request->has('status')) {
                $updateData['status'] = $request->validated('status');
            }

            // Обновление поста
            $post->update($updateData);

            // Дополнительные действия после обновления
            // event(new PostUpdated($post));

            // Загружаем свежие данные
            $post->refresh();

            return response()->json([
                'message' => 'Post updated successfully',
                'data' => new PostResource($post),
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
            // Авторизация
            // Gate::authorize('delete', $post);

            // Проверка на удаление опубликованного поста
            // if ($post->isPublished() && !$request->user()->isAdmin()) {
            //     return response()->json([
            //         'message' => 'Cannot delete published post',
            //     ], Response::HTTP_FORBIDDEN);
            // }

            // Сохраняем ID для логов
            $postId = $post->id;
            $postTitle = $post->title;

            // Удаление поста
            $post->delete();

            // Дополнительные действия после удаления
            // event(new PostDeleted($postId));

            \Log::info('Post deleted', [
                'post_id' => $postId,
                'post_title' => $postTitle,
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
