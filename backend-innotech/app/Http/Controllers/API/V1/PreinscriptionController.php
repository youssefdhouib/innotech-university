<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreinscriptionRequest;
use App\Models\Application;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationAcceptedMail;
use OpenApi\Annotations as OA;

class PreinscriptionController extends Controller
{    use ApiResponseTrait;
    /**
     * Store a new preinscription with status = pending
     * and immediately trigger simulated validation (for testing only)
     */
    /**
     * @OA\Post(
     *     path="/api/formulaires/preinscription",
     *     summary="Submit a preinscription",
     *     tags={"Preinscription"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"first_name", "last_name", "first_name_ar", "last_name_ar", "email", "cin"},
     *             @OA\Property(property="first_name", type="string", example="Youssef"),
     *             @OA\Property(property="last_name", type="string", example="Dhouib"),
     *             @OA\Property(property="first_name_ar", type="string", example="يوسف"),
     *             @OA\Property(property="last_name_ar", type="string", example="الذويب"),
     *             @OA\Property(property="email", type="string", format="email", example="youssef@example.com"),
     *             @OA\Property(property="cin", type="string", example="12345678"),
     *             @OA\Property(property="passport", type="string", example="AB123456"),
     *             @OA\Property(property="birth_date", type="string", format="date", example="2003-05-01"),
     *             @OA\Property(property="country", type="string", example="Tunisia"),
     *             @OA\Property(property="gender", type="string", enum={"male", "female", "other"}, example="male"),
     *             @OA\Property(property="address", type="string", example="Sfax"),
     *             @OA\Property(property="phone", type="string", example="+21698765432"),
     *             @OA\Property(property="previous_degree", type="string", example="Baccalauréat Scientifique"),
     *             @OA\Property(property="graduation_year", type="integer", example=2022),
     *             @OA\Property(property="how_did_you_hear", type="string", example="Facebook"),
     *             @OA\Property(property="desired_degree_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Preinscription enregistrée avec succès"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function store(PreinscriptionRequest $request)
    {
        try {
            // 1. Save application with status 'pending'
            $data = $request->validated();
            $data['status'] = 'pending';
            $application = Application::create($data);

            // 2. Simulate validation: change status and send email (JUST FOR TEST LATER IT WILL BE TRiGGERED BY THE ADMIN IN DASHBOARD)
            $this->validatePreinscription($application->id);

            // 3. Return success response
            return $this->successResponse(__('messages.preinscription_success'), null, 201);

        } catch (\Exception $e) {
            return $this->errorResponse(
                __('messages.preinscription_failed'),
                config('app.debug') ? ['exception' => $e->getMessage()] : null,
                500
            );
        }
    }

    /**
     * Validate a pending application and send signed confirmation link
     */
    /**
     * @OA\Post(
     *     path="/api/applications/{id}/validate",
     *     summary="Validate an application and send confirmation email",
     *     tags={"Preinscription"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'application à valider",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Préinscription validée et email envoyé"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Application non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function validatePreinscription($id)
    {
        try {
            $application = Application::findOrFail($id);

            // Update status
            $application->status = 'preconfirmed';
            $application->save();

            // Build a direct link to the Angular confirmation form
            $link = config('app.frontend_url') . "/formulaires/confirm-preinscription/{$application->id}";
            
            // Send confirmation email
            Mail::to($application->email)->send(new ApplicationAcceptedMail($application, $link));

            // Return success
            return $this->successResponse(__('messages.preinscription_validated'), [
                'link' => $link
            ]);

        } catch (\Exception $e) {
            return $this->errorResponse(
                __('messages.preinscription_validation_failed'),
                config('app.debug') ? ['exception' => $e->getMessage()] : null,
                500
            );
        }
    }
    //on peut ajouter rejectpreinscription function status rejected and reason and maybe cin and mail empty car unique or delete

    // public function rejectPreinscription($id) { ... }
}
