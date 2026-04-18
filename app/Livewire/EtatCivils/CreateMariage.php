<?php

namespace App\Livewire\EtatCivils;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\EtatCivil\Mariage;
use App\Models\Personnel\Commune;
use Illuminate\Support\Facades\Log;

class CreateMariage extends Component
{
    use WithPagination;

    // ═══════════════════════════════════════════════════════
    // ÉTAT DES MODALS
    // ═══════════════════════════════════════════════════════

    public bool $showModal      = false;
    public bool $showFicheModal = false;
    public bool $editMode       = false;
    public ?int $selectedId     = null;

    // ═══════════════════════════════════════════════════════
    // NAVIGATION — 6 ÉTAPES
    // ═══════════════════════════════════════════════════════

    public int $step     = 1;
    public int $maxSteps = 6;

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 1 — Commune & Registre
    // ═══════════════════════════════════════════════════════

    public string $commune_id                  = '';
    public string $annee_encours               = '';
    public string $annee_registre_mariage      = '';
    public string $numero_act_mariage          = '';
    public string $numero_complet_act_mariage  = '';
    public string $date_mariage                = '';
    public string $date_mariage_lettre         = '';
    public string $heure_min_mariage           = '';
    public string $lieu_mariage                = '';
    public string $regime_matrimonial          = '';
    public string $date_dessage                = '';
    public string $date_dreesage_copie_integrale = '';
    public string $officier_etat_civil_mariage = '';
    public string $qualite_officier            = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 2 — Époux
    // ═══════════════════════════════════════════════════════

    public string $nom_epoux                   = '';
    public string $prenom_epoux                = '';
    public string $date_naissance_lettre_epoux = '';
    public string $date_naissance_epoux        = '';
    public string $lieu_naissance_epoux        = '';
    public string $ref_extrai_epoux            = '';
    public string $ref_piece_epoux             = '';
    public string $profession_epoux            = '';
    public string $nom_prenom_pere_epoux       = '';
    public string $nom_prenom_mere_epoux       = '';
    public string $domicile_pere               = '';
    public string $statut_matrimo_epoux        = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 3 — Épouse
    // ═══════════════════════════════════════════════════════

    public string $nom_epouse                   = '';
    public string $prenom_epouse                = '';
    public string $date_naissance_lettre_epouse = '';
    public string $date_naissance_epouse        = '';
    public string $lieu_naissance_epouse        = '';
    public string $ref_extrai_epouse            = '';
    public string $ref_piece_epouse             = '';
    public string $profession_epouse            = '';
    public string $nom_prenom_pere_epouse       = '';
    public string $nom_prenom_mere_epouse       = '';
    public string $domicile_mere                = '';
    public string $statut_matrimo_epouse        = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 4 — Témoin de l'époux
    // ═══════════════════════════════════════════════════════

    public string $nom_prenom_temoin_epoux       = '';
    public string $age_temoin_epoux              = '';
    public string $ref_piece_temoin_epoux        = '';
    public string $profession_temoin_epoux       = '';
    public string $domicile_temoin_epoux         = '';
    public string $date_naissance_temoin_epoux   = '';
    public string $lieu_naissance_temoin_epoux   = '';
    public string $plus_info_temoin_epoux        = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 5 — Témoin de l'épouse
    // ═══════════════════════════════════════════════════════

    public string $nom_prenom_temoin_epouse       = '';
    public string $age_temoin_epouse              = '';
    public string $ref_piece_temoin_epouse        = '';
    public string $profession_temoin_epouse       = '';
    public string $domicile_temoin_epouse         = '';
    public string $date_naissance_temoin_epouse   = '';
    public string $lieu_naissance_temoin_epouse   = '';
    public string $plus_info_temoin_epouse        = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 6 — Officiers d'origine
    // ═══════════════════════════════════════════════════════

    public string $officier_etat_civil_origin_epoux  = '';
    public string $centre_etat_civil_origin_epoux    = '';
    public string $officier_etat_civil_origin_epouse = '';
    public string $centre_etat_civil_origin_epouse   = '';

    // ═══════════════════════════════════════════════════════
    // CHAMPS ÉDITION (préfixés edit_)
    // ═══════════════════════════════════════════════════════

