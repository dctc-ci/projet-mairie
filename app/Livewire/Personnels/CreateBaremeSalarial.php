<?php

namespace App\Livewire\Personnels;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\Personnel\BaremeSalarial;
use Illuminate\Support\Facades\Log;

class CreateBaremeSalarial extends Component
{
    use WithPagination;

    // ═══════════════════════════════════════════════════════
    // ÉTAT DES MODALS
    // ═══════════════════════════════════════════════════════

    public bool $showModal     = false;
    public bool $showFicheModal = false;
    public bool $editMode       = false;
    public ?int $selectedId     = null;

    // ═══════════════════════════════════════════════════════
    // CHAMPS FORMULAIRE CRÉATION
    // ═══════════════════════════════════════════════════════

    public string $categorie       = '';
    public string $echelon         = '';
    public string $indice          = '';
    public string $salaire_base    = '';
    public string $salaire_brut    = '';
    public string $indem_residence = '';

    // ═══════════════════════════════════════════════════════
    // CHAMPS ÉDITION
    // ═══════════════════════════════════════════════════════

    public string $edit_categorie       = '';
    public string $edit_echelon         = '';
    public string $edit_indice          = '';
    public string $edit_salaire_base    = '';
    public string $edit_salaire_brut    = '';
    public string $edit_indem_residence = '';

    // ═══════════════════════════════════════════════════════
    // RECHERCHE / FILTRE TABLE
    // ═══════════════════════════════════════════════════════

    public string $search    = '';
    public string $filtre_categorie = '';

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
        $this->categorie       = '';
        $this->echelon         = '';
        $this->indice          = '';
        $this->salaire_base    = '';
        $this->salaire_brut    = '';
        $this->indem_residence = '';
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // GESTION MODAL FICHE (consultation + édition)
    // ═══════════════════════════════════════════════════════

    public function viewFiche(int $id): void
    {
        $this->selectedId = $id;
        $this->editMode   = false;
        $this->resetErrorBag();
        $this->showFicheModal = true;
    }

    #[Computed]
    public function selectedBareme(): ?BaremeSalarial
    {
        return $this->selectedId ? BaremeSalarial::find($this->selectedId) : null;
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
        $b = $this->selectedBareme;
        if (! $b) return;

        $this->edit_categorie       = $b->categorie;
        $this->edit_echelon         = $b->echelon;
        $this->edit_indice          = (string) $b->indice;
        $this->edit_salaire_base    = (string) $b->salaire_base;
        $this->edit_salaire_brut    = (string) $b->salaire_brut;
        $this->edit_indem_residence = (string) $b->indem_residence;

        $this->editMode = true;
    }

