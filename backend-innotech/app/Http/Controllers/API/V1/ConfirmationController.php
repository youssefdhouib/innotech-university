<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use OpenApi\Annotations as OA;

class ConfirmationController extends Controller
{
    use ApiResponseTrait;

    /**
     * @OA\Get(
     *     path="/api/formulaires/confirm-preinscription/{application}",
     *     summary="Afficher le formulaire de confirmation tout en listant les champs deja remplis dans fromualire de préinscription et les champs pour joindre les documents selon level (Licence/Mastere) mentionné dans l'appplication",
     *     tags={"Confirmation"},
     *     @OA\Parameter(
     *         name="application",
     *         in="path",
     *         required=true,
     *         description="ID de l'application",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Formulaire chargé avec succès"),
     *     @OA\Response(response=403, description="Déjà soumis ou non préconfirmé")
     * )
     */
    public function show(Application $application)
    {
        try {
            if ($application->status !== 'preconfirmed') {
                return $this->errorResponse(__('messages.form_not_found'), null, 403);
            }

            if (Document::where('application_id', $application->id)->exists()) {
                return $this->errorResponse(__('messages.form_already_submitted'), null, 403);
            }

            $degree = $application->degree;
            $requiredDocs = DocumentType::where('level', $degree->level)
                ->where('is_required', true)
                ->get(['id', 'name']);

            return $this->successResponse('Formulaire de confirmation chargé.', [
                'application' => $application->only([
                    'first_name', 'last_name', 'first_name_ar', 'last_name_ar', 'email',
                    'cin', 'passport', 'birth_date', 'country', 'gender', 'address',
                    'phone', 'previous_degree', 'graduation_year', 'how_did_you_hear', 'desired_degree_id'
                ]),
                'required_documents' => $requiredDocs
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur serveur.', config('app.debug') ? ['exception' => $e->getMessage()] : null, 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/formulaires/confirm-preinscription/{application}",
     *     summary="Soumettre les documents de confirmation",
     *     tags={"Confirmation"},
     *     @OA\Parameter(
     *         name="application",
     *         in="path",
     *         required=true,
     *         description="ID de l'application",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Fichiers requis selon le niveau",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="documents[1]", type="string", format="binary"),
     *                 @OA\Property(property="documents[2]", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Documents soumis avec succès"),
     *     @OA\Response(response=403, description="Formulaire déjà soumis ou non autorisé"),
     *     @OA\Response(response=422, description="Erreur de validation")
     * )
     */
    public function submit(Request $request, Application $application)
    {
        try {
            if ($application->status !== 'preconfirmed') {
                return $this->errorResponse(__('messages.form_not_found'), null, 403);
            }

            if (Document::where('application_id', $application->id)->exists()) {
                return $this->errorResponse(__('messages.form_already_submitted'), null, 403);
            }

            $degree = $application->degree;
            $requiredDocs = DocumentType::where('level', $degree->level)
                ->where('is_required', true)
                ->pluck('id');

            $rules = [];
            foreach ($requiredDocs as $docId) {
                $rules["documents.$docId"] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
            }

            $request->validate($rules);

            foreach ($requiredDocs as $docId) {
                $file = $request->file("documents.$docId");
                $path = $file->store('documents', 'public');

                Document::create([
                    'application_id' => $application->id,
                    'type_id' => $docId,
                    'file_path' => $path,
                    'status' => 'uploaded',
                ]);
            }

            return $this->successResponse(__('messages.confirmation_submission_success'));
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur serveur.', config('app.debug') ? ['exception' => $e->getMessage()] : null, 500);
        }
    }

}
