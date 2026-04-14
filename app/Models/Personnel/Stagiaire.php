<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stagiaire extends Model
{
    use SoftDeletes;

    protected $table = 'stagiaires';

    protected $fillable = [
        'nom_prenom_stagiaire',
        'date_naissance_stagiaire',
        'lieu_naissance_stagiaire',
        'nature_diplome',
        'numero_diplome',
        'session',
        'option',
        'contact_stagiaire',
        'contact_urgence_stagiaire',
        'annee_exercice',
        'service_accueil',
        'maitre_stage',
        'date_demarrage',
        'date_fin',
        'theme_stage',
        'note',
        'appreciation',
        'inscri_emploi_jeune',
    ];

    protected $casts = [
        'date_naissance_stagiaire' => 'date',
        'date_demarrage'           => 'date',
        'date_fin'                 => 'date',
        'note'                     => 'decimal:2',
        'inscri_emploi_jeune'      => 'boolean',
    ];

    // ─── Relations ───────────────────────────────────────────

    /** Stagiaire soumet plusieurs sollicitations (1,n) */
    public function sollicitations(): HasMany
    {
        return $this->hasMany(Sollicitation::class, 'stagiaire_id');
    }
}
