<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SituationFamiliale extends Model
{
    use SoftDeletes;

    protected $table = 'situation_familiales';

    protected $fillable = [
        'agent_id',
        'situation_mariale',
        'nature_piece',
        'numero_piece',
        'date_etabli_piece',
        'nom_prenom_femme',
        'group_sangin',
        'date_mariage',
        'lieu_mariage',
        'enfants',
    ];

    protected $casts = [
        'date_etabli_piece' => 'date',
        'date_mariage'      => 'date',
        // JSON : [{ nom_prenom, date_naissance, lieu_naissance, numero_extrait }]
        'enfants'           => 'array',
    ];

    // ─── Relations ───────────────────────────────────────────

    /** Situation familiale appartient à un agent */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}
