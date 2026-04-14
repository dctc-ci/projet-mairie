<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BulletinSalaire extends Model
{
    use SoftDeletes;

    protected $table = 'bulletins_salaire';

    protected $fillable = [
        'agent_id',
        'mois_paie',
        'indem_transp_cotation',
        'igr',
        'impot_salaire',
        'contrib_nation',
    ];

    protected $casts = [
        'indem_transp_cotation' => 'decimal:2',
        'igr'                   => 'decimal:2',
        'impot_salaire'         => 'decimal:2',
        'contrib_nation'        => 'decimal:2',
    ];

    // ─── Relations ───────────────────────────────────────────

    /** Bulletin appartient à un agent */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}
