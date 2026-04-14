<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agent extends Model
{
    use SoftDeletes;

    protected $table = 'agents';

    protected $fillable = [
        'commune_id',
        'bareme_salarial_id',

        // Identité
        'nom_prenom_agent',
        'date_naissance_agent',
        'sexe_agent',
        'matricule',
        'qualification',
        'contact_agent',
        'contact_urgence_1',
        'contact_urgence_2',

        // Embauche
        'nature_embauche',
        'numero_embauche',
        'date_embauche',
        'date_fonction_embauche',
        'date_prise_service',

        // Classification
        'groupe',
        'indem_transp',
        'indem_fonction',
        'indem_techn',

        // Poste
        'fonction',
        'service',
        'post_travail',
        'statut',

        // Budgétaire
        'imputa_budgetaire',
        'chapitre_paie',
        'article_paie',

        // Photo
        'photo_agent',
    ];

    protected $casts = [
        'date_naissance_agent'   => 'date',
        'date_embauche'          => 'date',
        'date_fonction_embauche' => 'date',
        'date_prise_service'     => 'date',
        'indem_transp'           => 'decimal:2',
        'indem_fonction'         => 'decimal:2',
        'indem_techn'            => 'decimal:2',
    ];

    // ─── Relations ───────────────────────────────────────────

    /** Agent appartient à une commune */
    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

    /** Agent applique un barème salarial */
    public function baremeSalarial(): BelongsTo
    {
        return $this->belongsTo(BaremeSalarial::class, 'bareme_salarial_id');
    }

    /** Agent a une situation familiale (1,1) */
    public function situationFamiliale(): HasOne
    {
        return $this->hasOne(SituationFamiliale::class, 'agent_id');
    }

    /** Agent possède plusieurs bulletins de salaire (1,n) */
    public function bulletinsSalaire(): HasMany
    {
        return $this->hasMany(BulletinSalaire::class, 'agent_id');
    }

    /** Agent soumet plusieurs sollicitations (1,n) */
    public function sollicitations(): HasMany
    {
        return $this->hasMany(Sollicitation::class, 'agent_id');
    }
}
