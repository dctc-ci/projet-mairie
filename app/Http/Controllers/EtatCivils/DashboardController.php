<?php

namespace App\Http\Controllers\EtatCivils;

use App\Http\Controllers\Controller;
use App\Models\EtatCivil\Extrait;
use App\Models\EtatCivil\Mariage;
use App\Models\EtatCivil\Deces;
use App\Models\EtatCivil\Autredeclaration;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $debutMois = Carbon::now()->startOfMonth();

        // ── Compteurs principaux ───────────────────────────────
        $nbNaissances = Extrait::count();
        $nbMariages   = Mariage::count();
        $nbDeces      = Deces::count();
        $nbAutres     = Autredeclaration::count();

        // ── Nouveaux ce mois ──────────────────────────────────
        $newNaissancesMois = Extrait::where('created_at', '>=', $debutMois)->count();
        $newMariagesMois   = Mariage::where('created_at', '>=', $debutMois)->count();
        $newDecesMois      = Deces::where('created_at', '>=', $debutMois)->count();

        // ── Barres de progression (% relatif au total) ────────
        $total = max(1, $nbNaissances + $nbMariages + $nbDeces + $nbAutres);
        $progressNaissances = round(($nbNaissances / $total) * 100);
        $progressMariages   = round(($nbMariages   / $total) * 100);
        $progressDeces      = round(($nbDeces      / $total) * 100);
        $progressAutres     = round(($nbAutres     / $total) * 100);

        // ── Activité récente ──────────────────────────────────
        $activites = collect();

        Extrait::latest()->limit(4)->get()->each(function ($e) use (&$activites) {
            $activites->push([
                'type'       => 'naissance',
                'couleur'    => 'green',
                'titre'      => 'Acte de naissance enregistré',
                'detail'     => strtoupper($e->nom_enfant ?? '') . ' ' . ($e->prenom_enfant ?? '')
                                . ' — N° ' . ($e->numero_complet_act_extrai ?? $e->numero_act_extrai ?? '—'),
                'created_at' => $e->created_at,
            ]);
        });

        Mariage::latest()->limit(3)->get()->each(function ($m) use (&$activites) {
            $activites->push([
                'type'       => 'mariage',
                'couleur'    => 'gold',
                'titre'      => 'Acte de mariage enregistré',
                'detail'     => strtoupper($m->nom_epoux ?? '') . ' & ' . strtoupper($m->nom_epouse ?? '')
                                . ' — N° ' . ($m->numero_complet_act_mariage ?? $m->numero_act_mariage ?? '—'),
                'created_at' => $m->created_at,
            ]);
        });

        Deces::latest()->limit(3)->get()->each(function ($d) use (&$activites) {
            $activites->push([
                'type'       => 'deces',
                'couleur'    => 'orange',
                'titre'      => 'Acte de décès enregistré',
                'detail'     => strtoupper($d->nom_defunt ?? '') . ' ' . ($d->prenom_defunt ?? '')
                                . ' — N° ' . ($d->numero_act_deces ?? '—'),
                'created_at' => $d->created_at,
            ]);
        });

        Autredeclaration::latest()->limit(2)->get()->each(function ($a) use (&$activites) {
            $activites->push([
                'type'       => 'autre',
                'couleur'    => 'navy',
                'titre'      => 'Autre déclaration enregistrée',
                'detail'     => ($a->act_autre ?? 'Déclaration') . ' — ' . ($a->nom_prenom_autre ?? '—'),
                'created_at' => $a->created_at,
            ]);
        });

        $activites = $activites->sortByDesc('created_at')->take(6)->values();

        // ── Derniers actes (table) ────────────────────────────
        $derniersActes = collect();

        Extrait::latest()->limit(3)->get()->each(function ($e) use (&$derniersActes) {
            $derniersActes->push([
                'type'     => 'naissance',
                'numero'   => $e->numero_complet_act_extrai ?? ($e->numero_act_extrai . '/' . $e->annee_registre_extrai),
                'concerne' => strtoupper($e->nom_enfant ?? '') . ' ' . ($e->prenom_enfant ?? ''),
                'date'     => $e->date_naissance ? Carbon::parse($e->date_naissance)->locale('fr')->isoFormat('DD MMM YYYY') : '—',
                'url'      => '/etatcivils/naissances',
                'sort'     => $e->created_at,
            ]);
        });

        Mariage::latest()->limit(3)->get()->each(function ($m) use (&$derniersActes) {
            $derniersActes->push([
                'type'     => 'mariage',
                'numero'   => $m->numero_complet_act_mariage ?? ($m->numero_act_mariage . '/' . $m->annee_registre_mariage),
                'concerne' => strtoupper($m->nom_epoux ?? '') . ' & ' . strtoupper($m->nom_epouse ?? ''),
                'date'     => $m->date_mariage ? Carbon::parse($m->date_mariage)->locale('fr')->isoFormat('DD MMM YYYY') : '—',
                'url'      => '/etatcivils/mariages',
                'sort'     => $m->created_at,
            ]);
        });

        Deces::latest()->limit(2)->get()->each(function ($d) use (&$derniersActes) {
            $derniersActes->push([
                'type'     => 'deces',
                'numero'   => ($d->numero_act_deces ?? '—') . '/' . $d->annee_registre_deces,
                'concerne' => strtoupper($d->nom_defunt ?? '') . ' ' . ($d->prenom_defunt ?? ''),
                'date'     => $d->date_deces ? Carbon::parse($d->date_deces)->locale('fr')->isoFormat('DD MMM YYYY') : '—',
                'url'      => '/etatcivils/deces',
                'sort'     => $d->created_at,
            ]);
        });

        Autredeclaration::latest()->limit(1)->get()->each(function ($a) use (&$derniersActes) {
            $derniersActes->push([
                'type'     => 'autre',
                'numero'   => ($a->numero_act_autre ?? '—') . '/' . $a->annee_registre_autre,
                'concerne' => $a->nom_prenom_autre ?? '—',
                'date'     => $a->date_dressage_autre ? Carbon::parse($a->date_dressage_autre)->locale('fr')->isoFormat('DD MMM YYYY') : '—',
                'url'      => '/etatcivils/autres',
                'sort'     => $a->created_at,
            ]);
        });

        $derniersActes = $derniersActes->sortByDesc('sort')->take(8)->values();

        return view('etatcivils.dashboard', compact(
            'nbNaissances', 'nbMariages', 'nbDeces', 'nbAutres',
            'newNaissancesMois', 'newMariagesMois', 'newDecesMois',
            'progressNaissances', 'progressMariages', 'progressDeces', 'progressAutres',
            'activites', 'derniersActes',
        ));
    }
}
