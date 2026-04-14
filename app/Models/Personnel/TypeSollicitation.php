<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeSollicitation extends Model
{
    use SoftDeletes;

    protected $table = 'type_sollicitations';

    protected $fillable = [
        'libelle',
        'jours_disponible',
    ];

    protected $casts = [
        'jours_disponible' => 'integer',
    ];

    // ─── Relations ───────────────────────────────────────────

    public function sollicitations(): HasMany
    {
        return $this->hasMany(Sollicitation::class, 'type_sollicitation_id');
    }
}