    public function cancelEdit(): void
    {
        $this->editMode = false;
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // VALIDATION
    // ═══════════════════════════════════════════════════════

    protected function rules(): array
    {
        return [
            'categorie'       => 'required|string|max:50',
            'echelon'         => 'required|string|max:50',
            'indice'          => 'required|integer|min:1',
            'salaire_base'    => 'required|numeric|min:0',
            'salaire_brut'    => 'required|numeric|min:0|gte:salaire_base',
            'indem_residence' => 'nullable|numeric|min:0',
        ];
    }

    protected function messages(): array
    {
        return [
            'categorie.required'       => 'La catégorie est obligatoire.',
            'echelon.required'         => "L'échelon est obligatoire.",
            'indice.required'          => "L'indice est obligatoire.",
            'indice.integer'           => "L'indice doit être un nombre entier.",
            'indice.min'               => "L'indice doit être positif.",
            'salaire_base.required'    => 'Le salaire de base est obligatoire.',
            'salaire_base.numeric'     => 'Le salaire de base doit être un nombre.',
            'salaire_brut.required'    => 'Le salaire brut est obligatoire.',
            'salaire_brut.gte'         => 'Le salaire brut ne peut pas être inférieur au salaire de base.',
            'indem_residence.numeric'  => "L'indemnité de résidence doit être un nombre.",
        ];
    }

    // ═══════════════════════════════════════════════════════
    // SAUVEGARDE (CRÉATION)
    // ═══════════════════════════════════════════════════════

    public function save(): void
    {
        $this->validate($this->rules(), $this->messages());

        try {
            BaremeSalarial::create([
                'categorie'       => strtoupper(trim($this->categorie)),
                'echelon'         => strtoupper(trim($this->echelon)),
                'indice'          => (int) $this->indice,
                'salaire_base'    => (float) $this->salaire_base,
                'salaire_brut'    => (float) $this->salaire_brut,
                'indem_residence' => (float) ($this->indem_residence ?: 0),
            ]);
        } catch (\Throwable $e) {
            Log::error('Erreur création barème', ['message' => $e->getMessage()]);
            session()->flash('error', "Une erreur est survenue. Veuillez réessayer.");
            return;
        }

        $this->closeModal();
        session()->flash('success', "Le barème {$this->categorie} — Échelon {$this->echelon} a été créé.");
    }

    // ═══════════════════════════════════════════════════════
    // MISE À JOUR (ÉDITION)
    // ═══════════════════════════════════════════════════════

    public function update(): void
    {
        $b = $this->selectedBareme;
        if (! $b) return;

        $this->validate([
            'edit_categorie'       => 'required|string|max:50',
            'edit_echelon'         => 'required|string|max:50',
            'edit_indice'          => 'required|integer|min:1',
            'edit_salaire_base'    => 'required|numeric|min:0',
            'edit_salaire_brut'    => 'required|numeric|min:0',
            'edit_indem_residence' => 'nullable|numeric|min:0',
        ], [
            'edit_categorie.required'    => 'La catégorie est obligatoire.',
            'edit_echelon.required'      => "L'échelon est obligatoire.",
            'edit_indice.required'       => "L'indice est obligatoire.",
            'edit_salaire_base.required' => 'Le salaire de base est obligatoire.',
            'edit_salaire_brut.required' => 'Le salaire brut est obligatoire.',
        ]);

        $b->update([
            'categorie'       => strtoupper(trim($this->edit_categorie)),
            'echelon'         => strtoupper(trim($this->edit_echelon)),
            'indice'          => (int) $this->edit_indice,
            'salaire_base'    => (float) $this->edit_salaire_base,
            'salaire_brut'    => (float) $this->edit_salaire_brut,
            'indem_residence' => (float) ($this->edit_indem_residence ?: 0),
        ]);

        $this->editMode = false;
        $this->resetErrorBag();
        session()->flash('success', "Le barème a été mis à jour.");
        $this->closeFicheModal();
    }

    // ═══════════════════════════════════════════════════════
    // SUPPRESSION
    // ═══════════════════════════════════════════════════════

    public function confirmDelete(): void
    {
        $b = $this->selectedBareme;
        if (! $b) return;

        $label = "{$b->categorie} — Échelon {$b->echelon}";

        try {
            $b->delete();
        } catch (\Throwable $e) {
            // Contrainte FK : des agents utilisent ce barème
            session()->flash('error', "Impossible de supprimer ce barème car des agents y sont rattachés.");
            return;
        }

        $this->closeFicheModal();
        session()->flash('success', "Le barème {$label} a été supprimé.");
    }

    // ═══════════════════════════════════════════════════════
    // RESET PAGINATION si filtre change
    // ═══════════════════════════════════════════════════════

    public function updatedSearch(): void        { $this->resetPage(); }
    public function updatedFiltreCategorie(): void { $this->resetPage(); }

    // ═══════════════════════════════════════════════════════
    // HELPER — catégories distinctes pour le filtre
    // ═══════════════════════════════════════════════════════

    #[Computed]
    public function categories(): \Illuminate\Support\Collection
    {
        return BaremeSalarial::select('categorie')
                              ->distinct()
                              ->orderBy('categorie')
                              ->pluck('categorie');
    }

    // ═══════════════════════════════════════════════════════
    // RENDU
    // ═══════════════════════════════════════════════════════

    public function render(): \Illuminate\View\View
    {
        $baremes = BaremeSalarial::query()
            ->when($this->search, fn ($q) =>
                $q->where('categorie', 'like', "%{$this->search}%")
                  ->orWhere('echelon',  'like', "%{$this->search}%")
            )
            ->when($this->filtre_categorie, fn ($q) =>
                $q->where('categorie', $this->filtre_categorie)
            )
            ->orderBy('categorie')
            ->orderBy('echelon')
            ->paginate(12);

        return view('livewire.personnels.create-bareme-salarial', [
            'baremes' => $baremes,
        ]);
    }
}
