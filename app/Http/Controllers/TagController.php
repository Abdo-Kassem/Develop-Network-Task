<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Services\TagsService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class TagController extends Controller
{
    use ApiResponse;

    private $tagService;

    public function __construct(TagsService $tagsService)
    {
        $this->tagService = $tagsService;
    }

    public function index()
    {
        $tags =  $tags = $this->tagService->index();
        return $this->successResponse($tags, 'This all tags', 200);
    }

    public function store(TagRequest $tagRequest)
    {
        try {

            $tag = $this->tagService->store($tagRequest->all());
            return $this->successResponse($tag, 'Tag created successfully', 201);
        
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            
            $tag = $this->tagService->show($id);
            return $this->successResponse($tag, '', 200);
        
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }

    public function update(TagRequest $tagRequest, $id)
    {
        try {

            $tag = $this->tagService->update($tagRequest->except(['_method']), $id);
            return $this->successResponse($tag, 'Tag updated successfully', 200);
        
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {

            $this->tagService->destroy($id);
            return $this->successResponse(true, 'Tag deleted successfully', 200);
        
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }
}
