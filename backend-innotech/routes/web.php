<?php

use App\Models\Application;
use Illuminate\Support\Facades\Route;
Route::get('/signed/formulaires/confirm-preinscription/{application}', function (Application $application) {
    if (! request()->hasValidSignature()) {
        abort(401, 'Lien invalide ou expiré.');
    }

    // Redirect to your Angular frontend with the same query params
    return redirect(config('app.frontend_url') . "/formulaires/confirm-preinscription/{$application->id}?" . request()->getQueryString());
})->name('final.confirm')->middleware('signed');
Route::get('/', function () {
    return view('welcome');
});
