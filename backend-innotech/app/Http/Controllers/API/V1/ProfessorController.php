<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Professor;
use App\Services\ProfessorService;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\ProfessorRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Professors",
 *     description="API Endpoints for managing professors"
 * )
 */
class ProfessorController extends Controller
{
    use ApiResponseTrait;

    protected $service;

    public function __construct(ProfessorService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/professors",
     *     tags={"Professors"},
     *     summary="List all professors",
     *     @OA\Response(response=200, description="List retrieved successfully")
     * )
     */
    public function index()
    {
        try {
            $professors = $this->service->list();
            return $this->successResponse(__('messages.retrieved_successfully'), $professors);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.server_error'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/professors",
     *     tags={"Professors"},
     *     summary="Create a new professor",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "department_id", "translations"},
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="photo_url", type="string"),
     *             @OA\Property(property="cv_attached_file", type="string"),
     *             @OA\Property(property="department_id", type="integer"),
     *             @OA\Property(
     *                 property="translations",
     *                 type="object",
     *                 @OA\Property(
     *                     property="fr",
     *                     type="object",
     *                     required={"first_name", "last_name"},
     *                     @OA\Property(property="first_name", type="string"),
     *                     @OA\Property(property="last_name", type="string"),
     *                     @OA\Property(property="speciality", type="string"),
     *                     @OA\Property(property="grade", type="string")
     *                 ),
     *                 @OA\Property(
     *                     property="en",
     *                     type="object",
     *                     @OA\Property(property="first_name", type="string"),
     *                     @OA\Property(property="last_name", type="string"),
     *                     @OA\Property(property="speciality", type="string"),
     *                     @OA\Property(property="grade", type="string")
     *                 ),
     *                 @OA\Property(
     *                     property="ar",
     *                     type="object",
     *                     @OA\Property(property="first_name", type="string"),
     *                     @OA\Property(property="last_name", type="string"),
     *                     @OA\Property(property="speciality", type="string"),
     *                     @OA\Property(property="grade", type="string")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Professor created successfully")
     * )
     */
    public function store(ProfessorRequest $request)
    {
        try {
            $professor = $this->service->create($request->validated());
            return $this->successResponse(__('messages.created_successfully'), $this->service->get($professor->fresh()), 201);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.creation_failed'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/professors/{id}",
     *     tags={"Professors"},
     *     summary="Get a professor by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Professor retrieved successfully")
     * )
     */
    public function show(Professor $professor)
    {
        try {
            return $this->successResponse(__('messages.retrieved_successfully'), $this->service->get($professor));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.server_error'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/professors/{id}",
     *     tags={"Professors"},
     *     summary="Update a professor",
     *     description="Updates a professor by ID",
     *     operationId="updateProfessor",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Professor ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"first_name", "last_name", "email", "speciality", "grade"},
     *             @OA\Property(property="first_name", type="string", example="Rami"),
     *             @OA\Property(property="last_name", type="string", example="Ben Yedder"),
     *             @OA\Property(property="email", type="string", example="professor@InnoTech.tn"),
     *             @OA\Property(property="speciality", type="string", example="AI & Data Science"),
     *             @OA\Property(property="grade", type="string", example="Assistant"),
     *             @OA\Property(property="department_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Professor updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Updated successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Professor not found"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */

    public function update(ProfessorRequest $request, Professor $professor)
    {
        try {
            $this->service->update($professor, $request->validated());
            return $this->successResponse(__('messages.updated_successfully'), $this->service->get($professor->fresh()));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.update_failed'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/professors/{id}",
     *     tags={"Professors"},
     *     summary="Delete a professor",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Professor deleted successfully")
     * )
     */
    public function destroy(Professor $professor)
    {
        try {
            $this->service->delete($professor);
            return $this->successResponse(__('messages.deleted_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.deletion_failed'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/departments/{id}/professors",
     *     tags={"Professors"},
     *     summary="List all professors in a specific department",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Professors retrieved successfully")
     * )
     */
    public function getByDepartment($id)
    {
        try {
            $professors = $this->service->getByDepartment($id);
            return $this->successResponse(__('messages.retrieved_successfully'), $professors);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.server_error'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/professors/slug/{slug}",
     *     tags={"Professors"},
     *     summary="Get a professor by profile slug",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug of the professor",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Professor retrieved successfully"),
     *     @OA\Response(response=404, description="Professor not found")
     * )
     */
    public function getBySlug($slug)
    {
        try {
            return $this->successResponse(__('messages.retrieved_successfully'), $this->service->getBySlug($slug));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.not_found'), config('app.debug') ? ['exception' => $e->getMessage()] : null, 404);
        }
    }
}
