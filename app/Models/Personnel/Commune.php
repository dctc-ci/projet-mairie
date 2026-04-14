<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commune extends Model
{
    use SoftDeletes;

    protected $table = 'communes';

    protected $fillable = [
        'nom_commune',
        'code_commune',
    ];

    // ─── Relations ───────────────────────────────────────────

    public function agents(): HasMany
    {
        return $this->hasMany(Agent::class, 'commune_id');
    }

    public function agentsNonPermanents(): HasMany
    {
        return $this->hasMany(AgentNonPermanent::class, 'commune_id');
    }
}
