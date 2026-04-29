<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Services\NewsService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="News",
 *     description="Endpoints for managing news and translations"
 * )
 */
class NewsController extends Controller
{
    use ApiResponseTrait;

    protected NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * @OA\Get(
     *     path="/api/news",
     *     summary="List all news (translated)",
     *     tags={"News"},
     *     @OA\Parameter(name="include_translations", in="query", required=false, @OA\Schema(type="boolean")),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function index(Request $request)
    {
        try {
            $data = $this->newsService->getAll($request);
            return $this->successResponse(__('messages.success'), $data);
        } catch (\Throwable $th) {
            return $this->errorResponse(__('messages.error'), ['exception' => $th->getMessage()]);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/news/{id}",
     *     summary="Get single news item by ID",
     *     tags={"News"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function show($id, Request $request)
    {
        try {
            $data = $this->newsService->getOne($id, $request);
            return $this->successResponse(__('messages.success'), $data);
        } catch (\Throwable $th) {
            return $this->errorResponse(__('messages.error'), ['exception' => $th->getMessage()]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/news",
     *     summary="Create a news entry with translations",
     *     tags={"News"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(type="object")),
     *     @OA\Response(response=201, description="Created successfully")
     * )
     */
    public function store(NewsRequest $request)
    {
        try {
            $data = $this->newsService->store($request);
            return $this->successResponse(__('messages.created'), $data, 201);
        } catch (\Throwable $th) {
            return $this->errorResponse(__('messages.error'), ['exception' => $th->getMessage()]);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/news/{id}",
     *     summary="Update news entry and translations",
     *     tags={"News"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(type="object")),
     *     @OA\Response(response=200, description="Updated successfully")
     * )
     */
    public function update(NewsRequest $request, $id)
    {
        try {
            $data = $this->newsService->update($id, $request);
            return $this->successResponse(__('messages.updated'), $data);
        } catch (\Throwable $th) {
            return $this->errorResponse(__('messages.error'), ['exception' => $th->getMessage()]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/news/{id}",
     *     summary="Delete a news item",
     *     tags={"News"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted successfully")
     * )
     */
    public function destroy($id)
    {
        try {
            $this->newsService->delete($id);
            return $this->successResponse(__('messages.deleted'));
        } catch (\Throwable $th) {
            return $this->errorResponse(__('messages.error'), ['exception' => $th->getMessage()]);
        }
    }
}
