<?php

namespace App\Models\EtatCivil;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Personnel\Commune;

class Autredeclaration extends Model
{
    use SoftDeletes;

    protected $table = 'autredeclarations';

    protected $fillable = [
        'commune_id',

        // Registre
        'annee_registre_autre',
        'numero_registe_autre',
        'numero_act_autre',

        // Date & heure
        'date_dressage_autre',
        'heure_autre',
        'date_lettre_autre',

        // Officier
        'officier_etat_civil_autre',
        'qualite_etat_civil_autre',

        // Déclarant
        'civilite',
        'nom_prenom_autre',
        'profession_autre',
        'domicile_autre',

        // Acte
        'act_autre',
        'concernant_autre',
        'info_complet_rapport_act',
    ];

    protected $casts = [
        'date_dressage_autre'  => 'date',
        'annee_registre_autre' => 'integer',
    ];

    // ── Accesseurs ────────────────────────────────────

    /** Civilité + nom complet */
    public function getNomCompletAttribute(): string
    {
        return trim(($this->civilite ? $this->civilite . ' ' : '') . ($this->nom_prenom_autre ?? ''));
    }

    /** Numéro d'acte formaté */
    public function getNumeroActFormatAttribute(): string
    {
        return $this->numero_act_autre . '/' . $this->annee_registre_autre;
    }

    // ── Relations ─────────────────────────────────────

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }
}
