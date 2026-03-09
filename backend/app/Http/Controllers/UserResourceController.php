<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/users
     */
    public function index(Request $request)
    {
        try {
            $collection = User::query();

            // Поиск
            if ($request->has('search')) {
                $search = $request->input('search');
                $collection->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }

            // Фильтрация по роли
            if ($request->has('position')) {
                $collection->where('position', $request->input('position'));
            }

            // Сортировка
            $sortField = $request->input('sort', 'created_at');
            $sortDirection = $request->input('direction', 'asc');
            $allowedSortFields = ['id', 'name', 'email', 'role', 'created_at', 'updated_at'];

            if (in_array($sortField, $allowedSortFields)) {
                $collection->orderBy($sortField, $sortDirection);
            }

            // Пагинация
            $perPage = $request->input('per_page', 15);
            $maxPerPage = 100; // Лимит для защиты
            $perPage = min($perPage, $maxPerPage);

            $users = $collection->paginate($perPage);

            // Возвращаем коллекцию с пагинацией
            return response()->json([
                'success' => true,
                'data' => $collection->get(),
                'meta' => [
                    'total' => $users->total(),
                    'per_page' => $users->perPage(),
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                ],
                'links' => [
                    'first' => $users->url(1),
                    'last' => $users->url($users->lastPage()),
                    'prev' => $users->previousPageUrl(),
                    'next' => $users->nextPageUrl(),
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при получении пользователей',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/users
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role' => $request->input('role', 'user'),
            ]);

            // Генерация API токена (если используется Sanctum/Passport)
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Пользователь успешно создан',
                'data' => new UserResource($user),
                'token' => $token, // Опционально, если нужен сразу токен
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при создании пользователя',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     * GET /api/users/{id}
     */
    public function show(User $user): JsonResponse
    {
        try {
            // Загрузка связанных данных
            $user->load(['posts', 'comments', 'profile']); // Пример

            return response()->json([
                'success' => true,
                'data' => new UserResource($user),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь не найден',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/users/{id}
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        try {
            // Проверка прав (можно добавить в Request или Policy)
            if (auth()->id() !== $user->id && auth()->user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Недостаточно прав для обновления',
                ], 403);
            }

            $data = $request->validated();

            // Хешируем пароль если он был передан
            if ($request->has('password')) {
                $data['password'] = Hash::make($request->input('password'));
            }

            $user->update($data);

            // Обновляем связанные данные если нужно
            // if ($request->has('permissions')) {
            //     $user->permissions()->sync($request->input('permissions'));
            // }

            return response()->json([
                'success' => true,
                'message' => 'Пользователь обновлен',
                'data' => new UserResource($user->fresh()),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обновлении пользователя',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/users/{id}
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            // Проверка на удаление себя
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Нельзя удалить свой аккаунт',
                ], 403);
            }

            // Проверка на удаление последнего админа
            if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Нельзя удалить последнего администратора',
                ], 403);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Пользователь удален',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении пользователя',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Дополнительные методы API
     */

    /**
     * Get current authenticated user
     * GET /api/users/me
     */
    public function me(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Пользователь не аутентифицирован',
                ], 401);
            }

            return response()->json([
                'success' => true,
                'data' => new UserResource($user),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при получении данных',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Restore soft-deleted user (если используется мягкое удаление)
     * POST /api/users/{id}/restore
     */
    public function restore($id): JsonResponse
    {
        try {
            $user = User::withTrashed()->findOrFail($id);

            if (!$user->trashed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Пользователь не был удален',
                ], 400);
            }

            $user->restore();

            return response()->json([
                'success' => true,
                'message' => 'Пользователь восстановлен',
                'data' => new UserResource($user),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при восстановлении',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Force delete user
     * DELETE /api/users/{id}/force
     */
    public function forceDestroy($id): JsonResponse
    {
        try {
            $user = User::withTrashed()->findOrFail($id);

            $user->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Пользователь полностью удален',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
