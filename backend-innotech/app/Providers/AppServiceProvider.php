<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OpenApi\Annotations as OA;
/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="InnoTech Preinscription API",
 *     description="Documentation for the InnoTech University APIS ",
 *     @OA\Contact(
 *         email="admissions@InnoTech-university.tn",
 *         name="Université InnoTech"
 *     )
 * )
 */

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
