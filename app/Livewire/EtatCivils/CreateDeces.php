<?php

namespace App\Livewire\EtatCivils;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\EtatCivil\Deces;
use App\Models\Personnel\Commune;
use Illuminate\Support\Facades\Log;

class CreateDeces extends Component
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
    // NAVIGATION — 4 ÉTAPES
    // ═══════════════════════════════════════════════════════

    public int $step     = 1;
    public int $maxSteps = 4;

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 1 — Commune & Registre
    // ═══════════════════════════════════════════════════════

    public string $commune_id               = '';
    public string $annee_registre_deces     = '';
    public string $numero_registre_deces    = '';
    public string $numero_act_deces         = '';
    public string $nature_declarat_deces    = '';
    public string $ment_jugem_supplet       = '';
    public string $date_dessage_deces       = '';
    public string $date_dessage_copi_integral_deces = '';
    public string $heure_dressage_deces     = '';
    public string $nous_avons_signe_deces   = '';
    public string $officier_etat_civil_deces = '';
    public string $qualite_etat_civil_deces = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 2 — Le décès
    // ═══════════════════════════════════════════════════════

    public string $date_deces      = '';
    public string $lieu_deces      = '';
    public string $heure_min_deces = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 3 — Le défunt
    // ═══════════════════════════════════════════════════════

    public string $sexe_deces               = '';
    public string $fils_fille_deces         = '';
    public string $nom_defunt               = '';
    public string $prenom_defunt            = '';
    public string $date_naissance_defunt    = '';
    public string $lieu_naissance_defunt    = '';
    public string $profession_defunt        = '';
    public string $situa_familial_defunt    = '';
    public string $nom_prenom_epoux_defunt  = '';
    public string $nom_prenom_pere_defunt   = '';
    public string $domicile_pere_defunt     = '';
    public string $nom_prenom_mere_defunt   = '';
    public string $domicile_mere_defunt     = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 4 — Déclarant & Officier d'origine
    // ═══════════════════════════════════════════════════════

    public string $info_declarant                   = '';
    public string $langue_declarant                 = '';
    public string $nom_prenom_interprete            = '';
    public string $officier_etat_civil_origin_defunt = '';
    public string $centre_etat_civil_origin_defunt  = '';

    // ═══════════════════════════════════════════════════════
    // CHAMPS ÉDITION
    // ═══════════════════════════════════════════════════════

    public string $edit_commune_id                       = '';
    public string $edit_annee_registre_deces             = '';
    public string $edit_numero_registre_deces            = '';
    public string $edit_numero_act_deces                 = '';
    public string $edit_nature_declarat_deces            = '';
    public string $edit_ment_jugem_supplet               = '';
    public string $edit_date_dessage_deces               = '';
    public string $edit_date_dessage_copi_integral_deces = '';
    public string $edit_heure_dressage_deces             = '';
    public string $edit_nous_avons_signe_deces           = '';
    public string $edit_officier_etat_civil_deces        = '';
    public string $edit_qualite_etat_civil_deces         = '';
    public string $edit_date_deces                       = '';
    public string $edit_lieu_deces                       = '';
    public string $edit_heure_min_deces                  = '';
    public string $edit_sexe_deces                       = '';
    public string $edit_fils_fille_deces                 = '';
    public string $edit_nom_defunt                       = '';
    public string $edit_prenom_defunt                    = '';
    public string $edit_date_naissance_defunt            = '';
    public string $edit_lieu_naissance_defunt            = '';
    public string $edit_profession_defunt                = '';
    public string $edit_situa_familial_defunt            = '';
    public string $edit_nom_prenom_epoux_defunt          = '';
    public string $edit_nom_prenom_pere_defunt           = '';
    public string $edit_domicile_pere_defunt             = '';
    public string $edit_nom_prenom_mere_defunt           = '';
    public string $edit_domicile_mere_defunt             = '';
    public string $edit_info_declarant                   = '';
    public string $edit_langue_declarant                 = '';
    public string $edit_nom_prenom_interprete            = '';
    public string $edit_officier_etat_civil_origin_defunt = '';
    public string $edit_centre_etat_civil_origin_defunt  = '';

    // ═══════════════════════════════════════════════════════
    // FILTRES
    // ═══════════════════════════════════════════════════════

    public string $search         = '';
    public string $filtre_commune = '';
    public string $filtre_annee   = '';

    // ═══════════════════════════════════════════════════════
    // HOOKS
    // ═══════════════════════════════════════════════════════

    public function updatedSexeDeces(string $val): void
    {
        $this->fils_fille_deces = ($val === 'M') ? 'fils' : 'fille';
    }

    public function updatedEditSexeDeces(string $val): void
    {
        $this->edit_fils_fille_deces = ($val === 'M') ? 'fils' : 'fille';
    }

    public function updatedSearch(): void        { $this->resetPage(); }
    public function updatedFiltreCommune(): void { $this->resetPage(); }
    public function updatedFiltreAnnee(): void   { $this->resetPage(); }

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
        $this->step                              = 1;
        $this->commune_id                        = '';
        $this->annee_registre_deces              = (string) date('Y');
        $this->numero_registre_deces             = '';
        $this->numero_act_deces                  = '';
        $this->nature_declarat_deces             = '';
        $this->ment_jugem_supplet                = '';
        $this->date_dessage_deces                = '';
        $this->date_dessage_copi_integral_deces  = '';
        $this->heure_dressage_deces              = '';
        $this->nous_avons_signe_deces            = '';
        $this->officier_etat_civil_deces         = '';
        $this->qualite_etat_civil_deces          = '';
        $this->date_deces                        = '';
        $this->lieu_deces                        = '';
        $this->heure_min_deces                   = '';
        $this->sexe_deces                        = '';
        $this->fils_fille_deces                  = '';
        $this->nom_defunt                        = '';
        $this->prenom_defunt                     = '';
        $this->date_naissance_defunt             = '';
        $this->lieu_naissance_defunt             = '';
        $this->profession_defunt                 = '';
        $this->situa_familial_defunt             = '';
        $this->nom_prenom_epoux_defunt           = '';
        $this->nom_prenom_pere_defunt            = '';
        $this->domicile_pere_defunt              = '';
        $this->nom_prenom_mere_defunt            = '';
        $this->domicile_mere_defunt              = '';
        $this->info_declarant                    = '';
        $this->langue_declarant                  = '';
        $this->nom_prenom_interprete             = '';
        $this->officier_etat_civil_origin_defunt = '';
        $this->centre_etat_civil_origin_defunt   = '';
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
        $d = $this->selectedDeces;
        if (! $d) return;

        $df = fn($v) => $v ? \Carbon\Carbon::parse($v)->format('Y-m-d') : '';

        $this->edit_commune_id                       = (string) ($d->commune_id ?? '');
        $this->edit_annee_registre_deces             = (string) ($d->annee_registre_deces ?? '');
        $this->edit_numero_registre_deces            = $d->numero_registre_deces            ?? '';
        $this->edit_numero_act_deces                 = $d->numero_act_deces                 ?? '';
        $this->edit_nature_declarat_deces            = $d->nature_declarat_deces            ?? '';
        $this->edit_ment_jugem_supplet               = $d->ment_jugem_supplet               ?? '';
        $this->edit_date_dessage_deces               = $df($d->date_dessage_deces);
        $this->edit_date_dessage_copi_integral_deces = $df($d->date_dessage_copi_integral_deces);
        $this->edit_heure_dressage_deces             = $d->heure_dressage_deces             ?? '';
        $this->edit_nous_avons_signe_deces           = $d->nous_avons_signe_deces           ?? '';
        $this->edit_officier_etat_civil_deces        = $d->officier_etat_civil_deces        ?? '';
        $this->edit_qualite_etat_civil_deces         = $d->qualite_etat_civil_deces         ?? '';
        $this->edit_date_deces                       = $df($d->date_deces);
        $this->edit_lieu_deces                       = $d->lieu_deces                       ?? '';
        $this->edit_heure_min_deces                  = $d->heure_min_deces                  ?? '';
        $this->edit_sexe_deces                       = $d->sexe_deces                       ?? '';
        $this->edit_fils_fille_deces                 = $d->fils_fille_deces                 ?? '';
        $this->edit_nom_defunt                       = $d->nom_defunt                       ?? '';
        $this->edit_prenom_defunt                    = $d->prenom_defunt                    ?? '';
        $this->edit_date_naissance_defunt            = $df($d->date_naissance_defunt);
        $this->edit_lieu_naissance_defunt            = $d->lieu_naissance_defunt            ?? '';
        $this->edit_profession_defunt                = $d->profession_defunt                ?? '';
        $this->edit_situa_familial_defunt            = $d->situa_familial_defunt            ?? '';
        $this->edit_nom_prenom_epoux_defunt          = $d->nom_prenom_epoux_defunt          ?? '';
        $this->edit_nom_prenom_pere_defunt           = $d->nom_prenom_pere_defunt           ?? '';
        $this->edit_domicile_pere_defunt             = $d->domicile_pere_defunt             ?? '';
        $this->edit_nom_prenom_mere_defunt           = $d->nom_prenom_mere_defunt           ?? '';
        $this->edit_domicile_mere_defunt             = $d->domicile_mere_defunt             ?? '';
        $this->edit_info_declarant                   = $d->info_declarant                   ?? '';
        $this->edit_langue_declarant                 = $d->langue_declarant                 ?? '';
        $this->edit_nom_prenom_interprete            = $d->nom_prenom_interprete            ?? '';
        $this->edit_officier_etat_civil_origin_defunt = $d->officier_etat_civil_origin_defunt ?? '';
        $this->edit_centre_etat_civil_origin_defunt  = $d->centre_etat_civil_origin_defunt  ?? '';

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
                'commune_id'         => 'required|exists:communes,id',
                'numero_act_deces'   => 'required|string|max:50',
                'annee_registre_deces' => 'required|integer|min:1900',
            ],
            2 => [
                'date_deces' => 'required|date',
                'lieu_deces' => 'required|string|max:150',
            ],
            3 => [
                'nom_defunt'  => 'required|string|max:100',
                'sexe_deces'  => 'required|in:M,F',
            ],
            default => [],
        };
    }

    protected function messagesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'commune_id.required'           => 'La commune est obligatoire.',
                'numero_act_deces.required'     => 'Le numéro d\'acte est obligatoire.',
                'annee_registre_deces.required' => 'L\'année du registre est obligatoire.',
            ],
            2 => [
                'date_deces.required' => 'La date de décès est obligatoire.',
                'lieu_deces.required' => 'Le lieu de décès est obligatoire.',
            ],
            3 => [
                'nom_defunt.required' => 'Le nom du défunt est obligatoire.',
                'sexe_deces.required' => 'Le sexe est obligatoire.',
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
            2 => 'Le décès',
            3 => 'Le défunt',
            4 => 'Déclarant',
            default => '',
        };
    }

    // ═══════════════════════════════════════════════════════
    // CONSTRUCTION DES DONNÉES
    // ═══════════════════════════════════════════════════════

    private function buildData(string $p = ''): array
    {
        $s = fn(string $f) => $this->{$p . $f} ?: null;

        return [
            'commune_id'                          => $s('commune_id'),
            'annee_registre_deces'                => $s('annee_registre_deces'),
            'numero_registre_deces'               => $s('numero_registre_deces'),
            'numero_act_deces'                    => $s('numero_act_deces'),
            'nature_declarat_deces'               => $s('nature_declarat_deces'),
            'ment_jugem_supplet'                  => $s('ment_jugem_supplet'),
            'date_dessage_deces'                  => $s('date_dessage_deces'),
            'date_dessage_copi_integral_deces'    => $s('date_dessage_copi_integral_deces'),
            'heure_dressage_deces'                => $s('heure_dressage_deces'),
            'nous_avons_signe_deces'              => $s('nous_avons_signe_deces'),
            'officier_etat_civil_deces'           => $s('officier_etat_civil_deces'),
            'qualite_etat_civil_deces'            => $s('qualite_etat_civil_deces'),
            'date_deces'                          => $s('date_deces'),
            'lieu_deces'                          => $s('lieu_deces'),
            'heure_min_deces'                     => $s('heure_min_deces'),
            'sexe_deces'                          => $s('sexe_deces'),
            'fils_fille_deces'                    => $s('fils_fille_deces'),
            'nom_defunt'                          => strtoupper($this->{$p.'nom_defunt'}  ?? '') ?: null,
            'prenom_defunt'                       => $s('prenom_defunt'),
            'date_naissance_defunt'               => $s('date_naissance_defunt'),
            'lieu_naissance_defunt'               => $s('lieu_naissance_defunt'),
            'profession_defunt'                   => $s('profession_defunt'),
            'situa_familial_defunt'               => $s('situa_familial_defunt'),
            'nom_prenom_epoux_defunt'             => $s('nom_prenom_epoux_defunt'),
            'nom_prenom_pere_defunt'              => strtoupper($this->{$p.'nom_prenom_pere_defunt'} ?? '') ?: null,
            'domicile_pere_defunt'                => $s('domicile_pere_defunt'),
            'nom_prenom_mere_defunt'              => strtoupper($this->{$p.'nom_prenom_mere_defunt'} ?? '') ?: null,
            'domicile_mere_defunt'                => $s('domicile_mere_defunt'),
            'info_declarant'                      => $s('info_declarant'),
            'langue_declarant'                    => $s('langue_declarant'),
            'nom_prenom_interprete'               => $s('nom_prenom_interprete'),
            'officier_etat_civil_origin_defunt'   => $s('officier_etat_civil_origin_defunt'),
            'centre_etat_civil_origin_defunt'     => $s('centre_etat_civil_origin_defunt'),
        ];
    }

    // ═══════════════════════════════════════════════════════
    // SAUVEGARDE
    // ═══════════════════════════════════════════════════════

    public function save(): void
    {
        $label = strtoupper($this->nom_defunt) . ' ' . $this->prenom_defunt;
        try {
            Deces::create($this->buildData());
        } catch (\Throwable $e) {
            Log::error('Erreur création acte décès', ['message' => $e->getMessage()]);
            session()->flash('error', "Une erreur est survenue. Veuillez réessayer.");
            return;
        }
        $this->closeModal();
        session()->flash('success', "L'acte de décès de {$label} a été enregistré.");
    }

    // ═══════════════════════════════════════════════════════
    // MISE À JOUR
    // ═══════════════════════════════════════════════════════

    public function update(): void
    {
        $d = $this->selectedDeces;
        if (! $d) return;

        $this->validate([
            'edit_commune_id'       => 'required|exists:communes,id',
            'edit_numero_act_deces' => 'required|string|max:50',
            'edit_date_deces'       => 'required|date',
            'edit_lieu_deces'       => 'required|string|max:150',
            'edit_nom_defunt'       => 'required|string|max:100',
            'edit_sexe_deces'       => 'required|in:M,F',
        ], [
            'edit_commune_id.required'       => 'La commune est obligatoire.',
            'edit_numero_act_deces.required' => 'Le numéro d\'acte est obligatoire.',
            'edit_date_deces.required'       => 'La date de décès est obligatoire.',
            'edit_lieu_deces.required'       => 'Le lieu de décès est obligatoire.',
            'edit_nom_defunt.required'       => 'Le nom du défunt est obligatoire.',
            'edit_sexe_deces.required'       => 'Le sexe est obligatoire.',
        ]);

        $d->update($this->buildData('edit_'));

        $this->editMode = false;
        $this->resetErrorBag();
        session()->flash('success', "L'acte de décès a été mis à jour.");
        $this->closeFicheModal();
    }

    // ═══════════════════════════════════════════════════════
    // SUPPRESSION
    // ═══════════════════════════════════════════════════════

    public function confirmDelete(): void
    {
        $d = $this->selectedDeces;
        if (! $d) return;
        $label = strtoupper($d->nom_defunt ?? '') . ' ' . ($d->prenom_defunt ?? '');
        $d->delete();
        $this->closeFicheModal();
        session()->flash('success', "L'acte de décès de {$label} a été supprimé.");
    }

    // ═══════════════════════════════════════════════════════
    // RENDU
    // ═══════════════════════════════════════════════════════

    public function render(): \Illuminate\View\View
    {
        $deces = Deces::with(['commune'])
            ->when($this->search, fn ($q) =>
                $q->where('nom_defunt',   'like', "%{$this->search}%")
                  ->orWhere('prenom_defunt', 'like', "%{$this->search}%")
                  ->orWhere('numero_act_deces', 'like', "%{$this->search}%")
            )
            ->when($this->filtre_commune, fn ($q) => $q->where('commune_id', $this->filtre_commune))
            ->when($this->filtre_annee,   fn ($q) => $q->where('annee_registre_deces', $this->filtre_annee))
            ->latest('date_deces')
            ->paginate(12);

        $communes = Commune::orderBy('nom_commune')->get();

        $selectedDeces = $this->selectedId
            ? Deces::with('commune')->find($this->selectedId)
            : null;

        return view('livewire.etat-civils.create-deces', [
            'deces'         => $deces,
            'communes'      => $communes,
            'selectedDeces' => $selectedDeces,
        ]);
    }

    public function getSelectedDecesProperty(): ?Deces
    {
        return $this->selectedId ? Deces::with('commune')->find($this->selectedId) : null;
    }
}
