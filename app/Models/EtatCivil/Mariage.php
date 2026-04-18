<?php

namespace App\Models\EtatCivil;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Personnel\Commune;

class Mariage extends Model
{
    use SoftDeletes;

    protected $table = 'mariages';

    protected $fillable = [
        'commune_id',

        // Registre
        'annee_encours',
        'annee_registre_mariage',
        'numero_act_mariage',
        'numero_complet_act_mariage',

        // Dates & heure
        'date_mariage',
        'date_mariage_lettre',
        'heure_min_mariage',
        'date_dessage',
        'date_dreesage_copie_integrale',

        // Régime & lieu
        'regime_matrimonial',
        'lieu_mariage',

        // Officier
        'officier_etat_civil_mariage',
        'qualite_officier',

        // Époux
        'nom_epoux',
        'prenom_epoux',
        'date_naissance_lettre_epoux',
        'date_naissance_epoux',
        'lieu_naissance_epoux',
        'ref_extrai_epoux',
        'ref_piece_epoux',
        'profession_epoux',
        'nom_prenom_pere_epoux',
        'nom_prenom_mere_epoux',
        'domicile_pere',
        'statut_matrimo_epoux',

        // Épouse
        'nom_epouse',
        'prenom_epouse',
        'date_naissance_lettre_epouse',
        'date_naissance_epouse',
        'lieu_naissance_epouse',
        'ref_extrai_epouse',
        'ref_piece_epouse',
        'profession_epouse',
        'nom_prenom_pere_epouse',
        'nom_prenom_mere_epouse',
        'domicile_mere',
        'statut_matrimo_epouse',

        // Témoin de l'époux
        'nom_prenom_temoin_epoux',
        'age_temoin_epoux',
        'ref_piece_temoin_epoux',
        'profession_temoin_epoux',
        'domicile_temoin_epoux',
        'date_naissance_temoin_epoux',
        'lieu_naissance_temoin_epoux',
        'plus_info_temoin_epoux',

        // Témoin de l'épouse
        'nom_prenom_temoin_epouse',
        'age_temoin_epouse',
        'ref_piece_temoin_epouse',
        'profession_temoin_epouse',
        'domicile_temoin_epouse',
        'date_naissance_temoin_epouse',
        'lieu_naissance_temoin_epouse',
        'plus_info_temoin_epouse',

        // Officiers d'origine
        'officier_etat_civil_origin_epoux',
        'centre_etat_civil_origin_epoux',
        'officier_etat_civil_origin_epouse',
        'centre_etat_civil_origin_epouse',
    ];

    protected $casts = [
        'date_mariage'                    => 'date',
        'date_dessage'                    => 'date',
        'date_dreesage_copie_integrale'   => 'date',
        'date_naissance_epoux'            => 'date',
        'date_naissance_epouse'           => 'date',
        'date_naissance_temoin_epoux'     => 'date',
        'date_naissance_temoin_epouse'    => 'date',
        'annee_encours'                   => 'integer',
        'annee_registre_mariage'          => 'integer',
        'age_temoin_epoux'                => 'integer',
        'age_temoin_epouse'               => 'integer',
    ];

    // ── Accesseurs ────────────────────────────────────

    /** Nom complet de l'époux */
    public function getNomPrenomEpouxAttribute(): string
    {
        return trim(($this->nom_epoux ?? '') . ' ' . ($this->prenom_epoux ?? ''));
    }

    /** Nom complet de l'épouse */
    public function getNomPrenomEpouseAttribute(): string
    {
        return trim(($this->nom_epouse ?? '') . ' ' . ($this->prenom_epouse ?? ''));
    }

    /** Numéro d'acte formaté */
    public function getNumeroActFormatAttribute(): string
    {
        return $this->numero_complet_act_mariage
            ?? ($this->numero_act_mariage . '/' . $this->annee_registre_mariage);
    }

    // ── Relations ─────────────────────────────────────

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }
}
