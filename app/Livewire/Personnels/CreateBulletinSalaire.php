<?php

namespace App\Livewire\Personnels;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\Personnel\Agent;
use App\Models\Personnel\BulletinSalaire;
use Illuminate\Support\Facades\Log;

class CreateBulletinSalaire extends Component
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
    // RECHERCHE AGENT PAR MATRICULE
    // ═══════════════════════════════════════════════════════

    public string $matricule_search  = '';
    public string $agent_nom_prenom  = '';
    public string $agent_fonction    = '';
    public string $agent_categorie   = '';
    public string $agent_matricule   = '';
    public ?int   $agent_id          = null;
    public string $search_error      = '';
    public bool   $agent_found       = false;

    // ═══════════════════════════════════════════════════════
    // CHAMPS FORMULAIRE CRÉATION
    // ═══════════════════════════════════════════════════════

    public string $mois_paie            = '';   // format YYYY-MM
    public string $igr                  = '0';
    public string $impot_salaire        = '0';
    public string $contrib_nation       = '0';
    public string $indem_transp_cotation = '0'; // Caisse de retraite CNPS

    // ═══════════════════════════════════════════════════════
    // CHAMPS ÉDITION
    // ═══════════════════════════════════════════════════════

    public string $edit_mois_paie             = '';
    public string $edit_igr                   = '0';
    public string $edit_impot_salaire         = '0';
    public string $edit_contrib_nation        = '0';
    public string $edit_indem_transp_cotation = '0';

    // ═══════════════════════════════════════════════════════
    // FILTRE TABLE
    // ═══════════════════════════════════════════════════════

    public string $search_table   = '';
    public string $filtre_mois    = '';

    // ═══════════════════════════════════════════════════════
    // RECHERCHE AGENT
    // ═══════════════════════════════════════════════════════

    public function searchAgent(): void
    {
        $this->search_error   = '';
        $this->agent_found    = false;
        $this->agent_nom_prenom = '';
        $this->agent_id         = null;
        $this->agent_fonction   = '';
        $this->agent_categorie  = '';
        $this->agent_matricule  = '';

        $matricule = strtoupper(trim($this->matricule_search));
        if (empty($matricule)) {
            $this->search_error = 'Veuillez saisir un matricule.';
            return;
        }

        $agent = Agent::with('baremeSalarial', 'commune')
                      ->where('matricule', $matricule)
                      ->first();

        if (! $agent) {
            $this->search_error = "Aucun agent trouvé avec le matricule « {$matricule} ».";
            return;
        }

        $this->agent_id         = $agent->id;
        $this->agent_nom_prenom = $agent->nom_prenom_agent;
        $this->agent_fonction   = $agent->fonction ?? '';
        $this->agent_matricule  = $agent->matricule;
        $this->agent_categorie  = $agent->baremeSalarial?->categorie ?? '';
        $this->agent_found      = true;
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
        $this->matricule_search       = '';
        $this->agent_nom_prenom       = '';
        $this->agent_fonction         = '';
        $this->agent_categorie        = '';
        $this->agent_matricule        = '';
        $this->agent_id               = null;
        $this->search_error           = '';
        $this->agent_found            = false;
        $this->mois_paie              = '';
        $this->igr                    = '0';
        $this->impot_salaire          = '0';
        $this->contrib_nation         = '0';
        $this->indem_transp_cotation  = '0';
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // GESTION MODAL FICHE
    // ═══════════════════════════════════════════════════════

    public function viewFiche(int $id): void
    {
        $this->selectedId = $id;
        $this->editMode   = false;
        $this->resetErrorBag();
        $this->showFicheModal = true;
    }

    #[Computed]
    public function selectedBulletin(): ?BulletinSalaire
    {
        return $this->selectedId
            ? BulletinSalaire::with(['agent.baremeSalarial', 'agent.commune'])->find($this->selectedId)
            : null;
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
        $b = $this->selectedBulletin;
        if (! $b) return;

        $this->edit_mois_paie             = $b->mois_paie;
        $this->edit_igr                   = (string) $b->igr;
        $this->edit_impot_salaire         = (string) $b->impot_salaire;
        $this->edit_contrib_nation        = (string) $b->contrib_nation;
        $this->edit_indem_transp_cotation = (string) $b->indem_transp_cotation;

        $this->editMode = true;
    }

    public function cancelEdit(): void
    {
        $this->editMode = false;
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // CALCULS (helpers)
    // ═══════════════════════════════════════════════════════

    /**
     * Calcule tous les montants du bulletin pour un BulletinSalaire donné.
     * Retourne un array structuré utilisé dans la vue et le PDF.
     */
    public static function calculer(BulletinSalaire $b): array
    {
        $agent  = $b->agent;
        $bareme = $agent?->baremeSalarial;

        $salaire_base    = (float) ($bareme?->salaire_base    ?? 0);
        $indem_residence = (float) ($bareme?->indem_residence ?? 0);
        $salaire_brut    = (float) ($bareme?->salaire_brut    ?? 0);

        $igr             = (float) ($b->igr                   ?? 0);
        $impot_salaire   = (float) ($b->impot_salaire         ?? 0);
        $contrib_nation  = (float) ($b->contrib_nation        ?? 0);
        $cnps            = (float) ($b->indem_transp_cotation ?? 0); // caisse retraite CNPS

        $total_retenues  = $igr + $impot_salaire + $contrib_nation + $cnps;
        $salaire_net     = $salaire_brut - $total_retenues;

        $indem_transp    = (float) ($agent?->indem_transp   ?? 0);
        $indem_fonction  = (float) ($agent?->indem_fonction ?? 0);
        $indem_techn     = (float) ($agent?->indem_techn    ?? 0);

        $salaire_net_a_payer = $salaire_net + $indem_transp + $indem_fonction + $indem_techn;

        return compact(
            'salaire_base', 'indem_residence', 'salaire_brut',
            'igr', 'impot_salaire', 'contrib_nation', 'cnps',
            'total_retenues', 'salaire_net',
            'indem_transp', 'indem_fonction', 'indem_techn',
            'salaire_net_a_payer'
        );
    }

    // ═══════════════════════════════════════════════════════
    // VALIDATION
    // ═══════════════════════════════════════════════════════

    protected function rulesCreation(): array
    {
        return [
            'agent_id'             => 'required|integer|exists:agents,id',
            'mois_paie'            => 'required|string|regex:/^\d{4}-\d{2}$/',
            'igr'                  => 'required|numeric|min:0',
            'impot_salaire'        => 'required|numeric|min:0',
            'contrib_nation'       => 'required|numeric|min:0',
            'indem_transp_cotation' => 'required|numeric|min:0',
        ];
    }

    protected function messagesCreation(): array
    {
        return [
            'agent_id.required'     => 'Veuillez sélectionner un agent.',
            'mois_paie.required'    => 'Le mois de paie est obligatoire.',
            'mois_paie.regex'       => 'Le format doit être AAAA-MM (ex : 2025-01).',
            'igr.required'          => "L'IGR est obligatoire.",
            'igr.numeric'           => "L'IGR doit être un nombre.",
            'impot_salaire.numeric' => "L'impôt sur salaire doit être un nombre.",
            'contrib_nation.numeric'=> 'La contribution nationale doit être un nombre.',
            'indem_transp_cotation.numeric' => 'La caisse de retraite doit être un nombre.',
        ];
    }

    // ═══════════════════════════════════════════════════════
    // SAUVEGARDE
    // ═══════════════════════════════════════════════════════

    public function save(): void
    {
        $this->validate($this->rulesCreation(), $this->messagesCreation());

        // Vérifier unicité agent + mois
        $existe = BulletinSalaire::where('agent_id', $this->agent_id)
                                  ->where('mois_paie', $this->mois_paie)
                                  ->exists();
        if ($existe) {
            $this->addError('mois_paie', "Un bulletin existe déjà pour {$this->agent_nom_prenom} sur ce mois.");
            return;
        }

        try {
            BulletinSalaire::create([
                'agent_id'              => $this->agent_id,
                'mois_paie'             => $this->mois_paie,
                'igr'                   => (float) $this->igr,
                'impot_salaire'         => (float) $this->impot_salaire,
                'contrib_nation'        => (float) $this->contrib_nation,
                'indem_transp_cotation' => (float) $this->indem_transp_cotation,
            ]);
        } catch (\Throwable $e) {
            Log::error('Erreur création bulletin', ['message' => $e->getMessage()]);
            session()->flash('error', "Une erreur est survenue. Veuillez réessayer.");
            return;
        }

        $nom = $this->agent_nom_prenom;
        $this->closeModal();
        session()->flash('success', "Le bulletin de {$nom} pour {$this->formatMois($this->mois_paie)} a été créé.");
    }

    // ═══════════════════════════════════════════════════════
    // MISE À JOUR
    // ═══════════════════════════════════════════════════════

    public function update(): void
    {
        $b = $this->selectedBulletin;
        if (! $b) return;

        $this->validate([
            'edit_mois_paie'             => 'required|string|regex:/^\d{4}-\d{2}$/',
            'edit_igr'                   => 'required|numeric|min:0',
            'edit_impot_salaire'         => 'required|numeric|min:0',
            'edit_contrib_nation'        => 'required|numeric|min:0',
            'edit_indem_transp_cotation' => 'required|numeric|min:0',
        ], [
            'edit_mois_paie.required' => 'Le mois de paie est obligatoire.',
            'edit_mois_paie.regex'    => 'Le format doit être AAAA-MM.',
        ]);

        $b->update([
            'mois_paie'             => $this->edit_mois_paie,
            'igr'                   => (float) $this->edit_igr,
            'impot_salaire'         => (float) $this->edit_impot_salaire,
            'contrib_nation'        => (float) $this->edit_contrib_nation,
            'indem_transp_cotation' => (float) $this->edit_indem_transp_cotation,
        ]);

        $this->editMode = false;
        $this->resetErrorBag();
        session()->flash('success', 'Le bulletin a été mis à jour.');
        $this->closeFicheModal();
    }

    // ═══════════════════════════════════════════════════════
    // SUPPRESSION
    // ═══════════════════════════════════════════════════════

    public function confirmDelete(): void
    {
        $b = $this->selectedBulletin;
        if (! $b) return;

        $label = "{$b->agent?->nom_prenom_agent} — {$this->formatMois($b->mois_paie)}";
        $b->delete();

        $this->closeFicheModal();
        session()->flash('success', "Le bulletin de {$label} a été supprimé.");
    }

    // ═══════════════════════════════════════════════════════
    // HELPERS
    // ═══════════════════════════════════════════════════════

    public function formatMois(string $mois): string
    {
        if (! $mois) return '—';
        try {
            return \Carbon\Carbon::createFromFormat('Y-m', $mois)
                                  ->locale('fr')
                                  ->isoFormat('MMMM YYYY');
        } catch (\Throwable) {
            return $mois;
        }
    }

    public function updatedSearchTable(): void { $this->resetPage(); }
    public function updatedFiltreMois(): void  { $this->resetPage(); }

    // ═══════════════════════════════════════════════════════
    // RENDU
    // ═══════════════════════════════════════════════════════

    public function render(): \Illuminate\View\View
    {
        $bulletins = BulletinSalaire::with(['agent.baremeSalarial', 'agent.commune'])
            ->when($this->search_table, function ($q) {
                $q->whereHas('agent', fn ($qa) =>
                    $qa->where('nom_prenom_agent', 'like', "%{$this->search_table}%")
                       ->orWhere('matricule', 'like', "%{$this->search_table}%")
                );
            })
            ->when($this->filtre_mois, fn ($q) =>
                $q->where('mois_paie', $this->filtre_mois)
            )
            ->latest()
            ->paginate(12);

        return view('livewire.personnels.create-bulletin-salaire', [
            'bulletins' => $bulletins,
        ]);
    }
}
