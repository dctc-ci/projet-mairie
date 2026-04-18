<?php

namespace App\Livewire\EtatCivils;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EtatCivil\Autredeclaration;
use App\Models\Personnel\Commune;
use Illuminate\Support\Facades\Log;

class CreateAutreDeclaration extends Component
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
    // NAVIGATION — 3 ÉTAPES
    // ═══════════════════════════════════════════════════════

    public int $step     = 1;
    public int $maxSteps = 3;

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 1 — Commune & Registre
    // ═══════════════════════════════════════════════════════

    public string $commune_id           = '';
    public string $annee_registre_autre = '';
    public string $numero_registe_autre = '';
    public string $numero_act_autre     = '';
    public string $date_dressage_autre  = '';
    public string $heure_autre          = '';
    public string $date_lettre_autre    = '';
    public string $officier_etat_civil_autre = '';
    public string $qualite_etat_civil_autre  = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 2 — Déclarant
    // ═══════════════════════════════════════════════════════

    public string $civilite        = '';
    public string $nom_prenom_autre = '';
    public string $profession_autre = '';
    public string $domicile_autre   = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 3 — Acte
    // ═══════════════════════════════════════════════════════

    public string $act_autre               = '';
    public string $concernant_autre        = '';
    public string $info_complet_rapport_act = '';

    // ═══════════════════════════════════════════════════════
    // CHAMPS ÉDITION
    // ═══════════════════════════════════════════════════════

    public string $edit_commune_id                = '';
    public string $edit_annee_registre_autre      = '';
    public string $edit_numero_registe_autre      = '';
    public string $edit_numero_act_autre          = '';
    public string $edit_date_dressage_autre       = '';
    public string $edit_heure_autre               = '';
    public string $edit_date_lettre_autre         = '';
    public string $edit_officier_etat_civil_autre = '';
    public string $edit_qualite_etat_civil_autre  = '';
    public string $edit_civilite                  = '';
    public string $edit_nom_prenom_autre          = '';
    public string $edit_profession_autre          = '';
    public string $edit_domicile_autre            = '';
    public string $edit_act_autre                 = '';
    public string $edit_concernant_autre          = '';
    public string $edit_info_complet_rapport_act  = '';

    // ═══════════════════════════════════════════════════════
    // FILTRES
    // ═══════════════════════════════════════════════════════

    public string $search         = '';
    public string $filtre_commune = '';
    public string $filtre_annee   = '';

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
        $this->step                     = 1;
        $this->commune_id               = '';
        $this->annee_registre_autre     = (string) date('Y');
        $this->numero_registe_autre     = '';
        $this->numero_act_autre         = '';
        $this->date_dressage_autre      = '';
        $this->heure_autre              = '';
        $this->date_lettre_autre        = '';
        $this->officier_etat_civil_autre= '';
        $this->qualite_etat_civil_autre = '';
        $this->civilite                 = '';
        $this->nom_prenom_autre         = '';
        $this->profession_autre         = '';
        $this->domicile_autre           = '';
        $this->act_autre                = '';
        $this->concernant_autre         = '';
        $this->info_complet_rapport_act = '';
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
        $a = $this->selectedDeclaration;
        if (! $a) return;

        $df = fn($v) => $v ? \Carbon\Carbon::parse($v)->format('Y-m-d') : '';

        $this->edit_commune_id                = (string) ($a->commune_id ?? '');
        $this->edit_annee_registre_autre      = (string) ($a->annee_registre_autre ?? '');
        $this->edit_numero_registe_autre      = $a->numero_registe_autre      ?? '';
        $this->edit_numero_act_autre          = $a->numero_act_autre          ?? '';
        $this->edit_date_dressage_autre       = $df($a->date_dressage_autre);
        $this->edit_heure_autre               = $a->heure_autre               ?? '';
        $this->edit_date_lettre_autre         = $a->date_lettre_autre         ?? '';
        $this->edit_officier_etat_civil_autre = $a->officier_etat_civil_autre ?? '';
        $this->edit_qualite_etat_civil_autre  = $a->qualite_etat_civil_autre  ?? '';
        $this->edit_civilite                  = $a->civilite                  ?? '';
        $this->edit_nom_prenom_autre          = $a->nom_prenom_autre          ?? '';
        $this->edit_profession_autre          = $a->profession_autre          ?? '';
        $this->edit_domicile_autre            = $a->domicile_autre            ?? '';
        $this->edit_act_autre                 = $a->act_autre                 ?? '';
        $this->edit_concernant_autre          = $a->concernant_autre          ?? '';
        $this->edit_info_complet_rapport_act  = $a->info_complet_rapport_act  ?? '';

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
                'commune_id'       => 'required|exists:communes,id',
                'numero_act_autre' => 'required|string|max:50',
                'annee_registre_autre' => 'required|integer|min:1900',
            ],
            2 => [
                'nom_prenom_autre' => 'required|string|max:150',
            ],
            default => [],
        };
    }

    protected function messagesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'commune_id.required'           => 'La commune est obligatoire.',
                'numero_act_autre.required'     => 'Le numéro d\'acte est obligatoire.',
                'annee_registre_autre.required' => 'L\'année est obligatoire.',
            ],
            2 => [
                'nom_prenom_autre.required' => 'Le nom du déclarant est obligatoire.',
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
            2 => 'Déclarant',
            3 => 'Acte',
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
            'commune_id'                => $s('commune_id'),
            'annee_registre_autre'      => $s('annee_registre_autre'),
            'numero_registe_autre'      => $s('numero_registe_autre'),
            'numero_act_autre'          => $s('numero_act_autre'),
            'date_dressage_autre'       => $s('date_dressage_autre'),
            'heure_autre'               => $s('heure_autre'),
            'date_lettre_autre'         => $s('date_lettre_autre'),
            'officier_etat_civil_autre' => $s('officier_etat_civil_autre'),
            'qualite_etat_civil_autre'  => $s('qualite_etat_civil_autre'),
            'civilite'                  => $s('civilite'),
            'nom_prenom_autre'          => strtoupper($this->{$p.'nom_prenom_autre'} ?? '') ?: null,
            'profession_autre'          => $s('profession_autre'),
            'domicile_autre'            => $s('domicile_autre'),
            'act_autre'                 => $s('act_autre'),
            'concernant_autre'          => $s('concernant_autre'),
            'info_complet_rapport_act'  => $s('info_complet_rapport_act'),
        ];
    }

    // ═══════════════════════════════════════════════════════
    // SAUVEGARDE
    // ═══════════════════════════════════════════════════════

    public function save(): void
    {
        $label = trim(($this->civilite ? $this->civilite . ' ' : '') . strtoupper($this->nom_prenom_autre));

        try {
            Autredeclaration::create($this->buildData());
        } catch (\Throwable $e) {
            Log::error('Erreur création autre déclaration', ['message' => $e->getMessage()]);
            session()->flash('error', "Une erreur est survenue. Veuillez réessayer.");
            return;
        }

        $this->closeModal();
        session()->flash('success', "La déclaration de {$label} a été enregistrée.");
    }

    // ═══════════════════════════════════════════════════════
    // MISE À JOUR
    // ═══════════════════════════════════════════════════════

    public function update(): void
    {
        $a = $this->selectedDeclaration;
        if (! $a) return;

        $this->validate([
            'edit_commune_id'       => 'required|exists:communes,id',
            'edit_numero_act_autre' => 'required|string|max:50',
            'edit_nom_prenom_autre' => 'required|string|max:150',
        ], [
            'edit_commune_id.required'       => 'La commune est obligatoire.',
            'edit_numero_act_autre.required' => 'Le numéro d\'acte est obligatoire.',
            'edit_nom_prenom_autre.required' => 'Le nom du déclarant est obligatoire.',
        ]);

        $a->update($this->buildData('edit_'));

        $this->editMode = false;
        $this->resetErrorBag();
        session()->flash('success', "La déclaration a été mise à jour.");
        $this->closeFicheModal();
    }

    // ═══════════════════════════════════════════════════════
    // SUPPRESSION
    // ═══════════════════════════════════════════════════════

    public function confirmDelete(): void
    {
        $a = $this->selectedDeclaration;
        if (! $a) return;
        $label = strtoupper($a->nom_prenom_autre ?? '');
        $a->delete();
        $this->closeFicheModal();
        session()->flash('success', "La déclaration de {$label} a été supprimée.");
    }

    // ═══════════════════════════════════════════════════════
    // RENDU
    // ═══════════════════════════════════════════════════════

    public function render(): \Illuminate\View\View
    {
        $declarations = Autredeclaration::with(['commune'])
            ->when($this->search, fn ($q) =>
                $q->where('nom_prenom_autre',  'like', "%{$this->search}%")
                  ->orWhere('numero_act_autre', 'like', "%{$this->search}%")
                  ->orWhere('act_autre',        'like', "%{$this->search}%")
                  ->orWhere('concernant_autre', 'like', "%{$this->search}%")
            )
            ->when($this->filtre_commune, fn ($q) => $q->where('commune_id', $this->filtre_commune))
            ->when($this->filtre_annee,   fn ($q) => $q->where('annee_registre_autre', $this->filtre_annee))
            ->latest('date_dressage_autre')
            ->paginate(12);

        $communes = Commune::orderBy('nom_commune')->get();

        $selectedDeclaration = $this->selectedId
            ? Autredeclaration::with('commune')->find($this->selectedId)
            : null;

        return view('livewire.etat-civils.create-autre-declaration', [
            'declarations'        => $declarations,
            'communes'            => $communes,
            'selectedDeclaration' => $selectedDeclaration,
        ]);
    }

    public function getSelectedDeclarationProperty(): ?Autredeclaration
    {
        return $this->selectedId
            ? Autredeclaration::with('commune')->find($this->selectedId)
            : null;
    }
}