    public string $edit_commune_id                    = '';
    public string $edit_annee_encours                 = '';
    public string $edit_annee_registre_mariage        = '';
    public string $edit_numero_act_mariage            = '';
    public string $edit_numero_complet_act_mariage    = '';
    public string $edit_date_mariage                  = '';
    public string $edit_date_mariage_lettre           = '';
    public string $edit_heure_min_mariage             = '';
    public string $edit_lieu_mariage                  = '';
    public string $edit_regime_matrimonial            = '';
    public string $edit_date_dessage                  = '';
    public string $edit_date_dreesage_copie_integrale = '';
    public string $edit_officier_etat_civil_mariage   = '';
    public string $edit_qualite_officier              = '';
    public string $edit_nom_epoux                     = '';
    public string $edit_prenom_epoux                  = '';
    public string $edit_date_naissance_lettre_epoux   = '';
    public string $edit_date_naissance_epoux          = '';
    public string $edit_lieu_naissance_epoux          = '';
    public string $edit_ref_extrai_epoux              = '';
    public string $edit_ref_piece_epoux               = '';
    public string $edit_profession_epoux              = '';
    public string $edit_nom_prenom_pere_epoux         = '';
    public string $edit_nom_prenom_mere_epoux         = '';
    public string $edit_domicile_pere                 = '';
    public string $edit_statut_matrimo_epoux          = '';
    public string $edit_nom_epouse                    = '';
    public string $edit_prenom_epouse                 = '';
    public string $edit_date_naissance_lettre_epouse  = '';
    public string $edit_date_naissance_epouse         = '';
    public string $edit_lieu_naissance_epouse         = '';
    public string $edit_ref_extrai_epouse             = '';
    public string $edit_ref_piece_epouse              = '';
    public string $edit_profession_epouse             = '';
    public string $edit_nom_prenom_pere_epouse        = '';
    public string $edit_nom_prenom_mere_epouse        = '';
    public string $edit_domicile_mere                 = '';
    public string $edit_statut_matrimo_epouse         = '';
    public string $edit_nom_prenom_temoin_epoux       = '';
    public string $edit_age_temoin_epoux              = '';
    public string $edit_ref_piece_temoin_epoux        = '';
    public string $edit_profession_temoin_epoux       = '';
    public string $edit_domicile_temoin_epoux         = '';
    public string $edit_date_naissance_temoin_epoux   = '';
    public string $edit_lieu_naissance_temoin_epoux   = '';
    public string $edit_plus_info_temoin_epoux        = '';
    public string $edit_nom_prenom_temoin_epouse      = '';
    public string $edit_age_temoin_epouse             = '';
    public string $edit_ref_piece_temoin_epouse       = '';
    public string $edit_profession_temoin_epouse      = '';
    public string $edit_domicile_temoin_epouse        = '';
    public string $edit_date_naissance_temoin_epouse  = '';
    public string $edit_lieu_naissance_temoin_epouse  = '';
    public string $edit_plus_info_temoin_epouse       = '';
    public string $edit_officier_etat_civil_origin_epoux  = '';
    public string $edit_centre_etat_civil_origin_epoux    = '';
    public string $edit_officier_etat_civil_origin_epouse = '';
    public string $edit_centre_etat_civil_origin_epouse   = '';

    // ═══════════════════════════════════════════════════════
    // FILTRES TABLE
    // ═══════════════════════════════════════════════════════

    public string $search         = '';
    public string $filtre_commune = '';
    public string $filtre_annee  = '';

    // ═══════════════════════════════════════════════════════
    // COMPUTED
    // ═══════════════════════════════════════════════════════

    #[Computed]
    public function communes(): \Illuminate\Support\Collection
    {
        return Commune::orderBy('nom_commune')->get();
    }

    // ═══════════════════════════════════════════════════════
    // GESTION MODAL CRÉATION
    // ═══════════════════════════════════════════════════════

