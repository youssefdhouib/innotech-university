<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use App\Traits\ApiResponseTrait;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Departments",
 *     description="API Endpoints for managing departments"
 * )
 */
class DepartmentController extends Controller
{
    use ApiResponseTrait;

    protected $service;

    public function __construct(DepartmentService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/departments",
     *     tags={"Departments"},
     *     summary="List all departments",
     *     @OA\Response(response=200, description="Departments retrieved successfully")
     * )
     */
    public function index()
    {
        try {
            $departments = $this->service->list();
            return $this->successResponse(__('messages.retrieved_successfully'), $departments);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.server_error'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/departments",
     *     tags={"Departments"},
     *     summary="Create a new department",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="cover_image", type="string", example="departments/engineering.jpg"),
     *             @OA\Property(property="translations", type="object",
     *                 @OA\Property(property="fr", type="object",
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="description", type="string")
     *                 ),
     *                 @OA\Property(property="en", type="object",
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="description", type="string")
     *                 ),
     *                 @OA\Property(property="ar", type="object",
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="description", type="string")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Department created successfully")
     * )
     */
    public function store(DepartmentRequest $request)
    {
        try {
            $department = $this->service->create($request->validated());
            return $this->successResponse(__('messages.created_successfully'), $department, 201);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.creation_failed'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/departments/{id}",
     *     tags={"Departments"},
     *     summary="Get a department by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Department retrieved successfully"),
     *     @OA\Response(response=404, description="Department not found")
     * )
     */
    public function show(Department $department)
    {
        try {
            $result = $this->service->get($department);
            return $this->successResponse(__('messages.retrieved_successfully'), $result);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.not_found'), ['exception' => $e->getMessage()], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/departments/{id}",
     *     tags={"Departments"},
     *     summary="Update a department",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="cover_image", type="string", example="departments/ai.jpg"),
     *             @OA\Property(property="translations", type="object",
     *                 @OA\Property(property="fr", type="object",
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="description", type="string")
     *                 ),
     *                 @OA\Property(property="en", type="object",
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="description", type="string")
     *                 ),
     *                 @OA\Property(property="ar", type="object",
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="description", type="string")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Department updated successfully")
     * )
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        try {
            $department = $this->service->update($department, $request->validated());
            return $this->successResponse(__('messages.updated_successfully'), $department);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.update_failed'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/departments/{id}",
     *     tags={"Departments"},
     *     summary="Delete a department",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Department deleted successfully")
     * )
     */
    public function destroy(Department $department)
    {
        try {
            $this->service->delete($department);
            return $this->successResponse(__('messages.deleted_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.deletion_failed'), ['exception' => $e->getMessage()], 500);
        }
    }
}
