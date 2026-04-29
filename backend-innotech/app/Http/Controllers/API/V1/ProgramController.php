<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Services\ProgramService;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\ProgramRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Programs",
 *     description="API Endpoints for managing programs"
 * )
 */
class ProgramController extends Controller
{
    use ApiResponseTrait;

    protected $service;

    public function __construct(ProgramService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/programs",
     *     tags={"Programs"},
     *     summary="List all programs",
     *     @OA\Response(response=200, description="Programs retrieved successfully")
     * )
     */
    public function index()
    {
        try {
            $programs = $this->service->list();
            return $this->successResponse(__('messages.retrieved_successfully'), $programs);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.server_error'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/programs",
     *     tags={"Programs"},
     *     summary="Create a new program",
     *     operationId="createProgram",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"degree_id", "name", "description"},
     *             @OA\Property(property="degree_id", type="integer", example=2),
     *             @OA\Property(property="name", type="string", example="Big Data et Analyse de Données"),
     *             @OA\Property(property="description", type="object",
     *                 @OA\Property(property="fr", type="string", example="Formation en Big Data et analyse avancée."),
     *                 @OA\Property(property="en", type="string", example="Training in Big Data and advanced analytics."),
     *                 @OA\Property(property="ar", type="string", example="تكوين في البيانات الضخمة والتحليل المتقدم")
     *             ),
     *             @OA\Property(property="attached_file", type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Program created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=201),
     *             @OA\Property(property="message", type="string", example="Created successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Validation error"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */

    public function store(ProgramRequest $request)
    {
        try {
            $program = $this->service->create($request->validated());
            return $this->successResponse(__('messages.created_successfully'), $this->service->get($program->fresh()), 201);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.creation_failed'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/programs/{id}",
     *     tags={"Programs"},
     *     summary="Get a program by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Program retrieved successfully")
     * )
     */
    public function show(Program $program)
    {
        try {
            return $this->successResponse(__('messages.retrieved_successfully'), $this->service->get($program));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.server_error'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/programs/{id}",
     *     operationId="updateProgram",
     *     tags={"Programs"},
     *     summary="Update a program",
     *     description="Update an existing program by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Program ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description", "degree_id"},
     *             @OA\Property(property="name", type="string", example="Génie Logiciel"),
     *             @OA\Property(property="description", type="string", example="Couvre le développement logiciel, IA, cloud..."),
     *             @OA\Property(property="degree_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Program updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Program not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

    public function update(ProgramRequest $request, Program $program)
    {
        try {
            $this->service->update($program, $request->validated());
            return $this->successResponse(__('messages.updated_successfully'), $this->service->get($program->fresh()));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.update_failed'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/programs/{id}",
     *     tags={"Programs"},
     *     summary="Delete a program",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Program deleted successfully")
     * )
     */
    public function destroy(Program $program)
    {
        try {
            $this->service->delete($program);
            return $this->successResponse(__('messages.deleted_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.deletion_failed'), ['exception' => $e->getMessage()], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/programs/by-degree/{id}",
     *     operationId="getProgramsByDegreeId",
     *     tags={"Programs"},
     *     summary="Get programs by degree ID",
     *     description="Returns list of programs for a specific degree",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the degree",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Retrieved successfully"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function getProgramsByDegreeId($id)
    {
        try {
            $programs = $this->service->getProgramsByDegreeId($id); // Appel service
            return $this->successResponse(__('messages.retrieved_successfully'), $programs);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.error_occurred'), 500, $e->getMessage());
        }
    }

}
