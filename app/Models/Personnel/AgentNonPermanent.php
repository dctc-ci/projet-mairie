<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgentNonPermanent extends Model
{
    use SoftDeletes;

    protected $table = 'agents_non_permanents';

    protected $fillable = [
        'commune_id',
        'nom_prenom_nopermanent',
        'sexe_nopermanent',
        'date_naissance_nopermanent',
        'type_piece_agentnopermanent',
        'numero_piece_agentnopermanent',
        'date_piece_etabli_agentnopermanent',
        'numero_cnps_agentnopermanent',
        'fonction_nopermanent',
        'service_nopermanent',
        'statut_nopermanent',
        'date_recrutement_nopermanent',
        'indemnite',
        'situa_marial_nopermanent',
        'act_recrutement_nopermanent',
        'numero_act_recrutement_nopermanent',
        'contact_agent_nopermanent',
        'contact_urgence_1_nopermanent',
        'contact_urgence_2_nopermanent',
        'photo_agent_nopermanent',
    ];

    protected $casts = [
        'date_recrutement_nopermanent' => 'date',
        'date_naissance_nopermanent' => 'date',
        'date_piece_etabli_agentnopermanent' => 'date',
        'indemnite' => 'decimal:2',
    ];

    // ─── Relations ───────────────────────────────────────────

    /** Agent non permanent rattaché à une commune */
    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

    /** Agent non permanent soumet plusieurs sollicitations (1,n) */
    public function sollicitations(): HasMany
    {
        return $this->hasMany(Sollicitation::class, 'agent_non_permanent_id');
    }
}
