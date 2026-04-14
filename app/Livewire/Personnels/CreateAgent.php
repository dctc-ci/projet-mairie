<?php
namespace App\Livewire\Personnels;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Personnel\Agent;
use App\Models\Personnel\Commune;
use App\Models\Personnel\BaremeSalarial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateAgent extends Component
{
    use WithFileUploads;
    use WithPagination;

    // ─── État du modal création ───────────────────────────
    public bool $showModal = false;

    // ─── Propriétés pour le modal de consultation/édition ────
    public bool  $showAgentModal = false;
    public bool  $editMode       = false;
    public ?int  $selectedAgentId = null;

    // Champs d'édition (préfixés edit_ pour éviter les conflits)
    public string $edit_nom_prenom_agent       = '';
    public string $edit_date_naissance_agent   = '';
    public string $edit_sexe_agent             = '';
    public string $edit_qualification          = '';
    public string $edit_contact_agent          = '';
    public string $edit_contact_urgence_1      = '';
    public string $edit_contact_urgence_2      = '';
    public string $edit_commune_id             = '';
    public string $edit_nature_embauche        = '';
    public string $edit_numero_embauche        = '';
    public string $edit_date_embauche          = '';
    public string $edit_date_fonction_embauche = '';
    public string $edit_date_prise_service     = '';
    public string $edit_groupe                 = '';
    public string $edit_indem_transp           = '0';
    public string $edit_indem_fonction         = '0';
    public string $edit_indem_techn            = '0';
    public string $edit_fonction               = '';
    public string $edit_service                = '';
    public string $edit_post_travail           = '';
    public string $edit_statut                 = '';
    public string $edit_imputa_budgetaire      = '';
    public string $edit_chapitre_paie          = '';
    public string $edit_article_paie           = '';

    // ─── Navigation étapes ───────────────────────────────
    public int $step     = 1;
    public int $maxSteps = 5;

    // ─── ÉTAPE 1 : Identité ──────────────────────────────
    public string $nom_prenom_agent     = '';
    public string $date_naissance_agent = '';
    public string $sexe_agent           = '';
    public string $matricule            = '';
    public string $qualification        = '';
    public $photo_agent                 = null;

    // ─── ÉTAPE 2 : Contacts ──────────────────────────────
    public string $contact_agent     = '';
    public string $contact_urgence_1 = '';
    public string $contact_urgence_2 = '';

    // ─── ÉTAPE 3 : Embauche ──────────────────────────────
    public string $commune_id             = '';
    public string $nature_embauche        = '';
    public string $numero_embauche        = '';
    public string $date_embauche          = '';
    public string $date_fonction_embauche = '';
    public string $date_prise_service     = '';

    // ─── ÉTAPE 4 : Classification & Poste ────────────────
    public string $bareme_salarial_id = '';
    public string $readonly_categorie       = '';
    public string $readonly_echelon         = '';
    public string $readonly_indice          = '';
    public string $readonly_salaire_base    = '';
    public string $readonly_salaire_brut    = '';
    public string $readonly_indem_residence = '';
    public string $groupe         = '';
    public string $indem_transp   = '0';
    public string $indem_fonction = '0';
    public string $indem_techn    = '0';
    public string $fonction       = '';
    public string $service        = '';
    public string $post_travail   = '';
    public string $statut         = '';

    // ─── ÉTAPE 5 : Budgétaire ────────────────────────────
    public string $imputa_budgetaire = '';
    public string $chapitre_paie     = '';
    public string $article_paie      = '';

    // ═══════════════════════════════════════════════════════
    // GESTION DU MODAL CRÉATION
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
        $this->step                   = 1;
        $this->nom_prenom_agent       = '';
        $this->date_naissance_agent   = '';
        $this->sexe_agent             = '';
        $this->matricule              = '';
        $this->qualification          = '';
        $this->photo_agent            = null;
        $this->contact_agent          = '';
        $this->contact_urgence_1      = '';
        $this->contact_urgence_2      = '';
        $this->commune_id             = '';
        $this->nature_embauche        = '';
        $this->numero_embauche        = '';
        $this->date_embauche          = '';
        $this->date_fonction_embauche = '';
        $this->date_prise_service     = '';
        $this->bareme_salarial_id     = '';
        $this->groupe                 = '';
        $this->indem_transp           = '0';
        $this->indem_fonction         = '0';
        $this->indem_techn            = '0';
        $this->fonction               = '';
        $this->service                = '';
        $this->post_travail           = '';
        $this->statut                 = '';
        $this->imputa_budgetaire      = '';
        $this->chapitre_paie          = '';
        $this->article_paie           = '';
        $this->resetBaremeFields();
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // GESTION DU MODAL CONSULTATION/ÉDITION
    // ═══════════════════════════════════════════════════════

    // ─── Ouvrir la fiche agent ────────────────────────────────
    public function viewAgent(int $id): void
    {
        $agent = Agent::with(['commune', 'baremeSalarial'])->findOrFail($id);

        $this->selectedAgentId = $agent->id;
        $this->editMode        = false;
        $this->resetErrorBag();
        $this->showAgentModal  = true;
    }

    
    public function getSelectedAgentProperty(): ?Agent
    {
        if (!$this->selectedAgentId) {
            return null;
        }
        
        return Agent::with(['commune', 'baremeSalarial'])->find($this->selectedAgentId);
    }

    public function closeAgentModal(): void
    {
        $this->showAgentModal  = false;
        $this->editMode        = false;
        $this->selectedAgentId = null;
        $this->resetErrorBag();
    }

    // ─── Mode édition ─────────────────────────────────────────
    public function enableEditMode(): void
    {
       
        $agent = $this->selectedAgent;
        if (! $agent) return;

        $this->edit_nom_prenom_agent       = $agent->nom_prenom_agent       ?? '';
        $this->edit_date_naissance_agent   = $agent->date_naissance_agent   ?? '';
        $this->edit_sexe_agent             = $agent->sexe_agent             ?? '';
        $this->edit_qualification          = $agent->qualification          ?? '';
        $this->edit_contact_agent          = $agent->contact_agent          ?? '';
        $this->edit_contact_urgence_1      = $agent->contact_urgence_1      ?? '';
        $this->edit_contact_urgence_2      = $agent->contact_urgence_2      ?? '';
        $this->edit_commune_id             = (string) ($agent->commune_id   ?? '');
        $this->edit_nature_embauche        = $agent->nature_embauche        ?? '';
        $this->edit_numero_embauche        = $agent->numero_embauche        ?? '';
        $this->edit_date_embauche          = $agent->date_embauche          ?? '';
        $this->edit_date_fonction_embauche = $agent->date_fonction_embauche ?? '';
        $this->edit_date_prise_service     = $agent->date_prise_service     ?? '';
        $this->edit_groupe                 = $agent->groupe                 ?? '';
        $this->edit_indem_transp           = (string) ($agent->indem_transp   ?? 0);
        $this->edit_indem_fonction         = (string) ($agent->indem_fonction ?? 0);
        $this->edit_indem_techn            = (string) ($agent->indem_techn    ?? 0);
        $this->edit_fonction               = $agent->fonction               ?? '';
        $this->edit_service                = $agent->service                ?? '';
        $this->edit_post_travail           = $agent->post_travail           ?? '';
        $this->edit_statut                 = $agent->statut                 ?? '';
        $this->edit_imputa_budgetaire      = $agent->imputa_budgetaire      ?? '';
        $this->edit_chapitre_paie          = $agent->chapitre_paie          ?? '';
        $this->edit_article_paie           = $agent->article_paie           ?? '';

        $this->editMode = true;
    }

    public function cancelEdit(): void
    {
        $this->editMode = false;
        $this->resetErrorBag();
    }

    // ─── Enregistrer les modifications ───────────────────────
    public function updateAgent(): void
    {
        
        $agent = $this->selectedAgent;
        if (! $agent) return;

        $this->validate([
            'edit_nom_prenom_agent'       => 'required|string|max:150',
            'edit_date_naissance_agent'   => 'required|date|before:today',
            'edit_sexe_agent'             => 'required|in:M,F',
            'edit_qualification'          => 'nullable|string|max:100',
            'edit_contact_agent'          => 'nullable|string|max:20',
            'edit_contact_urgence_1'      => 'nullable|string|max:20',
            'edit_contact_urgence_2'      => 'nullable|string|max:20',
            'edit_commune_id'             => 'required|exists:communes,id',
            'edit_nature_embauche'        => 'nullable|string|max:100',
            'edit_numero_embauche'        => 'nullable|string|max:50',
            'edit_date_embauche'          => 'nullable|date',
            'edit_date_fonction_embauche' => 'nullable|date',
            'edit_date_prise_service'     => 'nullable|date',
            'edit_groupe'                 => 'nullable|string|max:50',
            'edit_indem_transp'           => 'nullable|numeric|min:0',
            'edit_indem_fonction'         => 'nullable|numeric|min:0',
            'edit_indem_techn'            => 'nullable|numeric|min:0',
            'edit_fonction'               => 'nullable|string|max:100',
            'edit_service'                => 'nullable|string|max:100',
            'edit_post_travail'           => 'nullable|string|max:100',
            'edit_statut'                 => 'nullable|string|max:50',
            'edit_imputa_budgetaire'      => 'nullable|string|max:100',
            'edit_chapitre_paie'          => 'nullable|string|max:50',
            'edit_article_paie'           => 'nullable|string|max:50',
        ], [
            'edit_nom_prenom_agent.required'   => 'Le nom et prénom sont obligatoires.',
            'edit_date_naissance_agent.before' => 'La date de naissance doit être dans le passé.',
            'edit_sexe_agent.required'         => 'Le sexe est obligatoire.',
            'edit_commune_id.required'         => 'Veuillez sélectionner une commune.',
        ]);

        $agent->update([
            'nom_prenom_agent'       => trim($this->edit_nom_prenom_agent),
            'date_naissance_agent'   => $this->edit_date_naissance_agent   ?: null,
            'sexe_agent'             => $this->edit_sexe_agent,
            'qualification'          => $this->edit_qualification          ?: null,
            'contact_agent'          => $this->edit_contact_agent          ?: null,
            'contact_urgence_1'      => $this->edit_contact_urgence_1      ?: null,
            'contact_urgence_2'      => $this->edit_contact_urgence_2      ?: null,
            'commune_id'             => $this->edit_commune_id             ?: null,
            'nature_embauche'        => $this->edit_nature_embauche        ?: null,
            'numero_embauche'        => $this->edit_numero_embauche        ?: null,
            'date_embauche'          => $this->edit_date_embauche          ?: null,
            'date_fonction_embauche' => $this->edit_date_fonction_embauche ?: null,
            'date_prise_service'     => $this->edit_date_prise_service     ?: null,
            'groupe'                 => $this->edit_groupe                 ?: null,
            'indem_transp'           => (float) ($this->edit_indem_transp   ?: 0),
            'indem_fonction'         => (float) ($this->edit_indem_fonction ?: 0),
            'indem_techn'            => (float) ($this->edit_indem_techn    ?: 0),
            'fonction'               => $this->edit_fonction               ?: null,
            'service'                => $this->edit_service                ?: null,
            'post_travail'           => $this->edit_post_travail           ?: null,
            'statut'                 => $this->edit_statut                 ?: null,
            'imputa_budgetaire'      => $this->edit_imputa_budgetaire      ?: null,
            'chapitre_paie'          => $this->edit_chapitre_paie          ?: null,
            'article_paie'           => $this->edit_article_paie           ?: null,
        ]);

        $this->editMode = false;
        $this->resetErrorBag();
        session()->flash('success', "Les informations de {$agent->nom_prenom_agent} ont été mises à jour.");
    }

    // ─── Supprimer l'agent ────────────────────────────────────
    public function confirmDelete(): void
    {
    
        $agent = $this->selectedAgent;
        if (! $agent) return;

        $nom = $agent->nom_prenom_agent;

        // Supprimer la photo si elle existe
        if ($agent->photo_agent) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($agent->photo_agent);
        }

        $agent->delete();

        $this->closeAgentModal();
        session()->flash('success', "L'agent {$nom} a été supprimé.");
    }

    // ═══════════════════════════════════════════════════════
    // RÈGLES DE VALIDATION PAR ÉTAPE
    // ═══════════════════════════════════════════════════════
    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'nom_prenom_agent'     => 'required|string|max:150',
                'date_naissance_agent' => 'required|date|before:today',
                'sexe_agent'           => 'required|in:M,F',
                'matricule'            => 'required|string|max:50|unique:agents,matricule',
                'qualification'        => 'nullable|string|max:100',
                'photo_agent'          => 'nullable|image|max:2048',
            ],
            2 => [
                'contact_agent'     => 'nullable|string|max:20',
                'contact_urgence_1' => 'nullable|string|max:20',
                'contact_urgence_2' => 'nullable|string|max:20',
            ],
            3 => [
                'commune_id'             => 'required|exists:communes,id',
                'nature_embauche'        => 'nullable|string|max:100',
                'numero_embauche'        => 'nullable|string|max:50',
                'date_embauche'          => 'nullable|date',
                'date_fonction_embauche' => 'nullable|date',
                'date_prise_service'     => 'nullable|date',
            ],
            4 => [
                'bareme_salarial_id' => 'required|exists:bareme_salarials,id',
                'groupe'             => 'nullable|string|max:50',
                'indem_transp'       => 'nullable|numeric|min:0',
                'indem_fonction'     => 'nullable|numeric|min:0',
                'indem_techn'        => 'nullable|numeric|min:0',
                'fonction'           => 'nullable|string|max:100',
                'service'            => 'nullable|string|max:100',
                'post_travail'       => 'nullable|string|max:100',
                'statut'             => 'nullable|string|max:50',
            ],
            5 => [
                'imputa_budgetaire' => 'nullable|string|max:100',
                'chapitre_paie'     => 'nullable|string|max:50',
                'article_paie'      => 'nullable|string|max:50',
            ],
            default => [],
        };
    }

    protected function messagesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'nom_prenom_agent.required'     => 'Le nom et prénom sont obligatoires.',
                'date_naissance_agent.required' => 'La date de naissance est obligatoire.',
                'date_naissance_agent.before'   => 'La date de naissance doit être dans le passé.',
                'sexe_agent.required'           => 'Le sexe est obligatoire.',
                'sexe_agent.in'                 => 'Veuillez sélectionner Masculin ou Féminin.',
                'matricule.required'            => 'Le matricule est obligatoire.',
                'matricule.unique'              => 'Ce matricule est déjà utilisé par un autre agent.',
                'photo_agent.image'             => 'La photo doit être une image (jpg, png…).',
                'photo_agent.max'               => 'La photo ne doit pas dépasser 2 Mo.',
            ],
            3 => [
                'commune_id.required' => 'Veuillez sélectionner une commune.',
                'commune_id.exists'   => 'La commune sélectionnée est invalide.',
            ],
            4 => [
                'bareme_salarial_id.required' => 'Veuillez sélectionner une catégorie salariale.',
                'bareme_salarial_id.exists'   => 'La catégorie sélectionnée est invalide.',
                'indem_transp.numeric'        => "L'indemnité de transport doit être un nombre.",
                'indem_fonction.numeric'      => "L'indemnité de fonction doit être un nombre.",
                'indem_techn.numeric'         => "L'indemnité technique doit être un nombre.",
            ],
            default => [],
        };
    }

    // ═══════════════════════════════════════════════════════
    // HOOKS LIVEWIRE
    // ═══════════════════════════════════════════════════════
    public function updatedPhotoAgent(): void
    {
        $this->validateOnly('photo_agent', [
            'photo_agent' => 'nullable|image|max:2048',
        ], [
            'photo_agent.image' => 'La photo doit être une image (jpg, png…).',
            'photo_agent.max'   => 'La photo ne doit pas dépasser 2 Mo.',
        ]);
    }

    public function updatedBaremeSalarialId(string $id): void
    {
        if (empty($id)) {
            $this->resetBaremeFields();
            return;
        }
        $bareme = BaremeSalarial::find($id);
        if ($bareme) {
            $this->readonly_categorie       = (string) ($bareme->categorie  ?? '');
            $this->readonly_echelon         = (string) ($bareme->echelon    ?? '');
            $this->readonly_indice          = (string) ($bareme->indice     ?? '');
            $this->readonly_salaire_base    = number_format((float) ($bareme->salaire_base    ?? 0), 0, ',', ' ') . ' FCFA';
            $this->readonly_salaire_brut    = number_format((float) ($bareme->salaire_brut    ?? 0), 0, ',', ' ') . ' FCFA';
            $this->readonly_indem_residence = number_format((float) ($bareme->indem_residence ?? 0), 0, ',', ' ') . ' FCFA';
        } else {
            $this->resetBaremeFields();
        }
    }

    private function resetBaremeFields(): void
    {
        $this->readonly_categorie       = '';
        $this->readonly_echelon         = '';
        $this->readonly_indice          = '';
        $this->readonly_salaire_base    = '';
        $this->readonly_salaire_brut    = '';
        $this->readonly_indem_residence = '';
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
        $this->validate(
            $this->rulesForStep(5),
            $this->messagesForStep(5)
        );

        $nomAgent = $this->nom_prenom_agent;

        try {
            DB::transaction(function () {
                $photoPath = null;
                if ($this->photo_agent) {
                    $photoPath = $this->photo_agent->store('agents/photos', 'public');
                }

                Agent::create([
                    'commune_id'             => $this->commune_id             ?: null,
                    'bareme_salarial_id'     => $this->bareme_salarial_id     ?: null,
                    'nom_prenom_agent'       => trim($this->nom_prenom_agent),
                    'date_naissance_agent'   => $this->date_naissance_agent   ?: null,
                    'sexe_agent'             => $this->sexe_agent,
                    'matricule'              => strtoupper(trim($this->matricule)),
                    'qualification'          => $this->qualification          ?: null,
                    'photo_agent'            => $photoPath,
                    'contact_agent'          => $this->contact_agent          ?: null,
                    'contact_urgence_1'      => $this->contact_urgence_1      ?: null,
                    'contact_urgence_2'      => $this->contact_urgence_2      ?: null,
                    'nature_embauche'        => $this->nature_embauche        ?: null,
                    'numero_embauche'        => $this->numero_embauche        ?: null,
                    'date_embauche'          => $this->date_embauche          ?: null,
                    'date_fonction_embauche' => $this->date_fonction_embauche ?: null,
                    'date_prise_service'     => $this->date_prise_service     ?: null,
                    'groupe'                 => $this->groupe                 ?: null,
                    'indem_transp'           => (float) ($this->indem_transp   ?: 0),
                    'indem_fonction'         => (float) ($this->indem_fonction ?: 0),
                    'indem_techn'            => (float) ($this->indem_techn    ?: 0),
                    'fonction'               => $this->fonction               ?: null,
                    'service'                => $this->service                ?: null,
                    'post_travail'           => $this->post_travail           ?: null,
                    'statut'                 => $this->statut                 ?: null,
                    'imputa_budgetaire'      => $this->imputa_budgetaire      ?: null,
                    'chapitre_paie'          => $this->chapitre_paie          ?: null,
                    'article_paie'           => $this->article_paie           ?: null,
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('Erreur création agent', ['message' => $e->getMessage()]);
            session()->flash('error', "Une erreur est survenue lors de l'enregistrement. Veuillez réessayer.");
            return;
        }

        $this->closeModal();
        session()->flash('success', "L'agent {$nomAgent} a été enregistré avec succès.");
    }

    // ═══════════════════════════════════════════════════════
    // LIBELLÉS ÉTAPES
    // ═══════════════════════════════════════════════════════
    public function stepLabel(int $step): string
    {
        return match ($step) {
            1       => 'Identité',
            2       => 'Contacts',
            3       => 'Embauche',
            4       => 'Poste & Salaire',
            5       => 'Budgétaire',
            default => '',
        };
    }

    // ═══════════════════════════════════════════════════════
    // RENDU
    // ═══════════════════════════════════════════════════════
    public function render(): \Illuminate\View\View
    {
        return view('livewire.personnels.create-agent', [
            'agents'   => Agent::with(['commune', 'baremeSalarial'])
                ->latest()
                ->paginate(10),
            'communes' => Commune::orderBy('nom_commune')->get(),
            'baremes'  => BaremeSalarial::orderBy('categorie')
                ->orderBy('echelon')
                ->get(),
        ]);
    }
}