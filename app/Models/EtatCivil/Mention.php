<?php

namespace App\Models\EtatCivil;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Personnel\Commune; 

class Mention extends Model
{
    use SoftDeletes;

    protected $table = 'mentions';

    protected $fillable = [
        'commune_id',
        'extrait_id',

        // Mariage
        'date_mariage_mention',
        'lieu_mariage_mention',
        'nom_prenom_conjoint_mention',

        // Dissolution
        'date_mariage_dissous',
        'ref_act_dissous',

        // Décès
        'date_deces_mention',
        'lieu_deces_mention',

        // Autres
        'mention_reconnaissance',
        'mention_rectification',
        'mention_adoption',
        'mention_retablissement',
    ];

    protected $casts = [
        'date_mariage_mention'  => 'date',
        'date_mariage_dissous'  => 'date',
        'date_deces_mention'    => 'date',
    ];

    // ── Relations ─────────────────────────────────────

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

    public function extrait(): BelongsTo
    {
        return $this->belongsTo(Extrait::class, 'extrait_id');
    }
}
