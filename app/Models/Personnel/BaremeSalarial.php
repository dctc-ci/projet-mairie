<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BaremeSalarial extends Model
{
    use SoftDeletes;

    // Nom exact de la table créée par artisan make:model BaremeSalarial
    protected $table = 'bareme_salarials';

    protected $fillable = [
        'categorie',
        'echelon',
        'indice',
        'salaire_base',
        'salaire_brut',
        'indem_residence',
    ];

    protected $casts = [
        'salaire_base'    => 'decimal:2',
        'salaire_brut'    => 'decimal:2',
        'indem_residence' => 'decimal:2',
    ];

    public function agents(): HasMany
    {
        return $this->hasMany(Agent::class, 'bareme_salarial_id');
    }
}
