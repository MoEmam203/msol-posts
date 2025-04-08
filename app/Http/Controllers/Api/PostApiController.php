<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Posts\PostApiRequest;
use App\Models\Post;
use App\Services\Api\PostApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class PostApiController extends Controller
{
    public function __construct(protected readonly PostApiService $postApiService)
    {
        //
    }

    public function index(): JsonResponse
    {
        return $this->postApiService->index(
            user: auth()->user(),
            perPage: request()->query('per_page')
        );
    }

    public function show(Post $post): JsonResponse
    {
        Gate::authorize('update', $post);

        return $this->postApiService->show(
            post: $post
        );
    }

    public function store(PostApiRequest $request): JsonResponse
    {
        return $this->postApiService->store(
            validatedData: $request->validated(),
            user: auth()->user()
        );
    }

    public function update(PostApiRequest $request, Post $post): JsonResponse
    {
        Gate::authorize('update', $post);

        return $this->postApiService->update(
            validatedData: $request->validated(),
            post: $post
        );
    }

    public function destroy(Post $post): JsonResponse
    {
        Gate::authorize('delete', $post);

        return $this->postApiService->destroy(
            post: $post
        );
    }
}
