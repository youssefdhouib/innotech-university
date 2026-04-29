<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DegreeRequest;
use App\Models\Degree;
use App\Services\DegreeService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Degrees",
 *     description="API Endpoints for managing degrees"
 * )
 */
class DegreeController extends Controller
{
    use ApiResponseTrait;

    protected $service;

    public function __construct(DegreeService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/degrees",
     *     tags={"Degrees"},
     *     summary="List all degrees",
     *     @OA\Response(response=200, description="Degrees retrieved successfully")
     * )
     */
    public function index()
    {
        try {
            $degrees = $this->service->list();
            return $this->successResponse(__('messages.retrieved_successfully'), $degrees);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.server_error'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/degrees",
     *     tags={"Degrees"},
     *     summary="Create a new degree",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"level", "translations"},
     *             @OA\Property(property="level", type="string"),
     *             @OA\Property(
     *                 property="translations",
     *                 type="object",
     *                 @OA\Property(property="fr", type="object", @OA\Property(property="name", type="string")),
     *                 @OA\Property(property="en", type="object", @OA\Property(property="name", type="string")),
     *                 @OA\Property(property="ar", type="object", @OA\Property(property="name", type="string"))
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Degree created successfully")
     * )
     */
    public function store(DegreeRequest $request)
    {
        try {
            $degree = $this->service->create($request->all());
            return $this->successResponse(__('messages.created_successfully'), $this->service->get($degree->fresh()), 201);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.creation_failed'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/degrees/{id}",
     *     tags={"Degrees"},
     *     summary="Get a degree by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Degree retrieved successfully")
     * )
     */
    public function show(Degree $degree)
    {
        try {
            return $this->successResponse(__('messages.retrieved_successfully'), $this->service->get($degree));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.server_error'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/degrees/{id}",
     *     tags={"Degrees"},
     *     summary="Update a degree",
     *     description="Update a degree by its ID",
     *     operationId="updateDegree",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the degree to update",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "level"},
     *             @OA\Property(property="name", type="string", example="Génie Logiciel"),
     *             @OA\Property(property="level", type="string", example="Licence")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Degree updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Updated successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Degree not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */

    public function update(DegreeRequest $request, Degree $degree)
    {
        try {
            $this->service->update($degree, $request->all());
            return $this->successResponse(__('messages.updated_successfully'), $this->service->get($degree->fresh()));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.update_failed'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/degrees/{id}",
     *     tags={"Degrees"},
     *     summary="Delete a degree",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Degree deleted successfully")
     * )
     */
    public function destroy(Degree $degree)
    {
        try {
            $this->service->delete($degree);
            return $this->successResponse(null, __('messages.deleted_successfully'), 204);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.deletion_failed'), ['exception' => $e->getMessage()], 500);
        }
    }
}
