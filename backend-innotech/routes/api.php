<?php

use App\Http\Controllers\API\V1\DepartmentController;
use App\Http\Controllers\API\V1\NewsController;
use App\Http\Controllers\API\V1\ProfessorController;
use App\Http\Controllers\ChatbotController;
use App\Models\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\PreinscriptionController;
use App\Http\Controllers\API\V1\ConfirmationController;
use App\Http\Controllers\API\V1\DegreeController;
use App\Http\Controllers\API\V1\ProgramController;
use App\Http\Controllers\API\V1\DocumentController;
use App\Http\Controllers\API\V1\ContactController;

Route::post('/formulaires/preinscription', [PreinscriptionController::class, 'store']);
Route::post('/applications/{id}/validate', [PreinscriptionController::class, 'validatePreinscription']);

Route::get('/formulaires/confirm-preinscription/{application}', [ConfirmationController::class, 'show']);
Route::post('/formulaires/confirm-preinscription/{application}', [ConfirmationController::class, 'submit']);

Route::apiResource('degrees', DegreeController::class);

Route::apiResource('programs', ProgramController::class);
Route::get('/programs/degree/{id}', [ProgramController::class, 'getProgramsByDegreeId']);

Route::get('/document-types', [DocumentController::class, 'index']);
Route::post('/document-types', [DocumentController::class, 'store']);
Route::get('/document-types/{id}', [DocumentController::class, 'show']);
Route::put('/document-types/{id}', [DocumentController::class, 'update']);
Route::delete('/document-types/{id}', [DocumentController::class, 'destroy']);
Route::get('/applications/{application}/documents', [DocumentController::class, 'listDocuments']);

Route::post('/formulaires/contact', [ContactController::class, 'submit']);

Route::apiResource('/departments', DepartmentController::class);
Route::get('/departments/{id}/professors', [ProfessorController::class, 'getByDepartment']);
Route::apiResource('/professors', ProfessorController::class);
Route::get('/professors/slug/{slug}', [ProfessorController::class, 'getBySlug']);
Route::apiResource('/news', NewsController::class);

Route::get('/test-lang', [\App\Http\Controllers\LangTestController::class, 'testLang']);

Route::post('/chatbot', [ChatbotController::class, 'ask']);
