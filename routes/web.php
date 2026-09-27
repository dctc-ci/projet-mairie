<?php

use App\Http\Controllers\EtatCivils\AdminEtatCivilController;
use App\Http\Controllers\EtatCivils\AutreDeclationController;
use App\Http\Controllers\EtatCivils\DashboardController as EtatCivilDashboard;
use App\Http\Controllers\EtatCivils\DecesController;
use App\Http\Controllers\EtatCivils\ExtraitController;
use App\Http\Controllers\EtatCivils\MariageController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\Personnels\AdministrationController;
use App\Http\Controllers\Personnels\AgentNonPermanentController;
use App\Http\Controllers\Personnels\AgentPermanentController;
use App\Http\Controllers\Personnels\BaremeSalarialController;
use App\Http\Controllers\Personnels\BulletinSalaireController;
use App\Http\Controllers\Personnels\DashboardController;
use App\Http\Controllers\Personnels\SituationFamilialeController;
use App\Http\Controllers\Personnels\SollicitationController;
use App\Http\Controllers\Personnels\StagiaireController;
use App\Models\EtatCivil\Extrait;
use App\Models\ModuleSetting;
use App\Models\Personnel\BulletinSalaire;
use App\Models\Personnel\Commune;
use App\Models\Personnel\Stagiaire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route principale
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check()
        ? app(ModuleController::class)->dashboard()
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
    Route::get('/bienvenu', [ModuleController::class, 'dashboard'])->name('bienvenu');
    Route::put('/modules', [ModuleController::class, 'update'])->name('modules.update');

    /*
    |--------------------------------------------------------------------------
    | PERSONNELS
    |--------------------------------------------------------------------------
    */
    Route::prefix('personnels')->name('personnels.')->middleware([
        'module.enabled:'.ModuleSetting::PERSONNELS,
        'personnels.access',
    ])->group(function () {

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
    | ETAT CIVILS
    |--------------------------------------------------------------------------
    */
    Route::prefix('etatcivils')->name('etatcivils.')->middleware('module.enabled:'.ModuleSetting::ETAT_CIVIL)->group(function () {

        Route::get('/dashboard', [EtatCivilDashboard::class, 'index'])->name('dashboard');
        Route::get('/naissances', [ExtraitController::class, 'index'])->name('naissances');
        Route::get('/mariages', [MariageController::class, 'index'])->name('mariages');
        Route::get('/deces', [DecesController::class, 'index'])->name('deces');
        Route::get('/autre-declarations', [AutreDeclationController::class, 'index'])->name('autredeclaration');
        Route::get('/administrations', [AdminEtatCivilController::class, 'index'])->name('administrations');

    });

    /*
    |--------------------------------------------------------------------------
    | IMPRESSIONS PDF
    |--------------------------------------------------------------------------
    */

    Route::get('/bulletins/{bulletin}/print', function (BulletinSalaire $bulletin) {
        $bulletin->load(['agent.baremeSalarial', 'agent.commune']);

        return view('pdf.bulletin-salaire-print', compact('bulletin'));
    })->middleware(['module.enabled:'.ModuleSetting::PERSONNELS, 'personnels.access'])->name('bulletins.print');

    Route::get('/stagiaires/{stagiaire}/fiche', function (Stagiaire $stagiaire) {
        return view('pdf.stagiaire-fiche', compact('stagiaire'));
    })->middleware(['module.enabled:'.ModuleSetting::PERSONNELS, 'personnels.access'])->name('stagiaires.print.fiche');

    Route::get('/stagiaires/{stagiaire}/demarrage', function (Stagiaire $stagiaire) {
        $communeNom = Commune::query()->orderBy('id')->value('nom_commune') ?? '________________';

        return view('pdf.stagiaire-demarrage', compact('stagiaire', 'communeNom'));
    })->middleware(['module.enabled:'.ModuleSetting::PERSONNELS, 'personnels.access'])->name('stagiaires.print.demarrage');

    Route::get('/stagiaires/{stagiaire}/fin', function (Stagiaire $stagiaire) {
        $communeNom = Commune::query()->orderBy('id')->value('nom_commune') ?? '________________';

        return view('pdf.stagiaire-fin', compact('stagiaire', 'communeNom'));
    })->middleware(['module.enabled:'.ModuleSetting::PERSONNELS, 'personnels.access'])->name('stagiaires.print.fin');

    // ── Impressions PDF — Sollicitations ────
    Route::get('/personnels/sollicitations/{sollicitation}/print',
        [SollicitationController::class, 'printDocument'])
        ->middleware(['module.enabled:'.ModuleSetting::PERSONNELS, 'personnels.access'])
        ->name('personnels.sollicitations.print');

    // CONGE ADMINISTRATIF génère 2 PDFs — route dédiée pour le 2e doc
    Route::get('/personnels/sollicitations/{sollicitation}/print-reprise',
        [SollicitationController::class, 'printReprise'])
        ->middleware(['module.enabled:'.ModuleSetting::PERSONNELS, 'personnels.access'])
        ->name('personnels.sollicitations.print.reprise');

    Route::prefix('naissances')->name('naissances.print.')->middleware(['auth', 'module.enabled:'.ModuleSetting::ETAT_CIVIL])->group(function () {

        Route::get('/{extrait}/extrait', function (Extrait $extrait) {
            $extrait->load(['commune', 'mentions']);

            return view('pdf.extrait-naissance', compact('extrait'));
        })->name('extrait');

        Route::get('/{extrait}/copie', function (Extrait $extrait) {
            $extrait->load(['commune', 'mentions']);

            return view('pdf.copie-integrale', compact('extrait'));
        })->name('copie');

        Route::get('/{extrait}/jugement', function (Extrait $extrait) {
            $extrait->load(['commune', 'mentions']);

            return view('pdf.copie-integrale-jugement', compact('extrait'));
        })->name('jugement');

        Route::get('/{extrait}/requisition', function (Extrait $extrait) {
            $extrait->load(['commune', 'mentions']);

            return view('pdf.copie-integrale-requisition', compact('extrait'));
        })->name('requisition');
    });

});
