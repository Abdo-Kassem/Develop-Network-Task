<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Services\PostService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ApiResponse;


    private $PostService;

    public function __construct(PostService $postService)
    {
        $this->PostService = $postService;
    }


    public function index()
    {
        $posts = $this->PostService->index();
        return $this->successResponse($posts, '', 200);
    }

   public function store(PostRequest $postRequest)
   {
       try {

            $post = $this->PostService->store($postRequest->validated());
            return $this->successResponse($post, 'Post created successfully', 201);

       } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
       }
   }

   public function show($id)
   {
        try {

            $post = $this->PostService->show($id);
            return $this->successResponse($post, '', 200);

        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 404);
        }
   }

   public function update(PostRequest $postRequest, $id)
   {
        try {

            $post = $this->PostService->update($postRequest->validated(), $id);
            return $this->successResponse($post, 'Post updated successfully', 200);

        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
   }

   // Soft delete a post (only if it belongs to the current authenticated user)
   public function destroy($id)
   {
        try {

            $this->PostService->destroy($id);
            return $this->successResponse(true, 'Post deleted successfully', 200);

        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 404);
        }
   }

   public function softDeletedPosts()
   {
        try {

            $posts = $this->PostService->SoftDeletedPosts();
            return $this->successResponse($posts, '', 200);

        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
   }

   public function restoreSoftDeletedPost($id)
   {
        try {

            $this->PostService->restoreSoftDeletedPost($id);
            return $this->successResponse(true, 'Post restored successfully', 200);

        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 404);
        }
   }
}
