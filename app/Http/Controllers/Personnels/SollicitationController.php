<?php

namespace App\Http\Controllers\Personnels;

use App\Http\Controllers\Controller;
use App\Models\Personnel\Sollicitation;
use Illuminate\View\View;

class SollicitationController extends Controller
{
    public function index()
    {
        $sollicitations = Sollicitation::latest()->get();

        return view('personnels.sollicitation', compact('sollicitations'));
    }

    /**
     * Mapping type_sollicitation_id → template blade PDF
     * Les types avec variante agent/non_permanent sont résolus dynamiquement.
     */
    private array $templateMap = [
        1 => 'cessation_service',           // CONGE ADMINISTRATIF (cessation)
        2 => 'conge_maladie',
        3 => 'conge_maternite',
        4 => 'conge_paternite',
        6 => 'conge_mariage_bapteme',        // MARIAGE TRAVAILLEUR
        7 => 'conge_mariage_bapteme',        // BAPTEME
        8 => 'ordre_de_mission',
        10 => 'autorisation_absence',
        11 => 'autorisation_absence_special',
        12 => 'attestation_travail',          // variante _agent ou _non_permanent
        13 => 'attestation_presence',
        14 => 'certificat_prise_service',     // variante _agent ou _non_permanent
        18 => 'accident',                     // variante _agent ou _non_permanent
        23 => 'certificat_reprise_service',
    ];

    /** Types dont le template varie selon le type d'agent */
    private array $varianteParType = [12, 14, 18];

    public function printDocument(Sollicitation $sollicitation): View
    {
        $sollicitation->load([
            'typeSollicitation',
            'agent.commune',
            'agent.baremeSalarial',
            'agentNonPermanent.commune',
            'stagiaire',
        ]);

        $typeId = $sollicitation->typeSollicitation?->id;
        $template = $this->templateMap[$typeId] ?? null;

        // Types sans PDF encore → page temporaire
        if (! $template) {
            return view('pdf.en_preparation', compact('sollicitation'));
        }

        // Résoudre la variante selon le type de personnel
        if (in_array($typeId, $this->varianteParType)) {
            $suffix = $sollicitation->agent_non_permanent_id ? '_non_permanent' : '_agent';
            $template .= $suffix;
        }

        // Pour le congé administratif : choisir cessation_avec_tranche si tranche remplie
        if ($typeId === 1 && ! empty($sollicitation->tranche_conge)) {
            $template = 'cessation_service_avec_tranche';
        }

        return view("pdf.{$template}", compact('sollicitation'));
    }

    public function printReprise(Sollicitation $sollicitation): View
    {
        $sollicitation->load([
            'typeSollicitation',
            'agent.commune',
            'agentNonPermanent.commune',
        ]);

        return view('pdf.certificat_reprise_service', compact('sollicitation'));
    }
}
