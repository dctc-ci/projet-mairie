<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sollicitation extends Model
{
    use SoftDeletes;

    protected $table = 'sollicitations';

    protected $fillable = [
        // Clés étrangères (une seule non nulle)
        'agent_id',
        'agent_non_permanent_id',
        'stagiaire_id',
        'type_sollicitation_id',

        // Informations générales
        'motif_sollicitation',
        'destination',
        'date_sollicitation',
        'date_cessation',
        'date_depart',
        'date_retour',
        'date_reprise',

        // Signataire
        'signataire',
        'fonction_signataire',

        // Justificatif
        'justificatif',

        // Congé
        'tranche_conge',
        'observation_conge',

        // Statut
        'etat_sollicitation',

        // Accident de travail
        'date_accident',
        'lieu_accident',
        'gravite_accident',
        'declare_cnps',
        'date_declare_cnps',
    ];

    protected $casts = [
        'date_sollicitation' => 'date',
        'date_cessation'     => 'date',
        'date_depart'        => 'date',
        'date_retour'        => 'date',
        'date_reprise'       => 'date',
        'date_accident'      => 'date',
        'date_declare_cnps'  => 'date',
        'declare_cnps'       => 'boolean',
    ];

    const ETATS = [
        'en_attente' => 'En attente',
        'approuvee'  => 'Approuvée',
        'rejetee'    => 'Rejetée',
        'annulee'    => 'Annulée',
    ];

    // ─── Relations ───────────────────────────────────────────

    /** Sollicitation soumise par un agent permanent */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    /** Sollicitation soumise par un agent non permanent */
    public function agentNonPermanent(): BelongsTo
    {
        return $this->belongsTo(AgentNonPermanent::class, 'agent_non_permanent_id');
    }

    /** Sollicitation soumise par un stagiaire */
    public function stagiaire(): BelongsTo
    {
        return $this->belongsTo(Stagiaire::class, 'stagiaire_id');
    }

    /** Type de sollicitation */
    public function typeSollicitation(): BelongsTo
    {
        return $this->belongsTo(TypeSollicitation::class, 'type_sollicitation_id');
    }

    // ─── Accesseurs utilitaires ───────────────────────────────

    /**
     * Retourne le demandeur (agent, agent non permanent ou stagiaire)
     * selon la clé étrangère remplie.
     */
    public function getDemandeurAttribute(): ?Model
    {
        return $this->agent
            ?? $this->agentNonPermanent
            ?? $this->stagiaire;
    }

    /**
     * Retourne le type du demandeur sous forme de chaîne lisible.
     */
    public function getTypeDemandeurAttribute(): string
    {
        if ($this->agent_id)               return 'Agent permanent';
        if ($this->agent_non_permanent_id) return 'Agent non permanent';
        if ($this->stagiaire_id)           return 'Stagiaire';
        return 'Inconnu';
    }
}
