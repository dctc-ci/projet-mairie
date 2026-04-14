<?php

namespace App\Livewire\Personnels;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Personnel\Agent;
use App\Models\Personnel\AgentNonPermanent;
use App\Models\Personnel\Stagiaire;
use App\Models\Personnel\Sollicitation;
use App\Models\Personnel\TypeSollicitation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CreateSollicitation extends Component
{
    use WithFileUploads;
    use WithPagination;

    // ═══════════════════════════════════════════════════════
    // ÉTAT DES MODALS
    // ═══════════════════════════════════════════════════════

    public bool $showModal      = false;
    public bool $showFicheModal = false;
    public bool $editMode       = false;
    public ?int $selectedId     = null;

    // ═══════════════════════════════════════════════════════
    // NAVIGATION ÉTAPES
    // ═══════════════════════════════════════════════════════

    public int $step     = 1;
    public int $maxSteps = 2;

    // ═══════════════════════════════════════════════════════
    // RECHERCHE PERSONNEL (modal création)
    // ═══════════════════════════════════════════════════════

    public string $type_personnel         = 'agent';
    public string $matricule_search       = '';
    public string $personnel_nom          = '';
    public ?int   $agent_id               = null;
    public ?int   $agent_non_permanent_id = null;
    public ?int   $stagiaire_id           = null;
    public string $search_error           = '';
    public bool   $personnel_found        = false;

    // ═══════════════════════════════════════════════════════
    // CHAMPS FORMULAIRE CRÉATION
    // ═══════════════════════════════════════════════════════

    public string $type_sollicitation_id = '';
    public int    $jours_sollicite       = 0;    // ✅ calculé auto depuis cessation→reprise
    public int    $jours_disponible_type = 0;    // ✅ plafond lu depuis le type sélectionné
    public string $motif_sollicitation   = '';
    public string $destination           = '';
    public string $date_sollicitation    = '';
    public string $date_cessation        = '';
    public string $date_depart           = '';
    public string $date_retour           = '';
    public string $date_reprise          = '';
    public string $etat_sollicitation    = 'en_attente';

    public string $signataire          = '';
    public string $fonction_signataire = '';
    public string $tranche_conge       = '';
    public string $observation_conge   = '';
    public        $justificatif        = null;
    public string $date_accident       = '';
    public string $lieu_accident       = '';
    public string $gravite_accident    = '';
    public bool   $declare_cnps        = false;
    public string $date_declare_cnps   = '';

    // ═══════════════════════════════════════════════════════
    // CHAMPS ÉDITION (préfixés edit_)
    // ═══════════════════════════════════════════════════════

    public string $edit_type_sollicitation_id = '';
    public int    $edit_jours_sollicite       = 0;
    public int    $edit_jours_disponible_type = 0;
    public string $edit_motif_sollicitation   = '';
    public string $edit_destination           = '';
    public string $edit_date_sollicitation    = '';
    public string $edit_date_cessation        = '';
    public string $edit_date_depart           = '';
    public string $edit_date_retour           = '';
    public string $edit_date_reprise          = '';
    public string $edit_etat_sollicitation    = 'en_attente';
    public string $edit_signataire            = '';
    public string $edit_fonction_signataire   = '';
    public string $edit_tranche_conge         = '';
    public string $edit_observation_conge     = '';
    public string $edit_date_accident         = '';
    public string $edit_lieu_accident         = '';
    public string $edit_gravite_accident      = '';
    public bool   $edit_declare_cnps          = false;
    public string $edit_date_declare_cnps     = '';

    // ═══════════════════════════════════════════════════════
    // MODAL FICHE
    // ═══════════════════════════════════════════════════════

    public string $fiche_matricule_search = '';
    public string $fiche_personnel_nom    = '';
    public ?int   $fiche_agent_id         = null;
    public ?int   $fiche_non_perm_id      = null;
    public ?int   $fiche_stagiaire_id     = null;
    public string $fiche_search_error     = '';
    public bool   $fiche_found            = false;

    // ═══════════════════════════════════════════════════════
    // HOOKS — CALCUL AUTOMATIQUE DES JOURS
    // ═══════════════════════════════════════════════════════

    /** Recalcule dès que cessation ou reprise change */
    public function updatedDateCessation(): void { $this->calculerJours(); }
    public function updatedDateReprise(): void   { $this->calculerJours(); }

    /** Recharge le plafond quand le type change */
    public function updatedTypeSollicitationId(string $id): void
    {
        $type = $id ? TypeSollicitation::find($id) : null;
        $this->jours_disponible_type = (int) ($type?->jours_disponible ?? 0);
    }

    /** Mode édition */
    public function updatedEditDateCessation(): void { $this->calculerJoursEdit(); }
    public function updatedEditDateReprise(): void   { $this->calculerJoursEdit(); }

    public function updatedEditTypeSollicitationId(string $id): void
    {
        $type = $id ? TypeSollicitation::find($id) : null;
        $this->edit_jours_disponible_type = (int) ($type?->jours_disponible ?? 0);
    }

    private function calculerJours(): void
    {
        $this->jours_sollicite = $this->diffJours($this->date_cessation, $this->date_reprise);
    }

    private function calculerJoursEdit(): void
    {
        $this->edit_jours_sollicite = $this->diffJours($this->edit_date_cessation, $this->edit_date_reprise);
    }

    private function diffJours(string $debut, string $fin): int
    {
        if (! $debut || ! $fin) return 0;
        try {
            return (int) max(0, Carbon::parse($debut)->diffInDays(Carbon::parse($fin)));
        } catch (\Throwable) {
            return 0;
        }
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
        $this->step                   = 1;
        $this->type_personnel         = 'agent';
        $this->matricule_search       = '';
        $this->personnel_nom          = '';
        $this->agent_id               = null;
        $this->agent_non_permanent_id = null;
        $this->stagiaire_id           = null;
        $this->search_error           = '';
        $this->personnel_found        = false;
        $this->type_sollicitation_id  = '';
        $this->jours_sollicite        = 0;
        $this->jours_disponible_type  = 0;
        $this->motif_sollicitation    = '';
        $this->destination            = '';
        $this->date_sollicitation     = '';
        $this->date_cessation         = '';
        $this->date_depart            = '';
        $this->date_retour            = '';
        $this->date_reprise           = '';
        $this->etat_sollicitation     = 'en_attente';
        $this->signataire             = '';
        $this->fonction_signataire    = '';
        $this->tranche_conge          = '';
        $this->observation_conge      = '';
        $this->justificatif           = null;
        $this->date_accident          = '';
        $this->lieu_accident          = '';
        $this->gravite_accident       = '';
        $this->declare_cnps           = false;
        $this->date_declare_cnps      = '';
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // GESTION MODAL FICHE
    // ═══════════════════════════════════════════════════════

    public function openFicheModal(): void
    {
        $this->resetFiche();
        $this->showFicheModal = true;
    }

    /**
     * ✅ FIX : bouton "→" de la table principale
     * Un seul wire:click="openFicheFromTable(id)" — plus de doublons.
     * Ouvre la fiche de l'agent lié et pré-sélectionne la sollicitation en édition.
     */
    public function openFicheFromTable(int $sollicitationId): void
    {
        $s = Sollicitation::with(['agent', 'agentNonPermanent', 'stagiaire'])->find($sollicitationId);
        if (! $s) return;

        $this->resetFiche();

        if ($s->agent_id && $s->agent) {
            $this->fiche_agent_id      = $s->agent_id;
            $this->fiche_personnel_nom = $s->agent->nom_prenom_agent;
            $this->fiche_found         = true;
        } elseif ($s->agent_non_permanent_id && $s->agentNonPermanent) {
            $this->fiche_non_perm_id   = $s->agent_non_permanent_id;
            $this->fiche_personnel_nom = $s->agentNonPermanent->nom_prenom_nopermanent;
            $this->fiche_found         = true;
        } elseif ($s->stagiaire_id && $s->stagiaire) {
            $this->fiche_stagiaire_id  = $s->stagiaire_id;
            $this->fiche_personnel_nom = $s->stagiaire->nom_prenom_stagiaire;
            $this->fiche_found         = true;
        }

        $this->showFicheModal = true;
        $this->editSollicitation($sollicitationId);
    }

    private function resetFiche(): void
    {
        $this->fiche_matricule_search = '';
        $this->fiche_personnel_nom    = '';
        $this->fiche_agent_id         = null;
        $this->fiche_non_perm_id      = null;
        $this->fiche_stagiaire_id     = null;
        $this->fiche_search_error     = '';
        $this->fiche_found            = false;
        $this->selectedId             = null;
        $this->editMode               = false;
        $this->resetErrorBag();
    }

    public function closeFicheModal(): void
    {
        $this->resetFiche();
        $this->showFicheModal = false;
    }

    public function searchFicheAgent(): void
    {
        $this->fiche_search_error  = '';
        $this->fiche_found         = false;
        $this->fiche_personnel_nom = '';
        $this->fiche_agent_id      = null;
        $this->fiche_non_perm_id   = null;
        $this->fiche_stagiaire_id  = null;
        $this->editMode            = false;
        $this->selectedId          = null;

        $matricule = strtoupper(trim($this->fiche_matricule_search));
        if (empty($matricule)) {
            $this->fiche_search_error = 'Veuillez saisir un matricule.';
            return;
        }

        $agent = Agent::where('matricule', $matricule)->first();
        if (! $agent) {
            $this->fiche_search_error = "Aucun agent trouvé avec le matricule « {$matricule} ».";
            return;
        }

        $this->fiche_agent_id      = $agent->id;
        $this->fiche_personnel_nom = $agent->nom_prenom_agent;
        $this->fiche_found         = true;
    }

    // Computed : sollicitations selon le contexte fiche
    public function getSollicitationsAgentProperty(): \Illuminate\Support\Collection
    {
        $q = Sollicitation::with('typeSollicitation')->latest('date_sollicitation');

        if ($this->fiche_agent_id) {
            $q->where('agent_id', $this->fiche_agent_id);
        } elseif ($this->fiche_non_perm_id) {
            $q->where('agent_non_permanent_id', $this->fiche_non_perm_id);
        } elseif ($this->fiche_stagiaire_id) {
            $q->where('stagiaire_id', $this->fiche_stagiaire_id);
        } else {
            return collect();
        }

        return $q->get();
    }

    public function getSelectedSollicitationProperty(): ?Sollicitation
    {
        return $this->selectedId ? Sollicitation::find($this->selectedId) : null;
    }

    // ═══════════════════════════════════════════════════════
    // ÉDITION
    // ═══════════════════════════════════════════════════════

    public function editSollicitation(int $id): void
    {
        $s = Sollicitation::with('typeSollicitation')->findOrFail($id);
        $this->selectedId = $s->id;

        $this->edit_type_sollicitation_id = (string) ($s->type_sollicitation_id ?? '');
        $this->edit_jours_sollicite       = (int) ($s->jours_sollicite ?? 0);
        $this->edit_jours_disponible_type = (int) ($s->typeSollicitation?->jours_disponible ?? 0);
        $this->edit_motif_sollicitation   = $s->motif_sollicitation  ?? '';
        $this->edit_destination           = $s->destination           ?? '';
        $this->edit_date_sollicitation    = $s->date_sollicitation  ? $s->date_sollicitation->format('Y-m-d')  : '';
        $this->edit_date_cessation        = $s->date_cessation      ? $s->date_cessation->format('Y-m-d')      : '';
        $this->edit_date_depart           = $s->date_depart         ? $s->date_depart->format('Y-m-d')         : '';
        $this->edit_date_retour           = $s->date_retour         ? $s->date_retour->format('Y-m-d')         : '';
        $this->edit_date_reprise          = $s->date_reprise        ? $s->date_reprise->format('Y-m-d')        : '';
        $this->edit_etat_sollicitation    = $s->etat_sollicitation   ?? 'en_attente';
        $this->edit_signataire            = $s->signataire           ?? '';
        $this->edit_fonction_signataire   = $s->fonction_signataire  ?? '';
        $this->edit_tranche_conge         = $s->tranche_conge        ?? '';
        $this->edit_observation_conge     = $s->observation_conge    ?? '';
        $this->edit_date_accident         = $s->date_accident       ? $s->date_accident->format('Y-m-d')      : '';
        $this->edit_lieu_accident         = $s->lieu_accident        ?? '';
        $this->edit_gravite_accident      = $s->gravite_accident     ?? '';
        $this->edit_declare_cnps          = (bool) ($s->declare_cnps ?? false);
        $this->edit_date_declare_cnps     = $s->date_declare_cnps  ? $s->date_declare_cnps->format('Y-m-d')  : '';

        $this->editMode = true;

        $this->calculerJoursEdit();
    }

    public function cancelEdit(): void
    {
        $this->editMode   = false;
        $this->selectedId = null;
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // RECHERCHE PERSONNEL (modal création)
    // ═══════════════════════════════════════════════════════

    public function updatedTypePersonnel(): void
    {
        $this->matricule_search       = '';
        $this->personnel_nom          = '';
        $this->agent_id               = null;
        $this->agent_non_permanent_id = null;
        $this->stagiaire_id           = null;
        $this->search_error           = '';
        $this->personnel_found        = false;
    }

    public function searchPersonnel(): void
    {
        $this->search_error           = '';
        $this->personnel_found        = false;
        $this->personnel_nom          = '';
        $this->agent_id               = null;
        $this->agent_non_permanent_id = null;
        $this->stagiaire_id           = null;

        $search = strtoupper(trim($this->matricule_search));
        if (empty($search)) {
            $this->search_error = 'Veuillez saisir un matricule ou un nom.';
            return;
        }

        if ($this->type_personnel === 'agent') {
            $p = Agent::where('matricule', $search)->first();
            if ($p) {
                $this->agent_id        = $p->id;
                $this->personnel_nom   = $p->nom_prenom_agent;
                $this->personnel_found = true;
            } else {
                $this->search_error = "Aucun agent permanent trouvé avec le matricule « {$search} ».";
            }
        } elseif ($this->type_personnel === 'non_permanent') {
            $p = AgentNonPermanent::whereRaw('UPPER(nom_prenom_nopermanent) LIKE ?', ["%{$search}%"])->first();
            if ($p) {
                $this->agent_non_permanent_id = $p->id;
                $this->personnel_nom          = $p->nom_prenom_nopermanent;
                $this->personnel_found        = true;
            } else {
                $this->search_error = "Aucun agent non permanent trouvé pour « {$search} ».";
            }
        } elseif ($this->type_personnel === 'stagiaire') {
            $p = Stagiaire::whereRaw('UPPER(nom_prenom_stagiaire) LIKE ?', ["%{$search}%"])->first();
            if ($p) {
                $this->stagiaire_id    = $p->id;
                $this->personnel_nom   = $p->nom_prenom_stagiaire;
                $this->personnel_found = true;
            } else {
                $this->search_error = "Aucun stagiaire trouvé pour « {$search} ».";
            }
        }
    }

    // ═══════════════════════════════════════════════════════
    // UPLOAD
    // ═══════════════════════════════════════════════════════

    public function updatedJustificatif(): void
    {
        $this->validateOnly('justificatif', [
            'justificatif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'justificatif.mimes' => 'Le fichier doit être un PDF ou une image.',
            'justificatif.max'   => 'Le fichier ne doit pas dépasser 5 Mo.',
        ]);
    }

    // ═══════════════════════════════════════════════════════
    // VALIDATION
    // ═══════════════════════════════════════════════════════

    protected function rulesForStep(int $step): array
    {
        $joursDispo = $this->jours_disponible_type;

        return match ($step) {
            1 => [
                'type_sollicitation_id' => 'required|exists:type_sollicitations,id',
                'jours_sollicite'       => [
                    'integer', 'min:0',
                    function ($a, $value, $fail) use ($joursDispo) {
                        if ($joursDispo > 0 && $value > $joursDispo) {
                            $fail("Jours demandés ({$value}j) > plafond ({$joursDispo}j) pour ce type.");
                        }
                    },
                ],
                'motif_sollicitation'   => 'nullable|string|max:255',
                'destination'           => 'nullable|string|max:150',
                'date_sollicitation'    => 'required|date',
                'date_cessation'        => 'nullable|date',
                'date_depart'           => 'nullable|date',
                'date_retour'           => 'nullable|date|after_or_equal:date_depart',
                'date_reprise'          => 'nullable|date|after_or_equal:date_cessation',
                'etat_sollicitation'    => 'required|in:en_attente,approuvee,rejetee,annulee',
            ],
            2 => [
                'signataire'          => 'nullable|string|max:150',
                'fonction_signataire' => 'nullable|string|max:100',
                'tranche_conge'       => 'nullable|string|max:50',
                'observation_conge'   => 'nullable|string',
                'justificatif'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'date_accident'       => 'nullable|date',
                'lieu_accident'       => 'nullable|string|max:150',
                'gravite_accident'    => 'nullable|string|max:50',
                'declare_cnps'        => 'boolean',
                'date_declare_cnps'   => 'nullable|date',
            ],
            default => [],
        };
    }

    protected function messagesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'type_sollicitation_id.required' => 'Veuillez sélectionner un type de sollicitation.',
                'date_sollicitation.required'    => 'La date de sollicitation est obligatoire.',
                'date_retour.after_or_equal'     => 'La date de retour doit être après la date de départ.',
                'date_reprise.after_or_equal'    => 'La date de reprise doit être après la date de cessation.',
            ],
            default => [],
        };
    }

    // ═══════════════════════════════════════════════════════
    // NAVIGATION ÉTAPES
    // ═══════════════════════════════════════════════════════

    public function nextStep(): void
    {
        if ($this->step === 1 && ! $this->personnel_found) {
            $this->addError('personnel', 'Veuillez sélectionner un agent ou stagiaire.');
            return;
        }
        $this->validate($this->rulesForStep($this->step), $this->messagesForStep($this->step));
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
    // SAUVEGARDE
    // ═══════════════════════════════════════════════════════

    public function save(): void
    {
        $this->validate($this->rulesForStep(2), $this->messagesForStep(2));

        $nomPersonnel = $this->personnel_nom;

        try {
            DB::transaction(function () {
                $justifPath = null;
                if ($this->justificatif) {
                    $justifPath = $this->justificatif->store('sollicitations/justificatifs', 'public');
                }

                Sollicitation::create([
                    'agent_id'               => $this->agent_id,
                    'agent_non_permanent_id' => $this->agent_non_permanent_id,
                    'stagiaire_id'           => $this->stagiaire_id,
                    'type_sollicitation_id'  => $this->type_sollicitation_id  ?: null,
                    'jours_sollicite'        => $this->jours_sollicite,
                    'motif_sollicitation'    => $this->motif_sollicitation    ?: null,
                    'destination'            => $this->destination            ?: null,
                    'date_sollicitation'     => $this->date_sollicitation     ?: null,
                    'date_cessation'         => $this->date_cessation         ?: null,
                    'date_depart'            => $this->date_depart            ?: null,
                    'date_retour'            => $this->date_retour            ?: null,
                    'date_reprise'           => $this->date_reprise           ?: null,
                    'etat_sollicitation'     => $this->etat_sollicitation,
                    'signataire'             => $this->signataire             ?: null,
                    'fonction_signataire'    => $this->fonction_signataire    ?: null,
                    'tranche_conge'          => $this->tranche_conge          ?: null,
                    'observation_conge'      => $this->observation_conge      ?: null,
                    'justificatif'           => $justifPath,
                    'date_accident'          => $this->date_accident          ?: null,
                    'lieu_accident'          => $this->lieu_accident          ?: null,
                    'gravite_accident'       => $this->gravite_accident       ?: null,
                    'declare_cnps'           => $this->declare_cnps,
                    'date_declare_cnps'      => $this->date_declare_cnps      ?: null,
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('Erreur création sollicitation', ['message' => $e->getMessage()]);
            session()->flash('error', "Une erreur est survenue. Veuillez réessayer.");
            return;
        }

        $this->closeModal();
        session()->flash('success', "La sollicitation de {$nomPersonnel} a été enregistrée avec succès.");
    }

    // ═══════════════════════════════════════════════════════
    // MISE À JOUR
    // ═══════════════════════════════════════════════════════

    public function updateSollicitation(): void
    {
        $s = $this->selectedSollicitation;
        if (! $s) return;

        $joursDispo = $this->edit_jours_disponible_type;

        $this->validate([
            'edit_type_sollicitation_id' => 'required|exists:type_sollicitations,id',
            'edit_jours_sollicite'       => [
                'integer', 'min:0',
                function ($a, $value, $fail) use ($joursDispo) {
                    if ($joursDispo > 0 && $value > $joursDispo) {
                        $fail("Jours demandés ({$value}j) > plafond ({$joursDispo}j).");
                    }
                },
            ],
            'edit_motif_sollicitation'   => 'nullable|string|max:255',
            'edit_destination'           => 'nullable|string|max:150',
            'edit_date_sollicitation'    => 'required|date',
            'edit_date_cessation'        => 'nullable|date',
            'edit_date_depart'           => 'nullable|date',
            'edit_date_retour'           => 'nullable|date|after_or_equal:edit_date_depart',
            'edit_date_reprise'          => 'nullable|date|after_or_equal:edit_date_cessation',
            'edit_etat_sollicitation'    => 'required|in:en_attente,approuvee,rejetee,annulee',
            'edit_signataire'            => 'nullable|string|max:150',
            'edit_fonction_signataire'   => 'nullable|string|max:100',
            'edit_tranche_conge'         => 'nullable|string|max:50',
            'edit_observation_conge'     => 'nullable|string',
            'edit_date_accident'         => 'nullable|date',
            'edit_lieu_accident'         => 'nullable|string|max:150',
            'edit_gravite_accident'      => 'nullable|string|max:50',
            'edit_declare_cnps'          => 'boolean',
            'edit_date_declare_cnps'     => 'nullable|date',
        ], [
            'edit_type_sollicitation_id.required' => 'Le type est obligatoire.',
            'edit_date_sollicitation.required'    => 'La date de sollicitation est obligatoire.',
            'edit_date_retour.after_or_equal'     => 'Date retour doit être après date départ.',
            'edit_date_reprise.after_or_equal'    => 'Date reprise doit être après date cessation.',
        ]);

        $s->update([
            'type_sollicitation_id' => $this->edit_type_sollicitation_id ?: null,
            'jours_sollicite'       => $this->edit_jours_sollicite,
            'motif_sollicitation'   => $this->edit_motif_sollicitation   ?: null,
            'destination'           => $this->edit_destination           ?: null,
            'date_sollicitation'    => $this->edit_date_sollicitation    ?: null,
            'date_cessation'        => $this->edit_date_cessation        ?: null,
            'date_depart'           => $this->edit_date_depart           ?: null,
            'date_retour'           => $this->edit_date_retour           ?: null,
            'date_reprise'          => $this->edit_date_reprise          ?: null,
            'etat_sollicitation'    => $this->edit_etat_sollicitation,
            'signataire'            => $this->edit_signataire            ?: null,
            'fonction_signataire'   => $this->edit_fonction_signataire   ?: null,
            'tranche_conge'         => $this->edit_tranche_conge         ?: null,
            'observation_conge'     => $this->edit_observation_conge     ?: null,
            'date_accident'         => $this->edit_date_accident         ?: null,
            'lieu_accident'         => $this->edit_lieu_accident         ?: null,
            'gravite_accident'      => $this->edit_gravite_accident      ?: null,
            'declare_cnps'          => $this->edit_declare_cnps,
            'date_declare_cnps'     => $this->edit_date_declare_cnps     ?: null,
        ]);

        $this->editMode   = false;
        $this->selectedId = null;
        $this->resetErrorBag();
        session()->flash('success_fiche', 'La sollicitation a été mise à jour.');
    }

    // ═══════════════════════════════════════════════════════
    // SUPPRESSION
    // ═══════════════════════════════════════════════════════

    public function deleteSollicitation(int $id): void
    {
        $s = Sollicitation::find($id);
        if ($s) {
            if ($s->justificatif) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($s->justificatif);
            }
            $s->delete();
            session()->flash('success_fiche', 'La sollicitation a été supprimée.');
        }
    }

    // ═══════════════════════════════════════════════════════
    // HELPERS
    // ═══════════════════════════════════════════════════════

    public function stepLabel(int $step): string
    {
        return match ($step) {
            1 => 'Sollicitation', 2 => 'Détails', default => '',
        };
    }

    // ═══════════════════════════════════════════════════════
    // RENDU
    // ═══════════════════════════════════════════════════════

    public function render(): \Illuminate\View\View
    {
        return view('livewire.personnels.create-sollicitation', [
            'sollicitations' => Sollicitation::with(['typeSollicitation', 'agent', 'agentNonPermanent', 'stagiaire'])
                                             ->latest('date_sollicitation')
                                             ->paginate(10),
            'types'          => TypeSollicitation::orderBy('libelle')->get(),

            'sollicitationsAgent' => $this->showFicheModal ? $this->getSollicitationsAgentProperty() : collect(),
            'selectedSollicitation' => $this->selectedId ? Sollicitation::find($this->selectedId) : null,
        ]);
    }
}