    public function openModal(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->step                          = 1;
        $this->commune_id                    = '';
        $this->annee_encours                 = (string) date('Y');
        $this->annee_registre_mariage        = (string) date('Y');
        $this->numero_act_mariage            = '';
        $this->numero_complet_act_mariage    = '';
        $this->date_mariage                  = '';
        $this->date_mariage_lettre           = '';
        $this->heure_min_mariage             = '';
        $this->lieu_mariage                  = '';
        $this->regime_matrimonial            = '';
        $this->date_dessage                  = '';
        $this->date_dreesage_copie_integrale = '';
        $this->officier_etat_civil_mariage   = '';
        $this->qualite_officier              = '';
        $this->nom_epoux                     = '';
        $this->prenom_epoux                  = '';
        $this->date_naissance_lettre_epoux   = '';
        $this->date_naissance_epoux          = '';
        $this->lieu_naissance_epoux          = '';
        $this->ref_extrai_epoux              = '';
        $this->ref_piece_epoux               = '';
        $this->profession_epoux              = '';
        $this->nom_prenom_pere_epoux         = '';
        $this->nom_prenom_mere_epoux         = '';
        $this->domicile_pere                 = '';
        $this->statut_matrimo_epoux          = '';
        $this->nom_epouse                    = '';
        $this->prenom_epouse                 = '';
        $this->date_naissance_lettre_epouse  = '';
        $this->date_naissance_epouse         = '';
        $this->lieu_naissance_epouse         = '';
        $this->ref_extrai_epouse             = '';
        $this->ref_piece_epouse              = '';
        $this->profession_epouse             = '';
        $this->nom_prenom_pere_epouse        = '';
        $this->nom_prenom_mere_epouse        = '';
        $this->domicile_mere                 = '';
        $this->statut_matrimo_epouse         = '';
        $this->nom_prenom_temoin_epoux       = '';
        $this->age_temoin_epoux              = '';
        $this->ref_piece_temoin_epoux        = '';
        $this->profession_temoin_epoux       = '';
        $this->domicile_temoin_epoux         = '';
        $this->date_naissance_temoin_epoux   = '';
        $this->lieu_naissance_temoin_epoux   = '';
        $this->plus_info_temoin_epoux        = '';
        $this->nom_prenom_temoin_epouse      = '';
        $this->age_temoin_epouse             = '';
        $this->ref_piece_temoin_epouse       = '';
        $this->profession_temoin_epouse      = '';
        $this->domicile_temoin_epouse        = '';
        $this->date_naissance_temoin_epouse  = '';
        $this->lieu_naissance_temoin_epouse  = '';
        $this->plus_info_temoin_epouse       = '';
        $this->officier_etat_civil_origin_epoux  = '';
        $this->centre_etat_civil_origin_epoux    = '';
        $this->officier_etat_civil_origin_epouse = '';
        $this->centre_etat_civil_origin_epouse   = '';
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // GESTION MODAL FICHE
    // ═══════════════════════════════════════════════════════

    public function viewFiche(int $id): void
    {
        $this->selectedId     = $id;
        $this->editMode       = false;
        $this->resetErrorBag();
        $this->showFicheModal = true;
    }

    public function closeFicheModal(): void
    {
        $this->showFicheModal = false;
        $this->selectedId     = null;
        $this->editMode       = false;
        $this->resetErrorBag();
    }

    public function enableEditMode(): void
    {
        $m = $this->selectedMariage;
        if (! $m) return;

        $df = fn($v) => $v ? \Carbon\Carbon::parse($v)->format('Y-m-d') : '';

        $this->edit_commune_id                    = (string) ($m->commune_id ?? '');
        $this->edit_annee_encours                 = (string) ($m->annee_encours ?? '');
        $this->edit_annee_registre_mariage        = (string) ($m->annee_registre_mariage ?? '');
        $this->edit_numero_act_mariage            = $m->numero_act_mariage            ?? '';
        $this->edit_numero_complet_act_mariage    = $m->numero_complet_act_mariage    ?? '';
        $this->edit_date_mariage                  = $df($m->date_mariage);
        $this->edit_date_mariage_lettre           = $m->date_mariage_lettre           ?? '';
        $this->edit_heure_min_mariage             = $m->heure_min_mariage             ?? '';
        $this->edit_lieu_mariage                  = $m->lieu_mariage                  ?? '';
        $this->edit_regime_matrimonial            = $m->regime_matrimonial            ?? '';
        $this->edit_date_dessage                  = $df($m->date_dessage);
        $this->edit_date_dreesage_copie_integrale = $df($m->date_dreesage_copie_integrale);
        $this->edit_officier_etat_civil_mariage   = $m->officier_etat_civil_mariage   ?? '';
        $this->edit_qualite_officier              = $m->qualite_officier              ?? '';
        $this->edit_nom_epoux                     = $m->nom_epoux                     ?? '';
        $this->edit_prenom_epoux                  = $m->prenom_epoux                  ?? '';
        $this->edit_date_naissance_lettre_epoux   = $m->date_naissance_lettre_epoux   ?? '';
        $this->edit_date_naissance_epoux          = $df($m->date_naissance_epoux);
        $this->edit_lieu_naissance_epoux          = $m->lieu_naissance_epoux          ?? '';
        $this->edit_ref_extrai_epoux              = $m->ref_extrai_epoux              ?? '';
        $this->edit_ref_piece_epoux               = $m->ref_piece_epoux               ?? '';
        $this->edit_profession_epoux              = $m->profession_epoux              ?? '';
        $this->edit_nom_prenom_pere_epoux         = $m->nom_prenom_pere_epoux         ?? '';
        $this->edit_nom_prenom_mere_epoux         = $m->nom_prenom_mere_epoux         ?? '';
        $this->edit_domicile_pere                 = $m->domicile_pere                 ?? '';
        $this->edit_statut_matrimo_epoux          = $m->statut_matrimo_epoux          ?? '';
        $this->edit_nom_epouse                    = $m->nom_epouse                    ?? '';
        $this->edit_prenom_epouse                 = $m->prenom_epouse                 ?? '';
        $this->edit_date_naissance_lettre_epouse  = $m->date_naissance_lettre_epouse  ?? '';
        $this->edit_date_naissance_epouse         = $df($m->date_naissance_epouse);
        $this->edit_lieu_naissance_epouse         = $m->lieu_naissance_epouse         ?? '';
        $this->edit_ref_extrai_epouse             = $m->ref_extrai_epouse             ?? '';
        $this->edit_ref_piece_epouse              = $m->ref_piece_epouse              ?? '';
        $this->edit_profession_epouse             = $m->profession_epouse             ?? '';
        $this->edit_nom_prenom_pere_epouse        = $m->nom_prenom_pere_epouse        ?? '';
        $this->edit_nom_prenom_mere_epouse        = $m->nom_prenom_mere_epouse        ?? '';
        $this->edit_domicile_mere                 = $m->domicile_mere                 ?? '';
        $this->edit_statut_matrimo_epouse         = $m->statut_matrimo_epouse         ?? '';
        $this->edit_nom_prenom_temoin_epoux       = $m->nom_prenom_temoin_epoux       ?? '';
        $this->edit_age_temoin_epoux              = (string) ($m->age_temoin_epoux    ?? '');
        $this->edit_ref_piece_temoin_epoux        = $m->ref_piece_temoin_epoux        ?? '';
        $this->edit_profession_temoin_epoux       = $m->profession_temoin_epoux       ?? '';
        $this->edit_domicile_temoin_epoux         = $m->domicile_temoin_epoux         ?? '';
        $this->edit_date_naissance_temoin_epoux   = $df($m->date_naissance_temoin_epoux);
        $this->edit_lieu_naissance_temoin_epoux   = $m->lieu_naissance_temoin_epoux   ?? '';
        $this->edit_plus_info_temoin_epoux        = $m->plus_info_temoin_epoux        ?? '';
        $this->edit_nom_prenom_temoin_epouse      = $m->nom_prenom_temoin_epouse      ?? '';
        $this->edit_age_temoin_epouse             = (string) ($m->age_temoin_epouse   ?? '');
        $this->edit_ref_piece_temoin_epouse       = $m->ref_piece_temoin_epouse       ?? '';
        $this->edit_profession_temoin_epouse      = $m->profession_temoin_epouse      ?? '';
        $this->edit_domicile_temoin_epouse        = $m->domicile_temoin_epouse        ?? '';
        $this->edit_date_naissance_temoin_epouse  = $df($m->date_naissance_temoin_epouse);
        $this->edit_lieu_naissance_temoin_epouse  = $m->lieu_naissance_temoin_epouse  ?? '';
        $this->edit_plus_info_temoin_epouse       = $m->plus_info_temoin_epouse       ?? '';
        $this->edit_officier_etat_civil_origin_epoux  = $m->officier_etat_civil_origin_epoux  ?? '';
        $this->edit_centre_etat_civil_origin_epoux    = $m->centre_etat_civil_origin_epoux    ?? '';
        $this->edit_officier_etat_civil_origin_epouse = $m->officier_etat_civil_origin_epouse ?? '';
        $this->edit_centre_etat_civil_origin_epouse   = $m->centre_etat_civil_origin_epouse   ?? '';

        $this->editMode = true;
    }

    public function cancelEdit(): void
    {
        $this->editMode = false;
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // VALIDATION PAR ÉTAPE
    // ═══════════════════════════════════════════════════════

    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'commune_id'           => 'required|exists:communes,id',
                'numero_act_mariage'   => 'required|string|max:50',
                'date_mariage'         => 'required|date',
                'annee_registre_mariage' => 'required|integer|min:1900',
            ],
            2 => [
                'nom_epoux'   => 'required|string|max:100',
                'prenom_epoux'=> 'required|string|max:100',
            ],
            3 => [
                'nom_epouse'   => 'required|string|max:100',
                'prenom_epouse'=> 'required|string|max:100',
            ],
            default => [],
        };
    }

    protected function messagesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'commune_id.required'           => 'La commune est obligatoire.',
                'numero_act_mariage.required'   => 'Le numéro d\'acte est obligatoire.',
                'date_mariage.required'         => 'La date de mariage est obligatoire.',
                'annee_registre_mariage.required'=> 'L\'année du registre est obligatoire.',
            ],
            2 => [
                'nom_epoux.required'   => 'Le nom de l\'époux est obligatoire.',
                'prenom_epoux.required'=> 'Le prénom de l\'époux est obligatoire.',
            ],
            3 => [
                'nom_epouse.required'   => 'Le nom de l\'épouse est obligatoire.',
                'prenom_epouse.required'=> 'Le prénom de l\'épouse est obligatoire.',
            ],
            default => [],
        };
    }

    // ═══════════════════════════════════════════════════════
    // NAVIGATION ÉTAPES
    // ═══════════════════════════════════════════════════════

    public function nextStep(): void
    {
        $rules = $this->rulesForStep($this->step);
        if (! empty($rules)) {
            $this->validate($rules, $this->messagesForStep($this->step));
        }
        if ($this->step < $this->maxSteps) {
            $this->step++;
            $this->resetErrorBag();
        }
    }

    public function prevStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
            $this->resetErrorBag();
        }
    }

    public function goToStep(int $s): void
    {
        if ($s >= 1 && $s < $this->step) {
            $this->step = $s;
            $this->resetErrorBag();
        }
    }

    public function stepLabel(int $step): string
    {
        return match ($step) {
            1 => 'Registre',
            2 => 'Époux',
            3 => 'Épouse',
            4 => 'Témoin ♂',
            5 => 'Témoin ♀',
            6 => 'Officiers',
            default => '',
        };
    }

    // ═══════════════════════════════════════════════════════
    // SAUVEGARDE (CRÉATION)
    // ═══════════════════════════════════════════════════════

    private function buildData(string $prefix = ''): array
    {
        $p = $prefix;
        $s = fn(string $f) => $this->{$p . $f} ?: null;
        $i = fn(string $f) => $this->{$p . $f} ? (int) $this->{$p . $f} : null;

        return [
            'commune_id'                       => $s('commune_id'),
            'annee_encours'                    => $s('annee_encours'),
            'annee_registre_mariage'           => $s('annee_registre_mariage'),
            'numero_act_mariage'               => $s('numero_act_mariage'),
            'numero_complet_act_mariage'       => $s('numero_complet_act_mariage'),
            'date_mariage'                     => $s('date_mariage'),
            'date_mariage_lettre'              => $s('date_mariage_lettre'),
            'heure_min_mariage'                => $s('heure_min_mariage'),
            'lieu_mariage'                     => $s('lieu_mariage'),
            'regime_matrimonial'               => $s('regime_matrimonial'),
            'date_dessage'                     => $s('date_dessage'),
            'date_dreesage_copie_integrale'    => $s('date_dreesage_copie_integrale'),
            'officier_etat_civil_mariage'      => $s('officier_etat_civil_mariage'),
            'qualite_officier'                 => $s('qualite_officier'),
            'nom_epoux'                        => strtoupper($this->{$p.'nom_epoux'}  ?? '') ?: null,
            'prenom_epoux'                     => $s('prenom_epoux'),
            'date_naissance_lettre_epoux'      => $s('date_naissance_lettre_epoux'),
            'date_naissance_epoux'             => $s('date_naissance_epoux'),
            'lieu_naissance_epoux'             => $s('lieu_naissance_epoux'),
            'ref_extrai_epoux'                 => $s('ref_extrai_epoux'),
            'ref_piece_epoux'                  => $s('ref_piece_epoux'),
            'profession_epoux'                 => $s('profession_epoux'),
            'nom_prenom_pere_epoux'            => strtoupper($this->{$p.'nom_prenom_pere_epoux'} ?? '') ?: null,
            'nom_prenom_mere_epoux'            => strtoupper($this->{$p.'nom_prenom_mere_epoux'} ?? '') ?: null,
            'domicile_pere'                    => $s('domicile_pere'),
            'statut_matrimo_epoux'             => $s('statut_matrimo_epoux'),
            'nom_epouse'                       => strtoupper($this->{$p.'nom_epouse'} ?? '') ?: null,
            'prenom_epouse'                    => $s('prenom_epouse'),
            'date_naissance_lettre_epouse'     => $s('date_naissance_lettre_epouse'),
            'date_naissance_epouse'            => $s('date_naissance_epouse'),
            'lieu_naissance_epouse'            => $s('lieu_naissance_epouse'),
            'ref_extrai_epouse'                => $s('ref_extrai_epouse'),
            'ref_piece_epouse'                 => $s('ref_piece_epouse'),
            'profession_epouse'                => $s('profession_epouse'),
            'nom_prenom_pere_epouse'           => strtoupper($this->{$p.'nom_prenom_pere_epouse'} ?? '') ?: null,
            'nom_prenom_mere_epouse'           => strtoupper($this->{$p.'nom_prenom_mere_epouse'} ?? '') ?: null,
            'domicile_mere'                    => $s('domicile_mere'),
            'statut_matrimo_epouse'            => $s('statut_matrimo_epouse'),
            'nom_prenom_temoin_epoux'          => $s('nom_prenom_temoin_epoux'),
            'age_temoin_epoux'                 => $i('age_temoin_epoux'),
            'ref_piece_temoin_epoux'           => $s('ref_piece_temoin_epoux'),
            'profession_temoin_epoux'          => $s('profession_temoin_epoux'),
            'domicile_temoin_epoux'            => $s('domicile_temoin_epoux'),
            'date_naissance_temoin_epoux'      => $s('date_naissance_temoin_epoux'),
            'lieu_naissance_temoin_epoux'      => $s('lieu_naissance_temoin_epoux'),
            'plus_info_temoin_epoux'           => $s('plus_info_temoin_epoux'),
            'nom_prenom_temoin_epouse'         => $s('nom_prenom_temoin_epouse'),
            'age_temoin_epouse'                => $i('age_temoin_epouse'),
            'ref_piece_temoin_epouse'          => $s('ref_piece_temoin_epouse'),
            'profession_temoin_epouse'         => $s('profession_temoin_epouse'),
            'domicile_temoin_epouse'           => $s('domicile_temoin_epouse'),
            'date_naissance_temoin_epouse'     => $s('date_naissance_temoin_epouse'),
            'lieu_naissance_temoin_epouse'     => $s('lieu_naissance_temoin_epouse'),
            'plus_info_temoin_epouse'          => $s('plus_info_temoin_epouse'),
            'officier_etat_civil_origin_epoux' => $s('officier_etat_civil_origin_epoux'),
            'centre_etat_civil_origin_epoux'   => $s('centre_etat_civil_origin_epoux'),
            'officier_etat_civil_origin_epouse'=> $s('officier_etat_civil_origin_epouse'),
            'centre_etat_civil_origin_epouse'  => $s('centre_etat_civil_origin_epouse'),
        ];
    }

    public function save(): void
    {
        $label = strtoupper($this->nom_epoux) . ' & ' . strtoupper($this->nom_epouse);

        try {
            Mariage::create($this->buildData());
        } catch (\Throwable $e) {
            Log::error('Erreur création mariage', ['message' => $e->getMessage()]);
            session()->flash('error', "Une erreur est survenue. Veuillez réessayer.");
            return;
        }

        $this->closeModal();
        session()->flash('success', "L'acte de mariage de {$label} a été enregistré.");
    }

    // ═══════════════════════════════════════════════════════
    // MISE À JOUR
    // ═══════════════════════════════════════════════════════

    public function update(): void
    {
        $m = $this->selectedMariage;
        if (! $m) return;

        $rules = [
            'edit_commune_id'          => 'required|exists:communes,id',
            'edit_numero_act_mariage'  => 'required|string|max:50',
            'edit_date_mariage'        => 'required|date',
            'edit_nom_epoux'           => 'required|string|max:100',
            'edit_nom_epouse'          => 'required|string|max:100',
        ];
        $this->validate($rules, [
            'edit_commune_id.required'         => 'La commune est obligatoire.',
            'edit_numero_act_mariage.required' => 'Le numéro d\'acte est obligatoire.',
            'edit_date_mariage.required'       => 'La date de mariage est obligatoire.',
            'edit_nom_epoux.required'          => 'Le nom de l\'époux est obligatoire.',
            'edit_nom_epouse.required'         => 'Le nom de l\'épouse est obligatoire.',
        ]);

        $m->update($this->buildData('edit_'));

        $this->editMode = false;
        $this->resetErrorBag();
        session()->flash('success', "L'acte de mariage a été mis à jour.");
        $this->closeFicheModal();
    }

    // ═══════════════════════════════════════════════════════
    // SUPPRESSION
    // ═══════════════════════════════════════════════════════

    public function confirmDelete(): void
    {
        $m = $this->selectedMariage;
        if (! $m) return;
        $label = strtoupper($m->nom_epoux ?? '') . ' & ' . strtoupper($m->nom_epouse ?? '');
        $m->delete();
        $this->closeFicheModal();
        session()->flash('success', "L'acte de {$label} a été supprimé.");
    }

    // ═══════════════════════════════════════════════════════
    // HELPERS
    // ═══════════════════════════════════════════════════════

    public function updatedSearch(): void        { $this->resetPage(); }
    public function updatedFiltreCommune(): void { $this->resetPage(); }
    public function updatedFiltreAnnee(): void   { $this->resetPage(); }

    // ═══════════════════════════════════════════════════════
    // RENDU
    // ═══════════════════════════════════════════════════════

    public function render(): \Illuminate\View\View
    {
        $mariages = Mariage::with(['commune'])
            ->when($this->search, fn ($q) =>
                $q->where('nom_epoux',  'like', "%{$this->search}%")
                  ->orWhere('nom_epouse', 'like', "%{$this->search}%")
                  ->orWhere('prenom_epoux',  'like', "%{$this->search}%")
                  ->orWhere('prenom_epouse', 'like', "%{$this->search}%")
                  ->orWhere('numero_act_mariage', 'like', "%{$this->search}%")
            )
            ->when($this->filtre_commune, fn ($q) => $q->where('commune_id', $this->filtre_commune))
            ->when($this->filtre_annee,   fn ($q) => $q->where('annee_registre_mariage', $this->filtre_annee))
            ->latest('date_mariage')
            ->paginate(12);

        $communes = Commune::orderBy('nom_commune')->get();

        $selectedMariage = $this->selectedId
            ? Mariage::with('commune')->find($this->selectedId)
            : null;

        return view('livewire.etat-civils.create-mariage', [
            'mariages'        => $mariages,
            'communes'        => $communes,
            'selectedMariage' => $selectedMariage,
        ]);
    }

    // Getter simple utilisable dans render ou en dehors
    public function getSelectedMariageProperty(): ?Mariage
    {
        return $this->selectedId ? Mariage::with('commune')->find($this->selectedId) : null;
    }
}
