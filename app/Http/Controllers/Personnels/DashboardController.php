<?php

namespace App\Http\Controllers\Personnels;

use App\Http\Controllers\Controller;
use App\Models\Personnel\Agent;
use App\Models\Personnel\AgentNonPermanent;
use App\Models\Personnel\Stagiaire;
use App\Models\Personnel\Sollicitation;
use App\Models\Personnel\BulletinSalaire;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now        = Carbon::now();
        $debutMois  = $now->copy()->startOfMonth();
        $hierDebut  = $now->copy()->subDay()->startOfDay();
        $hierFin    = $now->copy()->subDay()->endOfDay();

        // ── Statistiques principales ───────────────────────────────

        $nbAgentsPermanents = Agent::count();
        $nbAgentsNonPerm    = AgentNonPermanent::count();
        $nbStagiaires       = Stagiaire::count();
        $nbSollicitationsEnAttente = Sollicitation::where('etat_sollicitation', 'en_attente')->count();

        // Nouveaux ce mois
        $newAgentsMois   = Agent::where('created_at', '>=', $debutMois)->count();
        $newNonPermMois  = AgentNonPermanent::where('created_at', '>=', $debutMois)->count();

        // Totaux pour les barres de progression (tous agents confondus)
        $totalPersonnel = max(1, $nbAgentsPermanents + $nbAgentsNonPerm + $nbStagiaires);

        $progressPermanents = round(($nbAgentsPermanents / $totalPersonnel) * 100);
        $progressNonPerm    = round(($nbAgentsNonPerm    / $totalPersonnel) * 100);
        $progressStagiaires = round(($nbStagiaires       / $totalPersonnel) * 100);
        $progressSollicit   = $nbSollicitationsEnAttente > 0
            ? min(100, round(($nbSollicitationsEnAttente / max(1, Sollicitation::count())) * 100))
            : 0;

        // ── Activité récente (20 dernières opérations) ─────────────

        $activites = collect();

        // Derniers agents permanents
        Agent::latest()->limit(5)->get()->each(function ($a) use (&$activites) {
            $activites->push([
                'type'       => 'agent',
                'couleur'    => 'green',
                'icone'      => 'user-add',
                'titre'      => 'Nouvel agent permanent ajouté',
                'detail'     => $a->nom_prenom_agent . ($a->service ? ' — ' . $a->service : ''),
                'created_at' => $a->created_at,
            ]);
        });

        // Derniers agents non permanents
        AgentNonPermanent::latest()->limit(3)->get()->each(function ($a) use (&$activites) {
            $activites->push([
                'type'       => 'non_permanent',
                'couleur'    => 'orange',
                'icone'      => 'user',
                'titre'      => 'Agent non permanent enregistré',
                'detail'     => $a->nom_prenom_nopermanent . ($a->service_nopermanent ? ' — ' . $a->service_nopermanent : ''),
                'created_at' => $a->created_at,
            ]);
        });

        // Derniers stagiaires
        Stagiaire::latest()->limit(3)->get()->each(function ($s) use (&$activites) {
            $activites->push([
                'type'       => 'stagiaire',
                'couleur'    => 'gold',
                'icone'      => 'academic',
                'titre'      => 'Nouveau stagiaire enregistré',
                'detail'     => $s->nom_prenom_stagiaire . ($s->service_accueil ? ' — ' . $s->service_accueil : ''),
                'created_at' => $s->created_at,
            ]);
        });

        // Dernières sollicitations
        Sollicitation::with(['agent', 'agentNonPermanent', 'typeSollicitation'])
            ->latest()->limit(4)->get()->each(function ($s) use (&$activites) {
                $nom = $s->agent?->nom_prenom_agent
                    ?? $s->agentNonPermanent?->nom_prenom_nopermanent
                    ?? 'Inconnu';
                $activites->push([
                    'type'       => 'sollicitation',
                    'couleur'    => 'orange',
                    'icone'      => 'mail',
                    'titre'      => 'Sollicitation soumise',
                    'detail'     => ($s->typeSollicitation?->libelle ?? 'Demande') . ' — ' . $nom,
                    'created_at' => $s->created_at,
                ]);
            });

        // Derniers bulletins
        BulletinSalaire::with('agent')->latest()->limit(3)->get()->each(function ($b) use (&$activites) {
            $activites->push([
                'type'       => 'bulletin',
                'couleur'    => 'navy',
                'icone'      => 'document',
                'titre'      => 'Bulletin de salaire généré',
                'detail'     => ($b->agent?->nom_prenom_agent ?? '—')
                                . ' — Paie ' . ucfirst(
                                    Carbon::createFromFormat('Y-m', $b->mois_paie)
                                          ->locale('fr')->isoFormat('MMMM YYYY')
                                ),
                'created_at' => $b->created_at,
            ]);
        });

        // Trier par date décroissante et ne garder que 6
        $activites = $activites->sortByDesc('created_at')->take(6)->values();

        // ── Sollicitations en attente (table) ─────────────────────

        $sollicitationsEnAttente = Sollicitation::with([
                'agent', 'agentNonPermanent', 'stagiaire', 'typeSollicitation',
            ])
            ->where('etat_sollicitation', 'en_attente')
            ->latest('date_sollicitation')
            ->limit(5)
            ->get();

        return view('personnels.dashboard', compact(
            'nbAgentsPermanents',
            'nbAgentsNonPerm',
            'nbStagiaires',
            'nbSollicitationsEnAttente',
            'newAgentsMois',
            'newNonPermMois',
            'progressPermanents',
            'progressNonPerm',
            'progressStagiaires',
            'progressSollicit',
            'activites',
            'sollicitationsEnAttente',
        ));
    }
}
