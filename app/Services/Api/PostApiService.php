<?php

namespace App\Services\Api;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class PostApiService
{
    public function index(User $user, ?int $perPage): JsonResponse
    {
        $posts = $user->posts()->paginate($perPage ?? 10);

        return successResponse(
            data: [
                'posts' => PostResource::collection($posts),
                'pagination' => [
                    'total' => $posts->total(),
                    'per_page' => $posts->perPage(),
                    'current_page' => $posts->currentPage(),
                    'last_page' => $posts->lastPage(),
                    'from' => $posts->firstItem(),
                    'to' => $posts->lastItem(),
                ],
            ],
            message: 'Posts fetched successfully'
        );
    }

    public function show(Post $post): JsonResponse
    {
        return successResponse(
            data: [
                'post' => new PostResource($post),
            ],
            message: 'Post fetched successfully'
        );
    }

    public function store(array $validatedData, User $user): JsonResponse
    {
        $post = $user->posts()->create($validatedData);

        return successResponse(
            data: [
                'post' => new PostResource($post),
            ],
            message: 'Post created successfully'
        );
    }

    public function update(array $validatedData, Post $post): JsonResponse
    {
        $post->update($validatedData);

        return successResponse(
            data: [
                'post' => new PostResource($post),
            ],
            message: 'Post updated successfully'
        );
    }

    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        return successResponse(
            message: 'Post deleted successfully'
        );
    }
}
