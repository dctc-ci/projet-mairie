<?php

namespace App\Livewire\Personnels;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Personnel\Agent;
use App\Models\Personnel\SituationFamiliale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateSituationFamiliale extends Component
{
    use WithPagination;

    // ═══════════════════════════════════════════════════════
    // ÉTAT DES MODALS
    // ═══════════════════════════════════════════════════════

    public bool $showModal       = false;
    public bool $showFicheModal  = false;
    public bool $editMode        = false;
    public ?int $selectedFicheId = null;

    // ═══════════════════════════════════════════════════════
    // NAVIGATION ÉTAPES (3 étapes)
    // ═══════════════════════════════════════════════════════

    public int $step     = 1;
    public int $maxSteps = 3;

    // ═══════════════════════════════════════════════════════
    // RECHERCHE AGENT PAR MATRICULE
    // ═══════════════════════════════════════════════════════

    public string $matricule_search    = '';
    public string $agent_nom_prenom    = '';   // affiché en lecture seule
    public ?int   $agent_id            = null;
    public string $agent_search_error  = '';
    public bool   $agent_found         = false;

    // ═══════════════════════════════════════════════════════
    // CHAMPS FORMULAIRE CRÉATION
    // ═══════════════════════════════════════════════════════

    // ─── ÉTAPE 1 : Pièce d'identité & Situation maritale ─
    public string $situation_mariale    = '';
    public string $nature_piece         = '';
    public string $numero_piece         = '';
    public string $date_etabli_piece    = '';

    // ─── ÉTAPE 2 : Conjoint ──────────────────────────────
    public string $nom_prenom_femme = '';
    public string $group_sangin     = '';
    public string $date_mariage     = '';
    public string $lieu_mariage     = '';

    // ─── ÉTAPE 3 : Enfants ───────────────────────────────
    // Liste des enfants (tableau d'arrays)
    public array $enfants = [];

    // Champs du formulaire temporaire pour un enfant en cours de saisie
    public string $enfant_nom_prenom      = '';
    public string $enfant_date_naissance  = '';
    public string $enfant_lieu_naissance  = '';
    public string $enfant_numero_extrait  = '';

    // ═══════════════════════════════════════════════════════
    // CHAMPS ÉDITION (préfixés edit_)
    // ═══════════════════════════════════════════════════════

    public string $edit_situation_mariale = '';
    public string $edit_nature_piece      = '';
    public string $edit_numero_piece      = '';
    public string $edit_date_etabli_piece = '';
    public string $edit_nom_prenom_femme  = '';
    public string $edit_group_sangin      = '';
    public string $edit_date_mariage      = '';
    public string $edit_lieu_mariage      = '';
    public array  $edit_enfants           = [];

    // Champs temp enfant en édition
    public string $edit_enfant_nom_prenom     = '';
    public string $edit_enfant_date_naissance = '';
    public string $edit_enfant_lieu_naissance = '';
    public string $edit_enfant_numero_extrait = '';

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
        $this->step                  = 1;
        $this->matricule_search      = '';
        $this->agent_nom_prenom      = '';
        $this->agent_id              = null;
        $this->agent_search_error    = '';
        $this->agent_found           = false;
        $this->situation_mariale     = '';
        $this->nature_piece          = '';
        $this->numero_piece          = '';
        $this->date_etabli_piece     = '';
        $this->nom_prenom_femme      = '';
        $this->group_sangin          = '';
        $this->date_mariage          = '';
        $this->lieu_mariage          = '';
        $this->enfants               = [];
        $this->resetEnfantTemp();
        $this->resetErrorBag();
    }

    private function resetEnfantTemp(): void
    {
        $this->enfant_nom_prenom     = '';
        $this->enfant_date_naissance = '';
        $this->enfant_lieu_naissance = '';
        $this->enfant_numero_extrait = '';
    }

    // ═══════════════════════════════════════════════════════
    // RECHERCHE AGENT PAR MATRICULE
    // ═══════════════════════════════════════════════════════

    /**
     * Déclenché quand l'utilisateur tape dans le champ matricule
     * et appuie sur "Rechercher" (ou via wire:click)
     */
    public function searchAgent(): void
    {
        $this->agent_search_error = '';
        $this->agent_found        = false;
        $this->agent_nom_prenom   = '';
        $this->agent_id           = null;

        $matricule = strtoupper(trim($this->matricule_search));

        if (empty($matricule)) {
            $this->agent_search_error = 'Veuillez saisir un matricule.';
            return;
        }

        $agent = Agent::where('matricule', $matricule)->first();

        if (! $agent) {
            $this->agent_search_error = "Aucun agent trouvé avec le matricule « {$matricule} ».";
            return;
        }

        // Vérifier si une situation familiale existe déjà pour cet agent
        $existeDeja = SituationFamiliale::where('agent_id', $agent->id)->exists();
        if ($existeDeja) {
            $this->agent_search_error = "Une situation familiale existe déjà pour {$agent->nom_prenom_agent}. Utilisez le bouton « Modifier » sur la fiche correspondante.";
            return;
        }

        $this->agent_id          = $agent->id;
        $this->agent_nom_prenom  = $agent->nom_prenom_agent;
        $this->agent_found       = true;
    }

    // ═══════════════════════════════════════════════════════
    // GESTION DES ENFANTS
    // ═══════════════════════════════════════════════════════

    /**
     * Ajoute l'enfant en cours de saisie à la liste $enfants
     */
    public function ajouterEnfant(): void
    {
        $this->validate([
            'enfant_nom_prenom'      => 'required|string|max:150',
            'enfant_date_naissance'  => 'nullable|date|before:today',
            'enfant_lieu_naissance'  => 'nullable|string|max:150',
            'enfant_numero_extrait'  => 'nullable|string|max:50',
        ], [
            'enfant_nom_prenom.required'   => "Le nom et prénom de l'enfant sont obligatoires.",
            'enfant_date_naissance.before' => "La date de naissance doit être dans le passé.",
        ]);

        $this->enfants[] = [
            'nom_prenom'      => trim($this->enfant_nom_prenom),
            'date_naissance'  => $this->enfant_date_naissance  ?: null,
            'lieu_naissance'  => $this->enfant_lieu_naissance  ?: null,
            'numero_extrait'  => $this->enfant_numero_extrait  ?: null,
        ];

        $this->resetEnfantTemp();
        $this->resetErrorBag();
    }

    public function supprimerEnfant(int $index): void
    {
        unset($this->enfants[$index]);
        $this->enfants = array_values($this->enfants); // réindexer
    }

    // ─── Version édition ─────────────────────────────────

    public function ajouterEnfantEdit(): void
    {
        $this->validate([
            'edit_enfant_nom_prenom'      => 'required|string|max:150',
            'edit_enfant_date_naissance'  => 'nullable|date|before:today',
            'edit_enfant_lieu_naissance'  => 'nullable|string|max:150',
            'edit_enfant_numero_extrait'  => 'nullable|string|max:50',
        ], [
            'edit_enfant_nom_prenom.required' => "Le nom et prénom de l'enfant sont obligatoires.",
        ]);

        $this->edit_enfants[] = [
            'nom_prenom'     => trim($this->edit_enfant_nom_prenom),
            'date_naissance' => $this->edit_enfant_date_naissance ?: null,
            'lieu_naissance' => $this->edit_enfant_lieu_naissance ?: null,
            'numero_extrait' => $this->edit_enfant_numero_extrait ?: null,
        ];

        $this->edit_enfant_nom_prenom     = '';
        $this->edit_enfant_date_naissance = '';
        $this->edit_enfant_lieu_naissance = '';
        $this->edit_enfant_numero_extrait = '';
        $this->resetErrorBag();
    }

    public function supprimerEnfantEdit(int $index): void
    {
        unset($this->edit_enfants[$index]);
        $this->edit_enfants = array_values($this->edit_enfants);
    }

    // ═══════════════════════════════════════════════════════
    // GESTION MODAL FICHE (consultation + édition)
    // ═══════════════════════════════════════════════════════

    public function viewFiche(int $id): void
    {
        $this->selectedFicheId = $id;
        $this->editMode        = false;
        $this->resetErrorBag();
        $this->showFicheModal  = true;
    }

    public function getSelectedFicheProperty(): ?SituationFamiliale
    {
        return $this->selectedFicheId
            ? SituationFamiliale::with('agent')->find($this->selectedFicheId)
            : null;
    }

    public function closeFicheModal(): void
    {
        $this->showFicheModal  = false;
        $this->editMode        = false;
        $this->selectedFicheId = null;
        $this->edit_enfants    = [];
        $this->resetErrorBag();
    }

    public function enableEditMode(): void
    {
        $fiche = $this->selectedFiche;
        if (! $fiche) return;

        $this->edit_situation_mariale = $fiche->situation_mariale ?? '';
        $this->edit_nature_piece      = $fiche->nature_piece      ?? '';
        $this->edit_numero_piece      = $fiche->numero_piece      ?? '';
        $this->edit_date_etabli_piece = $fiche->date_etabli_piece ?? '';
        $this->edit_nom_prenom_femme  = $fiche->nom_prenom_femme  ?? '';
        $this->edit_group_sangin      = $fiche->group_sangin      ?? '';
        $this->edit_date_mariage      = $fiche->date_mariage      ?? '';
        $this->edit_lieu_mariage      = $fiche->lieu_mariage      ?? '';
        $this->edit_enfants           = is_array($fiche->enfants) ? $fiche->enfants : (json_decode($fiche->enfants ?? '[]', true) ?? []);
        $this->edit_enfant_nom_prenom     = '';
        $this->edit_enfant_date_naissance = '';
        $this->edit_enfant_lieu_naissance = '';
        $this->edit_enfant_numero_extrait = '';

        $this->editMode = true;
    }

    public function cancelEdit(): void
    {
        $this->editMode = false;
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // RÈGLES DE VALIDATION PAR ÉTAPE
    // ═══════════════════════════════════════════════════════

    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'agent_id'           => 'required|integer|exists:agents,id',
                'situation_mariale'  => 'nullable|string|max:50',
                'nature_piece'       => 'nullable|string|max:100',
                'numero_piece'       => 'nullable|string|max:50',
                'date_etabli_piece'  => 'nullable|date',
            ],
            2 => [
                'nom_prenom_femme' => 'nullable|string|max:150',
                'group_sangin'     => 'nullable|string|max:10',
                'date_mariage'     => 'nullable|date',
                'lieu_mariage'     => 'nullable|string|max:150',
            ],
            3 => [], // La validation des enfants est gérée individuellement dans ajouterEnfant()
            default => [],
        };
    }

    protected function messagesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'agent_id.required' => 'Veuillez rechercher et sélectionner un agent avant de continuer.',
                'agent_id.exists'   => "L'agent sélectionné est invalide.",
            ],
            default => [],
        };
    }

    // ═══════════════════════════════════════════════════════
    // NAVIGATION ÉTAPES
    // ═══════════════════════════════════════════════════════

    public function nextStep(): void
    {
        $this->validate(
            $this->rulesForStep($this->step),
            $this->messagesForStep($this->step)
        );
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

    // ═══════════════════════════════════════════════════════
    // SAUVEGARDE EN BASE (CRÉATION)
    // ═══════════════════════════════════════════════════════

    public function save(): void
    {
        if (! $this->agent_id) {
            $this->addError('agent_id', 'Veuillez sélectionner un agent.');
            return;
        }

        $nomAgent = $this->agent_nom_prenom;

        try {
            DB::transaction(function () {
                SituationFamiliale::create([
                    'agent_id'           => $this->agent_id,
                    'situation_mariale'  => $this->situation_mariale  ?: null,
                    'nature_piece'       => $this->nature_piece        ?: null,
                    'numero_piece'       => $this->numero_piece        ?: null,
                    'date_etabli_piece'  => $this->date_etabli_piece   ?: null,
                    'nom_prenom_femme'   => $this->nom_prenom_femme    ?: null,
                    'group_sangin'       => $this->group_sangin         ?: null,
                    'date_mariage'       => $this->date_mariage         ?: null,
                    'lieu_mariage'       => $this->lieu_mariage         ?: null,
                    'enfants'            => ! empty($this->enfants) ? $this->enfants : null,
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('Erreur création situation familiale', ['message' => $e->getMessage()]);
            session()->flash('error', "Une erreur est survenue lors de l'enregistrement. Veuillez réessayer.");
            return;
        }

        $this->closeModal();
        session()->flash('success', "La situation familiale de {$nomAgent} a été enregistrée avec succès.");
    }

    // ═══════════════════════════════════════════════════════
    // MISE À JOUR (ÉDITION)
    // ═══════════════════════════════════════════════════════

    public function updateFiche(): void
    {
        $fiche = $this->selectedFiche;
        if (! $fiche) return;

        $this->validate([
            'edit_situation_mariale' => 'nullable|string|max:50',
            'edit_nature_piece'      => 'nullable|string|max:100',
            'edit_numero_piece'      => 'nullable|string|max:50',
            'edit_date_etabli_piece' => 'nullable|date',
            'edit_nom_prenom_femme'  => 'nullable|string|max:150',
            'edit_group_sangin'      => 'nullable|string|max:10',
            'edit_date_mariage'      => 'nullable|date',
            'edit_lieu_mariage'      => 'nullable|string|max:150',
        ]);

        $fiche->update([
            'situation_mariale' => $this->edit_situation_mariale ?: null,
            'nature_piece'      => $this->edit_nature_piece      ?: null,
            'numero_piece'      => $this->edit_numero_piece      ?: null,
            'date_etabli_piece' => $this->edit_date_etabli_piece ?: null,
            'nom_prenom_femme'  => $this->edit_nom_prenom_femme  ?: null,
            'group_sangin'      => $this->edit_group_sangin       ?: null,
            'date_mariage'      => $this->edit_date_mariage       ?: null,
            'lieu_mariage'      => $this->edit_lieu_mariage       ?: null,
            'enfants'           => ! empty($this->edit_enfants) ? $this->edit_enfants : null,
        ]);

        $this->editMode = false;
        $this->resetErrorBag();
        session()->flash('success', "La situation familiale de {$fiche->agent->nom_prenom_agent} a été mise à jour.");
    }

    // ═══════════════════════════════════════════════════════
    // SUPPRESSION
    // ═══════════════════════════════════════════════════════

    public function confirmDelete(): void
    {
        $fiche = $this->selectedFiche;
        if (! $fiche) return;

        $nom = $fiche->agent->nom_prenom_agent ?? 'l\'agent';
        $fiche->delete();

        $this->closeFicheModal();
        session()->flash('success', "La situation familiale de {$nom} a été supprimée.");
    }

    // ═══════════════════════════════════════════════════════
    // LIBELLÉS ÉTAPES
    // ═══════════════════════════════════════════════════════

    public function stepLabel(int $step): string
    {
        return match ($step) {
            1       => 'Agent & Pièce',
            2       => 'Conjoint',
            3       => 'Enfants',
            default => '',
        };
    }

    // ═══════════════════════════════════════════════════════
    // RENDU
    // ═══════════════════════════════════════════════════════

    public function render(): \Illuminate\View\View
    {
        return view('livewire.personnels.create-situation-familiale', [
            'fiches' => SituationFamiliale::with('agent')
                                          ->latest()
                                          ->paginate(10),
        ]);
    }
}
