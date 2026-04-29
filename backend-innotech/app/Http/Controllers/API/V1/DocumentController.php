<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use App\Models\Application;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use OpenApi\Annotations as OA;

class DocumentController extends Controller
{
    use ApiResponseTrait;

    /**
     * @OA\Get(
     *     path="/api/document-types",
     *     summary="Lister les types de documents requis selon le niveau",
     *     tags={"DocumentTypes"},
     *     @OA\Parameter(
     *         name="level",
     *         in="query",
     *         required=false,
     *         description="Filtrer par niveau (Licence ou Mastere)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Liste des documents requis")
     * )
     */
    public function index(Request $request)
    {
        try {
            $query = DocumentType::query();

            if ($request->has('level')) {
                $query->where('level', $request->level);
            }

            $types = $query->get();

            return $this->successResponse(__('messages.retrieved_successfully'), $types);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.server_error'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/document-types",
     *     summary="Créer un type de document",
     *     tags={"DocumentTypes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "level"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="level", type="string", enum={"Licence", "Mastere"}),
     *             @OA\Property(property="is_required", type="boolean")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Créé")
     * )
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'level' => 'required|in:Licence,Mastere',
                'is_required' => 'required|boolean',
            ]);

            $type = DocumentType::create($validated);
            return $this->successResponse(__('messages.created_successfully'), $type, 201);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.creation_failed'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/document-types/{id}",
     *     summary="Afficher un type de document",
     *     tags={"DocumentTypes"},
     *     @OA\Parameter(
     *         name="id", in="path", required=true, @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Trouvé")
     * )
     */
    public function show($id)
    {
        try {
            $type = DocumentType::findOrFail($id);
            return $this->successResponse(__('messages.retrieved_successfully'), $type);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.not_found'), null, 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/document-types/{id}",
     *     summary="Mettre à jour un type de document",
     *     tags={"DocumentTypes"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="level", type="string", enum={"Licence", "Mastere"}),
     *             @OA\Property(property="is_required", type="boolean")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Mis à jour")
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $type = DocumentType::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|required|string',
                'level' => 'sometimes|required|in:Licence,Mastere',
                'is_required' => 'sometimes|required|boolean',
            ]);

            $type->update($validated);
            return $this->successResponse(__('messages.updated_successfully'), $type);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.update_failed'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/document-types/{id}",
     *     summary="Supprimer un type de document",
     *     tags={"DocumentTypes"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Supprimé")
     * )
     */
    public function destroy($id)
    {
        try {
            $type = DocumentType::findOrFail($id);
            $type->delete();

            return $this->successResponse(__('messages.deleted_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.deletion_failed'), ['exception' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/applications/{application}/documents",
     *     summary="Lister les documents envoyés pour une application",
     *     tags={"Documents"},
     *     @OA\Parameter(name="application", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function listDocuments(Application $application)
    {
        try {
            $documents = $application->documents()->with('type:id,name')->get()->map(function ($doc) {
                return [
                    'id' => $doc->id,
                    'type' => $doc->type->name ?? 'N/A',
                    'file_path' => asset('storage/' . $doc->file_path),
                    'status' => $doc->status,
                    'uploaded_at' => $doc->created_at->toDateTimeString(),
                ];
            });

            return $this->successResponse(__('messages.retrieved_successfully'), $documents);
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.server_error'), ['exception' => $e->getMessage()], 500);
        }
    }
}
