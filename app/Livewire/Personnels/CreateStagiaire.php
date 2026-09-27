<?php

namespace App\Livewire\Personnels;

use App\Models\Personnel\Stagiaire;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class CreateStagiaire extends Component
{
    use AuthorizesPersonnelManagement;
    use WithPagination;

    // ═══════════════════════════════════════════════════════
    // ÉTAT DES MODALS
    // ═══════════════════════════════════════════════════════
    public bool $showModal = false;

    public bool $showAgentModal = false;

    public bool $editMode = false;

    // ✅ CORRECTION : renamed from $selectedAgentId to $selectedStagiaireId
    public ?int $selectedStagiaireId = null;

    // ═══════════════════════════════════════════════════════
    // NAVIGATION ÉTAPES (3 étapes)
    // ═══════════════════════════════════════════════════════
    public int $step = 1;

    public int $maxSteps = 3;

    // ═══════════════════════════════════════════════════════
    // CHAMPS FORMULAIRE CRÉATION
    // ═══════════════════════════════════════════════════════
    // ─── ÉTAPE 1 : Identité ──────────────────────────────
    public string $nom_prenom_stagiaire = '';

    public string $date_naissance_stagiaire = '';

    public string $lieu_naissance_stagiaire = '';

    public string $contact_stagiaire = '';

    public string $contact_urgence_stagiaire = '';

    // ─── ÉTAPE 2 : Diplôme ───────────────────────────────
    public string $nature_diplome = '';

    public string $numero_diplome = '';

    public string $session = '';

    public string $option = '';

    // ─── ÉTAPE 3 : Stage ─────────────────────────────────
    public string $annee_exercice = '';

    public string $service_accueil = '';

    public string $maitre_stage = '';

    public string $date_demarrage = '';

    public string $date_fin = '';

    public string $theme_stage = '';

    public string $note = '';

    public string $appreciation = '';

    public bool $inscri_emploi_jeune = false;

    // ═══════════════════════════════════════════════════════
    // CHAMPS ÉDITION (préfixés edit_)
    // ═══════════════════════════════════════════════════════
    public string $edit_nom_prenom_stagiaire = '';

    public string $edit_date_naissance_stagiaire = '';

    public string $edit_lieu_naissance_stagiaire = '';

    public string $edit_contact_stagiaire = '';

    public string $edit_contact_urgence_stagiaire = '';

    public string $edit_nature_diplome = '';

    public string $edit_numero_diplome = '';

    public string $edit_session = '';

    public string $edit_option = '';

    public string $edit_annee_exercice = '';

    public string $edit_service_accueil = '';

    public string $edit_maitre_stage = '';

    public string $edit_date_demarrage = '';

    public string $edit_date_fin = '';

    public string $edit_theme_stage = '';

    public string $edit_note = '';

    public string $edit_appreciation = '';

    public bool $edit_inscri_emploi_jeune = false;

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
        $this->step = 1;
        $this->nom_prenom_stagiaire = '';
        $this->date_naissance_stagiaire = '';
        $this->lieu_naissance_stagiaire = '';
        $this->contact_stagiaire = '';
        $this->contact_urgence_stagiaire = '';
        $this->nature_diplome = '';
        $this->numero_diplome = '';
        $this->session = '';
        $this->option = '';
        $this->annee_exercice = '';
        $this->service_accueil = '';
        $this->maitre_stage = '';
        $this->date_demarrage = '';
        $this->date_fin = '';
        $this->theme_stage = '';
        $this->note = '';
        $this->appreciation = '';
        $this->inscri_emploi_jeune = false;
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // GESTION MODAL CONSULTATION / ÉDITION
    // ═══════════════════════════════════════════════════════
    public function viewAgent(int $id): void
    {
        // ✅ CORRECTION : utilisation de $selectedStagiaireId
        $this->selectedStagiaireId = $id;
        $this->editMode = false;
        $this->resetErrorBag();
        $this->showAgentModal = true;
    }

    // ✅ CORRECTION : renamed from getSelectedAgentProperty to getSelectedStagiaireProperty
    public function getSelectedStagiaireProperty(): ?Stagiaire
    {
        return $this->selectedStagiaireId
            ? Stagiaire::find($this->selectedStagiaireId)
            : null;
    }

    public function closeAgentModal(): void
    {
        $this->showAgentModal = false;
        $this->editMode = false;
        $this->selectedStagiaireId = null;
        $this->resetErrorBag();
    }

    public function enableEditMode(): void
    {
        // ✅ CORRECTION : utilisation de $this->selectedStagiaire (computed property)
        $s = $this->selectedStagiaire;
        if (! $s) {
            return;
        }

        $this->edit_nom_prenom_stagiaire = $s->nom_prenom_stagiaire ?? '';
        $this->edit_date_naissance_stagiaire = $s->date_naissance_stagiaire ?? '';
        $this->edit_lieu_naissance_stagiaire = $s->lieu_naissance_stagiaire ?? '';
        $this->edit_contact_stagiaire = $s->contact_stagiaire ?? '';
        $this->edit_contact_urgence_stagiaire = $s->contact_urgence_stagiaire ?? '';
        $this->edit_nature_diplome = $s->nature_diplome ?? '';
        $this->edit_numero_diplome = $s->numero_diplome ?? '';
        $this->edit_session = $s->session ?? '';
        $this->edit_option = $s->option ?? '';
        $this->edit_annee_exercice = $s->annee_exercice ?? '';
        $this->edit_service_accueil = $s->service_accueil ?? '';
        $this->edit_maitre_stage = $s->maitre_stage ?? '';
        $this->edit_date_demarrage = $s->date_demarrage ?? '';
        $this->edit_date_fin = $s->date_fin ?? '';
        $this->edit_theme_stage = $s->theme_stage ?? '';
        $this->edit_note = (string) ($s->note ?? '');
        $this->edit_appreciation = $s->appreciation ?? '';
        $this->edit_inscri_emploi_jeune = (bool) ($s->inscri_emploi_jeune ?? false);

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
                'nom_prenom_stagiaire' => 'required|string|max:150',
                'date_naissance_stagiaire' => 'nullable|date|before:today',
                'lieu_naissance_stagiaire' => 'nullable|string|max:150',
                'contact_stagiaire' => 'nullable|string|max:20',
                'contact_urgence_stagiaire' => 'nullable|string|max:20',
            ],
            2 => [
                'nature_diplome' => 'nullable|string|max:100',
                'numero_diplome' => 'nullable|string|max:50',
                'session' => 'nullable|string|max:50',
                'option' => 'nullable|string|max:100',
            ],
            3 => [
                'annee_exercice' => 'nullable|string|max:10',
                'service_accueil' => 'nullable|string|max:100',
                'maitre_stage' => 'nullable|string|max:150',
                'date_demarrage' => 'nullable|date',
                'date_fin' => 'nullable|date|after_or_equal:date_demarrage',
                'theme_stage' => 'nullable|string|max:255',
                'note' => 'nullable|numeric|min:0|max:20',
                'appreciation' => 'nullable|string|max:50',
                'inscri_emploi_jeune' => 'boolean',
            ],
            default => [],
        };
    }

    protected function messagesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'nom_prenom_stagiaire.required' => 'Le nom et prénom sont obligatoires.',
                'date_naissance_stagiaire.before' => 'La date de naissance doit être dans le passé.',
            ],
            3 => [
                'date_fin.after_or_equal' => 'La date de fin doit être après la date de démarrage.',
                'note.numeric' => 'La note doit être un nombre.',
                'note.max' => 'La note ne peut pas dépasser 20.',
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
        $this->authorizePersonnelManagement();
        $this->validate(
            $this->rulesForStep(3),
            $this->messagesForStep(3)
        );

        $nomStagiaire = $this->nom_prenom_stagiaire;

        try {
            DB::transaction(function () {
                Stagiaire::create([
                    'nom_prenom_stagiaire' => trim($this->nom_prenom_stagiaire),
                    'date_naissance_stagiaire' => $this->date_naissance_stagiaire ?: null,
                    'lieu_naissance_stagiaire' => $this->lieu_naissance_stagiaire ?: null,
                    'contact_stagiaire' => $this->contact_stagiaire ?: null,
                    'contact_urgence_stagiaire' => $this->contact_urgence_stagiaire ?: null,
                    'nature_diplome' => $this->nature_diplome ?: null,
                    'numero_diplome' => $this->numero_diplome ?: null,
                    'session' => $this->session ?: null,
                    'option' => $this->option ?: null,
                    'annee_exercice' => $this->annee_exercice ?: null,
                    'service_accueil' => $this->service_accueil ?: null,
                    'maitre_stage' => $this->maitre_stage ?: null,
                    'date_demarrage' => $this->date_demarrage ?: null,
                    'date_fin' => $this->date_fin ?: null,
                    'theme_stage' => $this->theme_stage ?: null,
                    'note' => $this->note !== '' ? (float) $this->note : null,
                    'appreciation' => $this->appreciation ?: null,
                    'inscri_emploi_jeune' => $this->inscri_emploi_jeune,
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('Erreur création stagiaire', ['message' => $e->getMessage()]);
            session()->flash('error', "Une erreur est survenue lors de l'enregistrement. Veuillez réessayer.");

            return;
        }

        $this->closeModal();
        session()->flash('success', "Le stagiaire {$nomStagiaire} a été enregistré avec succès.");
    }

    // ═══════════════════════════════════════════════════════
    // MISE À JOUR (ÉDITION)
    // ═══════════════════════════════════════════════════════
    public function updateAgent(): void
    {
        $this->authorizePersonnelManagement();
        // ✅ CORRECTION : utilisation de $this->selectedStagiaire
        $stagiaire = $this->selectedStagiaire;
        if (! $stagiaire) {
            return;
        }

        $this->validate([
            'edit_nom_prenom_stagiaire' => 'required|string|max:150',
            'edit_date_naissance_stagiaire' => 'nullable|date|before:today',
            'edit_lieu_naissance_stagiaire' => 'nullable|string|max:150',
            'edit_contact_stagiaire' => 'nullable|string|max:20',
            'edit_contact_urgence_stagiaire' => 'nullable|string|max:20',
            'edit_nature_diplome' => 'nullable|string|max:100',
            'edit_numero_diplome' => 'nullable|string|max:50',
            'edit_session' => 'nullable|string|max:50',
            'edit_option' => 'nullable|string|max:100',
            'edit_annee_exercice' => 'nullable|string|max:10',
            'edit_service_accueil' => 'nullable|string|max:100',
            'edit_maitre_stage' => 'nullable|string|max:150',
            'edit_date_demarrage' => 'nullable|date',
            'edit_date_fin' => 'nullable|date|after_or_equal:edit_date_demarrage',
            'edit_theme_stage' => 'nullable|string|max:255',
            'edit_note' => 'nullable|numeric|min:0|max:20',
            'edit_appreciation' => 'nullable|string|max:50',
            'edit_inscri_emploi_jeune' => 'boolean',
        ], [
            'edit_nom_prenom_stagiaire.required' => 'Le nom et prénom sont obligatoires.',
            'edit_date_naissance_stagiaire.before' => 'La date de naissance doit être dans le passé.',
            'edit_date_fin.after_or_equal' => 'La date de fin doit être après la date de démarrage.',
            'edit_note.max' => 'La note ne peut pas dépasser 20.',
        ]);

        $stagiaire->update([
            'nom_prenom_stagiaire' => trim($this->edit_nom_prenom_stagiaire),
            'date_naissance_stagiaire' => $this->edit_date_naissance_stagiaire ?: null,
            'lieu_naissance_stagiaire' => $this->edit_lieu_naissance_stagiaire ?: null,
            'contact_stagiaire' => $this->edit_contact_stagiaire ?: null,
            'contact_urgence_stagiaire' => $this->edit_contact_urgence_stagiaire ?: null,
            'nature_diplome' => $this->edit_nature_diplome ?: null,
            'numero_diplome' => $this->edit_numero_diplome ?: null,
            'session' => $this->edit_session ?: null,
            'option' => $this->edit_option ?: null,
            'annee_exercice' => $this->edit_annee_exercice ?: null,
            'service_accueil' => $this->edit_service_accueil ?: null,
            'maitre_stage' => $this->edit_maitre_stage ?: null,
            'date_demarrage' => $this->edit_date_demarrage ?: null,
            'date_fin' => $this->edit_date_fin ?: null,
            'theme_stage' => $this->edit_theme_stage ?: null,
            'note' => $this->edit_note !== '' ? (float) $this->edit_note : null,
            'appreciation' => $this->edit_appreciation ?: null,
            'inscri_emploi_jeune' => $this->edit_inscri_emploi_jeune,
        ]);

        $this->editMode = false;
        $this->resetErrorBag();
        session()->flash('success', "Les informations de {$stagiaire->nom_prenom_stagiaire} ont été mises à jour.");
    }

    // ═══════════════════════════════════════════════════════
    // SUPPRESSION
    // ═══════════════════════════════════════════════════════
    public function confirmDelete(): void
    {
        $this->authorizePersonnelManagement();
        //  CORRECTION : utilisation de $this->selectedStagiaire
        $stagiaire = $this->selectedStagiaire;
        if (! $stagiaire) {
            return;
        }

        $nom = $stagiaire->nom_prenom_stagiaire;

        $stagiaire->delete();

        $this->closeAgentModal();
        session()->flash('success', "Le stagiaire {$nom} a été supprimé.");
    }

    // ═══════════════════════════════════════════════════════
    // LIBELLÉS ÉTAPES
    // ═══════════════════════════════════════════════════════
    public function stepLabel(int $step): string
    {
        return match ($step) {
            1 => 'Identité',
            2 => 'Diplôme',
            3 => 'Stage',
            default => '',
        };
    }

    // ═══════════════════════════════════════════════════════
    // RENDU
    // ═══════════════════════════════════════════════════════
    public function render(): View
    {
        return view('livewire.personnels.create-stagiaire', [
            'stagiaires' => Stagiaire::latest()->paginate(10),
        ]);
    }
}
