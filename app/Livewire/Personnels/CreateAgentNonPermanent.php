<?php

namespace App\Livewire\Personnels;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Personnel\AgentNonPermanent;
use App\Models\Personnel\Commune;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateAgentNonPermanent extends Component
{
    use WithFileUploads;
    use WithPagination;

    // ═══════════════════════════════════════════════════════
    // ÉTAT DES MODALS
    // ═══════════════════════════════════════════════════════

    // Modal création
    public bool $showModal = false;

    // Modal consultation / édition
    public bool  $showAgentModal  = false;
    public bool  $editMode        = false;
    public ?int  $selectedAgentId = null;

    // ═══════════════════════════════════════════════════════
    // NAVIGATION ÉTAPES (3 étapes — pas de barème)
    // ═══════════════════════════════════════════════════════

    public int $step     = 1;
    public int $maxSteps = 3;

    // ═══════════════════════════════════════════════════════
    // CHAMPS FORMULAIRE CRÉATION
    // ═══════════════════════════════════════════════════════

    // ─── ÉTAPE 1 : Identité ──────────────────────────────
    public        $photo_agent_nopermanent    = null;
    public string $nom_prenom_nopermanent     = '';
    public string $sexe_nopermanent           = '';
    public string $situa_marial_nopermanent   = '';

    // ─── ÉTAPE 2 : Contacts ──────────────────────────────
    public string $contact_agent_nopermanent    = '';
    public string $contact_urgence_1_nopermanent = '';
    public string $contact_urgence_2_nopermanent = '';

    // ─── ÉTAPE 3 : Recrutement ───────────────────────────
    public string $commune_id                          = '';
    public string $act_recrutement_nopermanent         = '';
    public string $numero_act_recrutement_nopermanent  = '';
    public string $date_recrutement_nopermanent        = '';
    public string $fonction_nopermanent                = '';
    public string $service_nopermanent                 = '';
    public string $statut_nopermanent                  = '';
    public string $indemnite                           = '0';

    // ═══════════════════════════════════════════════════════
    // CHAMPS ÉDITION (préfixés edit_)
    // ═══════════════════════════════════════════════════════

    public string $edit_nom_prenom_nopermanent            = '';
    public string $edit_sexe_nopermanent                  = '';
    public string $edit_situa_marial_nopermanent          = '';
    public string $edit_contact_agent_nopermanent         = '';
    public string $edit_contact_urgence_1_nopermanent     = '';
    public string $edit_contact_urgence_2_nopermanent     = '';
    public string $edit_commune_id                        = '';
    public string $edit_act_recrutement_nopermanent       = '';
    public string $edit_numero_act_recrutement_nopermanent = '';
    public string $edit_date_recrutement_nopermanent      = '';
    public string $edit_fonction_nopermanent              = '';
    public string $edit_service_nopermanent               = '';
    public string $edit_statut_nopermanent                = '';
    public string $edit_indemnite                         = '0';

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
        $this->photo_agent_nopermanent           = null;
        $this->nom_prenom_nopermanent            = '';
        $this->sexe_nopermanent                  = '';
        $this->situa_marial_nopermanent          = '';
        $this->contact_agent_nopermanent         = '';
        $this->contact_urgence_1_nopermanent     = '';
        $this->contact_urgence_2_nopermanent     = '';
        $this->commune_id                        = '';
        $this->act_recrutement_nopermanent       = '';
        $this->numero_act_recrutement_nopermanent = '';
        $this->date_recrutement_nopermanent      = '';
        $this->fonction_nopermanent              = '';
        $this->service_nopermanent               = '';
        $this->statut_nopermanent                = '';
        $this->indemnite                         = '0';
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // GESTION MODAL CONSULTATION / ÉDITION
    // ═══════════════════════════════════════════════════════

    public function viewAgent(int $id): void
    {
        $this->selectedAgentId = $id;
        $this->editMode        = false;
        $this->resetErrorBag();
        $this->showAgentModal  = true;
    }

    public function getSelectedAgentProperty(): ?AgentNonPermanent
    {
        return $this->selectedAgentId
            ? AgentNonPermanent::with('commune')->find($this->selectedAgentId)
            : null;
    }

    public function closeAgentModal(): void
    {
        $this->showAgentModal  = false;
        $this->editMode        = false;
        $this->selectedAgentId = null;
        $this->resetErrorBag();
    }

    public function enableEditMode(): void
    {
        $agent = $this->selectedAgent;
        if (! $agent) return;

        $this->edit_nom_prenom_nopermanent             = $agent->nom_prenom_nopermanent             ?? '';
        $this->edit_sexe_nopermanent                   = $agent->sexe_nopermanent                   ?? '';
        $this->edit_situa_marial_nopermanent           = $agent->situa_marial_nopermanent           ?? '';
        $this->edit_contact_agent_nopermanent          = $agent->contact_agent_nopermanent          ?? '';
        $this->edit_contact_urgence_1_nopermanent      = $agent->contact_urgence_1_nopermanent      ?? '';
        $this->edit_contact_urgence_2_nopermanent      = $agent->contact_urgence_2_nopermanent      ?? '';
        $this->edit_commune_id                         = (string) ($agent->commune_id               ?? '');
        $this->edit_act_recrutement_nopermanent        = $agent->act_recrutement_nopermanent        ?? '';
        $this->edit_numero_act_recrutement_nopermanent = $agent->numero_act_recrutement_nopermanent ?? '';
        $this->edit_date_recrutement_nopermanent       = $agent->date_recrutement_nopermanent       ?? '';
        $this->edit_fonction_nopermanent               = $agent->fonction_nopermanent               ?? '';
        $this->edit_service_nopermanent                = $agent->service_nopermanent                ?? '';
        $this->edit_statut_nopermanent                 = $agent->statut_nopermanent                 ?? '';
        $this->edit_indemnite                          = (string) ($agent->indemnite                ?? 0);

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
                'photo_agent_nopermanent' => 'nullable|image|max:2048',
                'nom_prenom_nopermanent'  => 'required|string|max:150',
                'sexe_nopermanent'        => 'required|in:M,F',
                'situa_marial_nopermanent' => 'nullable|string|max:50',
            ],
            2 => [
                'contact_agent_nopermanent'          => 'nullable|string|max:20',
                'contact_urgence_1_nopermanent'      => 'nullable|string|max:20',
                'contact_urgence_2_nopermanent'      => 'nullable|string|max:20',
            ],
            3 => [
                'commune_id'                          => 'required|exists:communes,id',
                'act_recrutement_nopermanent'         => 'nullable|string|max:150',
                'numero_act_recrutement_nopermanent'  => 'nullable|string|max:50',
                'date_recrutement_nopermanent'        => 'nullable|date',
                'fonction_nopermanent'                => 'nullable|string|max:100',
                'service_nopermanent'                 => 'nullable|string|max:100',
                'statut_nopermanent'                  => 'nullable|string|max:50',
                'indemnite'                           => 'nullable|numeric|min:0',
            ],
            default => [],
        };
    }

    protected function messagesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'nom_prenom_nopermanent.required' => 'Le nom et prénom sont obligatoires.',
                'sexe_nopermanent.required'       => 'Le sexe est obligatoire.',
                'sexe_nopermanent.in'             => 'Veuillez sélectionner Masculin ou Féminin.',
                'photo_agent_nopermanent.image'   => 'La photo doit être une image (jpg, png…).',
                'photo_agent_nopermanent.max'     => 'La photo ne doit pas dépasser 2 Mo.',
            ],
            3 => [
                'commune_id.required' => 'Veuillez sélectionner une commune.',
                'commune_id.exists'   => 'La commune sélectionnée est invalide.',
                'indemnite.numeric'   => "L'indemnité doit être un nombre.",
            ],
            default => [],
        };
    }

    // ═══════════════════════════════════════════════════════
    // HOOKS LIVEWIRE
    // ═══════════════════════════════════════════════════════

    public function updatedPhotoAgentNopermanent(): void
    {
        $this->validateOnly('photo_agent_nopermanent', [
            'photo_agent_nopermanent' => 'nullable|image|max:2048',
        ], [
            'photo_agent_nopermanent.image' => 'La photo doit être une image (jpg, png…).',
            'photo_agent_nopermanent.max'   => 'La photo ne doit pas dépasser 2 Mo.',
        ]);
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
            $this->rulesForStep(3),
            $this->messagesForStep(3)
        );

        // Capturer le nom AVANT resetForm()
        $nomAgent = $this->nom_prenom_nopermanent;

        try {
            DB::transaction(function () {
                $photoPath = null;
                if ($this->photo_agent_nopermanent) {
                    $photoPath = $this->photo_agent_nopermanent->store('agents-non-permanents/photos', 'public');
                }

                AgentNonPermanent::create([
                    'commune_id'                          => $this->commune_id                          ?: null,
                    'nom_prenom_nopermanent'              => trim($this->nom_prenom_nopermanent),
                    'sexe_nopermanent'                    => $this->sexe_nopermanent,
                    'situa_marial_nopermanent'            => $this->situa_marial_nopermanent            ?: null,
                    'photo_agent_nopermanent'             => $photoPath,
                    'contact_agent_nopermanent'           => $this->contact_agent_nopermanent           ?: null,
                    'contact_urgence_1_nopermanent'       => $this->contact_urgence_1_nopermanent       ?: null,
                    'contact_urgence_2_nopermanent'       => $this->contact_urgence_2_nopermanent       ?: null,
                    'act_recrutement_nopermanent'         => $this->act_recrutement_nopermanent         ?: null,
                    'numero_act_recrutement_nopermanent'  => $this->numero_act_recrutement_nopermanent  ?: null,
                    'date_recrutement_nopermanent'        => $this->date_recrutement_nopermanent        ?: null,
                    'fonction_nopermanent'                => $this->fonction_nopermanent                ?: null,
                    'service_nopermanent'                 => $this->service_nopermanent                 ?: null,
                    'statut_nopermanent'                  => $this->statut_nopermanent                  ?: null,
                    'indemnite'                           => (float) ($this->indemnite                  ?: 0),
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('Erreur création agent non permanent', ['message' => $e->getMessage()]);
            session()->flash('error', "Une erreur est survenue lors de l'enregistrement. Veuillez réessayer.");
            return;
        }

        $this->closeModal();
        session()->flash('success', "L'agent {$nomAgent} a été enregistré avec succès.");
    }

    // ═══════════════════════════════════════════════════════
    // MISE À JOUR (ÉDITION)
    // ═══════════════════════════════════════════════════════

    public function updateAgent(): void
    {
        $agent = $this->selectedAgent;
        if (! $agent) return;

        $this->validate([
            'edit_nom_prenom_nopermanent'            => 'required|string|max:150',
            'edit_sexe_nopermanent'                  => 'required|in:M,F',
            'edit_situa_marial_nopermanent'          => 'nullable|string|max:50',
            'edit_contact_agent_nopermanent'         => 'nullable|string|max:20',
            'edit_contact_urgence_1_nopermanent'     => 'nullable|string|max:20',
            'edit_contact_urgence_2_nopermanent'     => 'nullable|string|max:20',
            'edit_commune_id'                        => 'required|exists:communes,id',
            'edit_act_recrutement_nopermanent'       => 'nullable|string|max:150',
            'edit_numero_act_recrutement_nopermanent' => 'nullable|string|max:50',
            'edit_date_recrutement_nopermanent'      => 'nullable|date',
            'edit_fonction_nopermanent'              => 'nullable|string|max:100',
            'edit_service_nopermanent'               => 'nullable|string|max:100',
            'edit_statut_nopermanent'                => 'nullable|string|max:50',
            'edit_indemnite'                         => 'nullable|numeric|min:0',
        ], [
            'edit_nom_prenom_nopermanent.required' => 'Le nom et prénom sont obligatoires.',
            'edit_sexe_nopermanent.required'       => 'Le sexe est obligatoire.',
            'edit_commune_id.required'             => 'Veuillez sélectionner une commune.',
            'edit_indemnite.numeric'               => "L'indemnité doit être un nombre.",
        ]);

        $agent->update([
            'nom_prenom_nopermanent'              => trim($this->edit_nom_prenom_nopermanent),
            'sexe_nopermanent'                    => $this->edit_sexe_nopermanent,
            'situa_marial_nopermanent'            => $this->edit_situa_marial_nopermanent            ?: null,
            'contact_agent_nopermanent'           => $this->edit_contact_agent_nopermanent           ?: null,
            'contact_urgence_1_nopermanent'       => $this->edit_contact_urgence_1_nopermanent       ?: null,
            'contact_urgence_2_nopermanent'       => $this->edit_contact_urgence_2_nopermanent       ?: null,
            'commune_id'                          => $this->edit_commune_id                          ?: null,
            'act_recrutement_nopermanent'         => $this->edit_act_recrutement_nopermanent         ?: null,
            'numero_act_recrutement_nopermanent'  => $this->edit_numero_act_recrutement_nopermanent  ?: null,
            'date_recrutement_nopermanent'        => $this->edit_date_recrutement_nopermanent        ?: null,
            'fonction_nopermanent'                => $this->edit_fonction_nopermanent                ?: null,
            'service_nopermanent'                 => $this->edit_service_nopermanent                 ?: null,
            'statut_nopermanent'                  => $this->edit_statut_nopermanent                  ?: null,
            'indemnite'                           => (float) ($this->edit_indemnite                  ?: 0),
        ]);

        $this->editMode = false;
        $this->resetErrorBag();
        session()->flash('success', "Les informations de {$agent->nom_prenom_nopermanent} ont été mises à jour.");
    }

    // ═══════════════════════════════════════════════════════
    // SUPPRESSION
    // ═══════════════════════════════════════════════════════

    public function confirmDelete(): void
    {
        $agent = $this->selectedAgent;
        if (! $agent) return;

        $nom = $agent->nom_prenom_nopermanent;

        if ($agent->photo_agent_nopermanent) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($agent->photo_agent_nopermanent);
        }

        $agent->delete();

        $this->closeAgentModal();
        session()->flash('success', "L'agent {$nom} a été supprimé.");
    }

    // ═══════════════════════════════════════════════════════
    // LIBELLÉS ÉTAPES
    // ═══════════════════════════════════════════════════════

    public function stepLabel(int $step): string
    {
        return match ($step) {
            1       => 'Identité',
            2       => 'Contacts',
            3       => 'Recrutement',
            default => '',
        };
    }

    // ═══════════════════════════════════════════════════════
    // RENDU
    // ═══════════════════════════════════════════════════════

    public function render(): \Illuminate\View\View
    {
        return view('livewire.personnels.create-agent-non-permanent', [
            'agents'   => AgentNonPermanent::with('commune')
                                           ->latest()
                                           ->paginate(10),
            'communes' => Commune::orderBy('nom_commune')->get(),
        ]);
    }
}
