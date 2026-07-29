<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleSetting extends Model
{
    public const PERSONNELS = 'personnels';
    public const ETAT_CIVIL = 'etat-civil';
    public const PRESTATIONS = 'prestations';

    protected $fillable = ['key', 'enabled'];

    protected function casts(): array
    {
        return ['enabled' => 'boolean'];
    }

    public static function enabled(string $key): bool
    {
        return static::query()->where('key', $key)->value('enabled') ?? true;
    }
}
