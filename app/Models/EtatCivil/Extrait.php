<?php

namespace App\Models\EtatCivil;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Personnel\Commune;

class Extrait extends Model
{
    use SoftDeletes;

    protected $table = 'extraits';

    protected $fillable = [
        'commune_id',

        // Registre
        'centr_etat_civil',
        'annee_registre_extrai',
        'nature_declarat_extrai',
        'numero_registre_extrai',
        'numero_act_extrai',
        'numero_complet_act_extrai',

        // Dates & heure
        'date_dressage',
        'heure_dressage',
        'date_dressage_copie_integrale',

        // Officier
        'officier_etat_civil',
        'qualite',
        'nous_avons_signer',

        // Enfant
        'nom_enfant',
        'prenom_enfant',
        'date_naissance_lettre',
        'date_naissance',
        'heure_min_naissance',
        'lieux_naissance',
        'sexe',
        'fils_fille',

        // Père
        'nom_prenom_pere',
        'date_naissance_pere',
        'annee_naissance_pere',
        'lieu_naissance_pere',
        'profession_pere',
        'nationnalite_pere',
        'domicile_pere',
        'nature_piece_pere',

        // Mère
        'nom_prenom_mere',
        'date_naissance_mere',
        'annee_naissance_mere',
        'profession_mere',
        'nationalite_mere',
        'domicile_mere',
        'nature_piece_mere',

        // Déclarant & Témoins
        'info_declarant',
        'info_temoin_1',
        'info_temoin_2',
    ];

    protected $casts = [
        'date_dressage'                   => 'date',
        'date_dressage_copie_integrale'   => 'date',
        'date_naissance'                  => 'date',
        'date_naissance_pere'             => 'date',
        'date_naissance_mere'             => 'date',
        'annee_registre_extrai'           => 'integer',
        'annee_naissance_pere'            => 'integer',
        'annee_naissance_mere'            => 'integer',
    ];

    // ── Accesseurs utiles ─────────────────────────────

    /** Nom complet de l'enfant */
    public function getNomPrenomEnfantAttribute(): string
    {
        return trim(($this->nom_enfant ?? '') . ' ' . ($this->prenom_enfant ?? ''));
    }

    /** Numéro d'acte formaté (ex: 001/2026) */
    public function getNumeroActFormatAttribute(): string
    {
        return $this->numero_complet_act_extrai
            ?? ($this->numero_act_extrai . '/' . $this->annee_registre_extrai);
    }

    // ── Relations ─────────────────────────────────────

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

    public function mentions(): HasMany
    {
        return $this->hasMany(Mention::class, 'extrait_id');
    }
}
