<?php

namespace App\Models\EtatCivil;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Personnel\Commune;

class Deces extends Model
{
    use SoftDeletes;

    protected $table = 'deces';

    protected $fillable = [
        'commune_id',

        // Registre
        'annee_registre_deces',
        'numero_registre_deces',
        'numero_act_deces',
        'nature_declarat_deces',
        'ment_jugem_supplet',

        // Dates & heure dressage
        'date_dessage_deces',
        'date_dessage_copi_integral_deces',
        'heure_dressage_deces',

        // Officier
        'nous_avons_signe_deces',
        'officier_etat_civil_deces',
        'qualite_etat_civil_deces',

        // Décès
        'date_deces',
        'lieu_deces',
        'heure_min_deces',

        // Défunt
        'sexe_deces',
        'fils_fille_deces',
        'nom_defunt',
        'prenom_defunt',
        'date_naissance_defunt',
        'lieu_naissance_defunt',
        'profession_defunt',
        'situa_familial_defunt',
        'nom_prenom_epoux_defunt',

        // Parents
        'nom_prenom_pere_defunt',
        'domicile_pere_defunt',
        'nom_prenom_mere_defunt',
        'domicile_mere_defunt',

        // Déclarant & interprète
        'info_declarant',
        'langue_declarant',
        'nom_prenom_interprete',

        // Officier d'origine
        'officier_etat_civil_origin_defunt',
        'centre_etat_civil_origin_defunt',
    ];

    protected $casts = [
        'date_dessage_deces'              => 'date',
        'date_dessage_copi_integral_deces'=> 'date',
        'date_deces'                      => 'date',
        'date_naissance_defunt'           => 'date',
        'annee_registre_deces'            => 'integer',
    ];

    // ── Accesseurs ────────────────────────────────────

    /** Nom complet du défunt */
    public function getNomPrenomDefuntAttribute(): string
    {
        return trim(($this->nom_defunt ?? '') . ' ' . ($this->prenom_defunt ?? ''));
    }

    /** Âge au décès (si les deux dates sont disponibles) */
    public function getAgeDecesAttribute(): ?int
    {
        if (! $this->date_naissance_defunt || ! $this->date_deces) return null;
        return $this->date_naissance_defunt->diffInYears($this->date_deces);
    }

    /** Numéro d'acte formaté */
    public function getNumeroActFormatAttribute(): string
    {
        return $this->numero_act_deces . '/' . $this->annee_registre_deces;
    }

    // ── Relations ─────────────────────────────────────

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }
}
