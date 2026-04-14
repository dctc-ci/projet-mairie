<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Personnels\{
    AgentNonPermanentController,
    AgentPermanentController,
    StagiaireController,
    SituationFamilialeController,
    SollicitationController,
    BaremeSalarialController,
    BulletinSalaireController,
    AdministrationController,
    DashboardController
};

use App\Models\Personnel\Stagiaire;
use App\Models\Personnel\BulletinSalaire;

/*
|--------------------------------------------------------------------------
| Route principale
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check()
        ? view('welcome')
        : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Routes protégées
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard général
    Route::get('/bienvenu', fn() => view('dashboard'))->name('bienvenu');

    /*
    |--------------------------------------------------------------------------
    | PERSONNELS 
    |--------------------------------------------------------------------------
    */
    Route::prefix('personnels')->name('personnels.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/agents-permanents', [AgentPermanentController::class, 'index'])
            ->name('agents-permanents');

        Route::get('/agents-non-permanents', [AgentNonPermanentController::class, 'index'])
            ->name('agents-non-permanents');

        Route::get('/stagiaires', [StagiaireController::class, 'index'])
            ->name('stagiaires');

        Route::get('/situations-familiales', [SituationFamilialeController::class, 'index'])
            ->name('situations-familiales');

        Route::get('/sollicitations', [SollicitationController::class, 'index'])
            ->name('sollicitations');

        Route::get('/bareme-salarials', [BaremeSalarialController::class, 'index'])
            ->name('bareme-salarials');

        Route::get('/bulletin-salaires', [BulletinSalaireController::class, 'index'])
            ->name('bulletin-salaires');

        Route::get('/administrations', [AdministrationController::class, 'index'])
            ->name('administrations');

    });

    /*
    |--------------------------------------------------------------------------
    | IMPRESSIONS PDF
    |--------------------------------------------------------------------------
    */

    Route::get('/bulletins/{bulletin}/print', function (BulletinSalaire $bulletin) {
        $bulletin->load(['agent.baremeSalarial', 'agent.commune']);
        return view('pdf.bulletin-salaire-print', compact('bulletin'));
    })->name('bulletins.print');

    Route::get('/stagiaires/{stagiaire}/fiche', function (Stagiaire $stagiaire) {
        return view('pdf.stagiaire-fiche', compact('stagiaire'));
    })->name('stagiaires.print.fiche');

    Route::get('/stagiaires/{stagiaire}/demarrage', function (Stagiaire $stagiaire) {
        return view('pdf.stagiaire-demarrage', compact('stagiaire'));
    })->name('stagiaires.print.demarrage');

    Route::get('/stagiaires/{stagiaire}/fin', function (Stagiaire $stagiaire) {
        return view('pdf.stagiaire-fin', compact('stagiaire'));
    })->name('stagiaires.print.fin');

});