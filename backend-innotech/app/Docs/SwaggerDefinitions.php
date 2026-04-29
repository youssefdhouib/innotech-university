<?php

namespace App\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\RequestBody(
 *     request="ProgramRequest",
 *     required=true,
 *     description="Request payload for creating/updating a program",
 *     @OA\JsonContent(
 *         required={"degree_id", "name", "description"},
 *         @OA\Property(property="degree_id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="Program Title"),
 *         @OA\Property(property="description", type="object",
 *             @OA\Property(property="fr", type="string", example="Texte FR"),
 *             @OA\Property(property="en", type="string", example="Text EN"),
 *             @OA\Property(property="ar", type="string", example="النص بالعربية")
 *         ),
 *         @OA\Property(property="attached_file", type="string", format="binary")
 *     )
 * )
 */
class SwaggerDefinitions {}
