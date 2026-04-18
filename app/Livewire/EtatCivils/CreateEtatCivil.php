<?php

namespace App\Livewire\EtatCivils;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use App\Models\EtatCivil\Extrait;
use App\Models\EtatCivil\Mention;
use App\Models\Personnel\Commune;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateEtatCivil extends Component
{
    use WithPagination;

    // ═══════════════════════════════════════════════════════
    // ÉTAT DES MODALS
    // ═══════════════════════════════════════════════════════

    public bool $showModal      = false;
    public bool $showFicheModal = false;
    public bool $editMode       = false;
    public ?int $selectedId     = null;   // ID extrait sélectionné

    // ═══════════════════════════════════════════════════════
    // NAVIGATION ÉTAPES (6 étapes)
    // ═══════════════════════════════════════════════════════

    public int $step     = 1;
    public int $maxSteps = 6;

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 1 — Commune & Registre
    // ═══════════════════════════════════════════════════════

    public string $commune_id               = '';
    public string $centr_etat_civil         = '';
    public string $annee_registre_extrai    = '';
    public string $nature_declarat_extrai   = '';
    public string $numero_registre_extrai   = '';
    public string $numero_act_extrai        = '';
    public string $numero_complet_act_extrai = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 2 — Officier & Dates
    // ═══════════════════════════════════════════════════════

    public string $officier_etat_civil               = '';
    public string $qualite                           = '';
    public string $nous_avons_signer                 = '';
    public string $date_dressage                     = '';
    public string $heure_dressage                    = '';
    public string $date_dressage_copie_integrale     = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 3 — Enfant
    // ═══════════════════════════════════════════════════════

    public string $nom_enfant             = '';
    public string $prenom_enfant          = '';
    public string $date_naissance_lettre  = '';
    public string $date_naissance         = '';
    public string $heure_min_naissance    = '';
    public string $lieux_naissance        = '';
    public string $sexe                   = '';
    public string $fils_fille             = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 4 — Père
    // ═══════════════════════════════════════════════════════

    public string $nom_prenom_pere      = '';
    public string $date_naissance_pere  = '';
    public string $annee_naissance_pere = '';
    public string $lieu_naissance_pere  = '';
    public string $profession_pere      = '';
    public string $nationnalite_pere    = '';
    public string $domicile_pere        = '';
    public string $nature_piece_pere    = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 5 — Mère
    // ═══════════════════════════════════════════════════════

    public string $nom_prenom_mere      = '';
    public string $date_naissance_mere  = '';
    public string $annee_naissance_mere = '';
    public string $profession_mere      = '';
    public string $nationalite_mere     = '';
    public string $domicile_mere        = '';
    public string $nature_piece_mere    = '';

    // ═══════════════════════════════════════════════════════
    // ÉTAPE 6 — Déclarant, Témoins & Mentions
    // ═══════════════════════════════════════════════════════

    public string $info_declarant = '';
    public string $info_temoin_1  = '';
    public string $info_temoin_2  = '';

    // Mentions à créer (liste dynamique)
    public array $mentions = [];

    // ═══════════════════════════════════════════════════════
    // CHAMPS ÉDITION (extrait)
    // ═══════════════════════════════════════════════════════

    public string $edit_commune_id               = '';
    public string $edit_centr_etat_civil         = '';
    public string $edit_annee_registre_extrai    = '';
    public string $edit_nature_declarat_extrai   = '';
    public string $edit_numero_registre_extrai   = '';
    public string $edit_numero_act_extrai        = '';
    public string $edit_numero_complet_act_extrai = '';
    public string $edit_officier_etat_civil      = '';
    public string $edit_qualite                  = '';
    public string $edit_nous_avons_signer        = '';
    public string $edit_date_dressage            = '';
    public string $edit_heure_dressage           = '';
    public string $edit_date_dressage_copie_integrale = '';
    public string $edit_nom_enfant               = '';
    public string $edit_prenom_enfant            = '';
    public string $edit_date_naissance_lettre    = '';
    public string $edit_date_naissance           = '';
    public string $edit_heure_min_naissance      = '';
    public string $edit_lieux_naissance          = '';
    public string $edit_sexe                     = '';
    public string $edit_fils_fille               = '';
    public string $edit_nom_prenom_pere          = '';
    public string $edit_date_naissance_pere      = '';
    public string $edit_annee_naissance_pere     = '';
    public string $edit_lieu_naissance_pere      = '';
    public string $edit_profession_pere          = '';
    public string $edit_nationnalite_pere        = '';
    public string $edit_domicile_pere            = '';
    public string $edit_nature_piece_pere        = '';
    public string $edit_nom_prenom_mere          = '';
    public string $edit_date_naissance_mere      = '';
    public string $edit_annee_naissance_mere     = '';
    public string $edit_profession_mere          = '';
    public string $edit_nationalite_mere         = '';
    public string $edit_domicile_mere            = '';
    public string $edit_nature_piece_mere        = '';
    public string $edit_info_declarant           = '';
    public string $edit_info_temoin_1            = '';
    public string $edit_info_temoin_2            = '';

    // ═══════════════════════════════════════════════════════
    // MENTIONS — AJOUT/ÉDITION INLINE
    // ═══════════════════════════════════════════════════════

    public bool   $showMentionForm   = false;
    public ?int   $editingMentionId  = null;  // null = création, sinon = édition

    // Champs du formulaire mention
    public string $m_date_mariage_mention        = '';
    public string $m_lieu_mariage_mention        = '';
    public string $m_nom_prenom_conjoint_mention = '';
    public string $m_date_mariage_dissous        = '';
    public string $m_ref_act_dissous             = '';
    public string $m_date_deces_mention          = '';
    public string $m_lieu_deces_mention          = '';
    public string $m_mention_reconnaissance      = '';
    public string $m_mention_rectification       = '';
    public string $m_mention_adoption            = '';
    public string $m_mention_retablissement      = '';

    // ═══════════════════════════════════════════════════════
    // RECHERCHE / FILTRE TABLE
    // ═══════════════════════════════════════════════════════

    public string $search          = '';
    public string $filtre_commune  = '';
    public string $filtre_annee    = '';

    // ═══════════════════════════════════════════════════════
    // COMPUTED
    // ═══════════════════════════════════════════════════════

    #[Computed]
    public function communes(): \Illuminate\Support\Collection
    {
        return Commune::orderBy('nom_commune')->get();
    }

    #[Computed]
    public function selectedExtrait(): ?Extrait
    {
        return $this->selectedId
            ? Extrait::with(['commune', 'mentions'])->find($this->selectedId)
            : null;
    }

    #[Computed]
    public function mentionsExtrait(): \Illuminate\Support\Collection
    {
        return $this->selectedId
            ? Mention::where('extrait_id', $this->selectedId)->latest()->get()
            : collect();
    }

    // ═══════════════════════════════════════════════════════
    // HOOKS
    // ═══════════════════════════════════════════════════════

    public function updatedSexe(string $val): void
    {
        $this->fils_fille = ($val === 'M') ? 'fils' : 'fille';
    }

    public function updatedEditSexe(string $val): void
    {
        $this->edit_fils_fille = ($val === 'M') ? 'fils' : 'fille';
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
        $this->step                       = 1;
        $this->commune_id                 = '';
        $this->centr_etat_civil           = '';
        $this->annee_registre_extrai      = (string) date('Y');
        $this->nature_declarat_extrai     = '';
        $this->numero_registre_extrai     = '';
        $this->numero_act_extrai          = '';
        $this->numero_complet_act_extrai  = '';
        $this->officier_etat_civil        = '';
        $this->qualite                    = '';
        $this->nous_avons_signer          = '';
        $this->date_dressage              = '';
        $this->heure_dressage             = '';
        $this->date_dressage_copie_integrale = '';
        $this->nom_enfant                 = '';
        $this->prenom_enfant              = '';
        $this->date_naissance_lettre      = '';
        $this->date_naissance             = '';
        $this->heure_min_naissance        = '';
        $this->lieux_naissance            = '';
        $this->sexe                       = '';
        $this->fils_fille                 = '';
        $this->nom_prenom_pere            = '';
        $this->date_naissance_pere        = '';
        $this->annee_naissance_pere       = '';
        $this->lieu_naissance_pere        = '';
        $this->profession_pere            = '';
        $this->nationnalite_pere          = '';
        $this->domicile_pere              = '';
        $this->nature_piece_pere          = '';
        $this->nom_prenom_mere            = '';
        $this->date_naissance_mere        = '';
        $this->annee_naissance_mere       = '';
        $this->profession_mere            = '';
        $this->nationalite_mere           = '';
        $this->domicile_mere              = '';
        $this->nature_piece_mere          = '';
        $this->info_declarant             = '';
        $this->info_temoin_1              = '';
        $this->info_temoin_2              = '';
        $this->mentions                   = [];
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // GESTION MODAL FICHE
    // ═══════════════════════════════════════════════════════

    public function viewFiche(int $id): void
    {
        $this->selectedId      = $id;
        $this->editMode        = false;
        $this->showMentionForm = false;
        $this->editingMentionId = null;
        $this->resetErrorBag();
        $this->showFicheModal  = true;
    }

    public function closeFicheModal(): void
    {
        $this->showFicheModal   = false;
        $this->selectedId       = null;
        $this->editMode         = false;
        $this->showMentionForm  = false;
        $this->editingMentionId = null;
        $this->resetErrorBag();
    }

    public function enableEditMode(): void
    {
        $e = $this->selectedExtrait;
        if (! $e) return;

        $this->edit_commune_id               = (string) ($e->commune_id ?? '');
        $this->edit_centr_etat_civil         = $e->centr_etat_civil          ?? '';
        $this->edit_annee_registre_extrai    = (string) ($e->annee_registre_extrai ?? '');
        $this->edit_nature_declarat_extrai   = $e->nature_declarat_extrai    ?? '';
        $this->edit_numero_registre_extrai   = $e->numero_registre_extrai    ?? '';
        $this->edit_numero_act_extrai        = $e->numero_act_extrai         ?? '';
        $this->edit_numero_complet_act_extrai = $e->numero_complet_act_extrai ?? '';
        $this->edit_officier_etat_civil      = $e->officier_etat_civil       ?? '';
        $this->edit_qualite                  = $e->qualite                   ?? '';
        $this->edit_nous_avons_signer        = $e->nous_avons_signer         ?? '';
        $this->edit_date_dressage            = $e->date_dressage             ? $e->date_dressage->format('Y-m-d')   : '';
        $this->edit_heure_dressage           = $e->heure_dressage            ?? '';
        $this->edit_date_dressage_copie_integrale = $e->date_dressage_copie_integrale ? $e->date_dressage_copie_integrale->format('Y-m-d') : '';
        $this->edit_nom_enfant               = $e->nom_enfant                ?? '';
        $this->edit_prenom_enfant            = $e->prenom_enfant             ?? '';
        $this->edit_date_naissance_lettre    = $e->date_naissance_lettre     ?? '';
        $this->edit_date_naissance           = $e->date_naissance            ? $e->date_naissance->format('Y-m-d') : '';
        $this->edit_heure_min_naissance      = $e->heure_min_naissance       ?? '';
        $this->edit_lieux_naissance          = $e->lieux_naissance           ?? '';
        $this->edit_sexe                     = $e->sexe                      ?? '';
        $this->edit_fils_fille               = $e->fils_fille                ?? '';
        $this->edit_nom_prenom_pere          = $e->nom_prenom_pere           ?? '';
        $this->edit_date_naissance_pere      = $e->date_naissance_pere       ? $e->date_naissance_pere->format('Y-m-d') : '';
        $this->edit_annee_naissance_pere     = (string) ($e->annee_naissance_pere ?? '');
        $this->edit_lieu_naissance_pere      = $e->lieu_naissance_pere       ?? '';
        $this->edit_profession_pere          = $e->profession_pere           ?? '';
        $this->edit_nationnalite_pere        = $e->nationnalite_pere         ?? '';
        $this->edit_domicile_pere            = $e->domicile_pere             ?? '';
        $this->edit_nature_piece_pere        = $e->nature_piece_pere         ?? '';
        $this->edit_nom_prenom_mere          = $e->nom_prenom_mere           ?? '';
        $this->edit_date_naissance_mere      = $e->date_naissance_mere       ? $e->date_naissance_mere->format('Y-m-d') : '';
        $this->edit_annee_naissance_mere     = (string) ($e->annee_naissance_mere ?? '');
        $this->edit_profession_mere          = $e->profession_mere           ?? '';
        $this->edit_nationalite_mere         = $e->nationalite_mere          ?? '';
        $this->edit_domicile_mere            = $e->domicile_mere             ?? '';
        $this->edit_nature_piece_mere        = $e->nature_piece_mere         ?? '';
        $this->edit_info_declarant           = $e->info_declarant            ?? '';
        $this->edit_info_temoin_1            = $e->info_temoin_1             ?? '';
        $this->edit_info_temoin_2            = $e->info_temoin_2             ?? '';

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
                'commune_id'            => 'required|exists:communes,id',
                'annee_registre_extrai' => 'required|integer|min:1900|max:' . (date('Y') + 1),
                'numero_act_extrai'     => 'required|string|max:50',
            ],
            2 => [
                'officier_etat_civil' => 'nullable|string|max:150',
                'date_dressage'       => 'required|date',
            ],
            3 => [
                'nom_enfant'    => 'required|string|max:100',
                'prenom_enfant' => 'required|string|max:100',
                'date_naissance'=> 'required|date',
                'sexe'          => 'required|in:M,F',
            ],
            4, 5, 6 => [],
            default  => [],
        };
    }

    protected function messagesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'commune_id.required'            => 'La commune est obligatoire.',
                'commune_id.exists'              => 'Commune invalide.',
                'annee_registre_extrai.required' => 'L\'année du registre est obligatoire.',
                'numero_act_extrai.required'     => 'Le numéro d\'acte est obligatoire.',
            ],
            2 => ['date_dressage.required' => 'La date de dressage est obligatoire.'],
            3 => [
                'nom_enfant.required'   => 'Le nom de l\'enfant est obligatoire.',
                'prenom_enfant.required'=> 'Le prénom de l\'enfant est obligatoire.',
                'date_naissance.required'=>'La date de naissance est obligatoire.',
                'sexe.required'         => 'Le sexe est obligatoire.',
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
            2 => 'Officier',
            3 => 'Enfant',
            4 => 'Père',
            5 => 'Mère',
            6 => 'Déclarant',
            default => '',
        };
    }

    // ═══════════════════════════════════════════════════════
    // MENTIONS — GESTION LISTE (étape 6, avant sauvegarde)
    // ═══════════════════════════════════════════════════════

    public function ajouterMentionListe(): void
    {
        $this->mentions[] = [
            'date_mariage_mention'        => '',
            'lieu_mariage_mention'        => '',
            'nom_prenom_conjoint_mention' => '',
            'date_mariage_dissous'        => '',
            'ref_act_dissous'             => '',
            'date_deces_mention'          => '',
            'lieu_deces_mention'          => '',
            'mention_reconnaissance'      => '',
            'mention_rectification'       => '',
            'mention_adoption'            => '',
            'mention_retablissement'      => '',
        ];
    }

    public function supprimerMentionListe(int $index): void
    {
        array_splice($this->mentions, $index, 1);
        $this->mentions = array_values($this->mentions);
    }

    // ═══════════════════════════════════════════════════════
    // MENTIONS — CRUD EN BASE (modal fiche)
    // ═══════════════════════════════════════════════════════

    public function openMentionForm(?int $mentionId = null): void
    {
        $this->resetMentionForm();
        $this->showMentionForm  = true;
        $this->editingMentionId = $mentionId;

        if ($mentionId) {
            $m = Mention::find($mentionId);
            if ($m) {
                $this->m_date_mariage_mention        = $m->date_mariage_mention        ? $m->date_mariage_mention->format('Y-m-d')  : '';
                $this->m_lieu_mariage_mention        = $m->lieu_mariage_mention        ?? '';
                $this->m_nom_prenom_conjoint_mention = $m->nom_prenom_conjoint_mention ?? '';
                $this->m_date_mariage_dissous        = $m->date_mariage_dissous        ? $m->date_mariage_dissous->format('Y-m-d') : '';
                $this->m_ref_act_dissous             = $m->ref_act_dissous             ?? '';
                $this->m_date_deces_mention          = $m->date_deces_mention          ? $m->date_deces_mention->format('Y-m-d')   : '';
                $this->m_lieu_deces_mention          = $m->lieu_deces_mention          ?? '';
                $this->m_mention_reconnaissance      = $m->mention_reconnaissance      ?? '';
                $this->m_mention_rectification       = $m->mention_rectification       ?? '';
                $this->m_mention_adoption            = $m->mention_adoption            ?? '';
                $this->m_mention_retablissement      = $m->mention_retablissement      ?? '';
            }
        }
    }

    public function closeMentionForm(): void
    {
        $this->showMentionForm  = false;
        $this->editingMentionId = null;
        $this->resetMentionForm();
        $this->resetErrorBag();
    }

    private function resetMentionForm(): void
    {
        $this->m_date_mariage_mention        = '';
        $this->m_lieu_mariage_mention        = '';
        $this->m_nom_prenom_conjoint_mention = '';
        $this->m_date_mariage_dissous        = '';
        $this->m_ref_act_dissous             = '';
        $this->m_date_deces_mention          = '';
        $this->m_lieu_deces_mention          = '';
        $this->m_mention_reconnaissance      = '';
        $this->m_mention_rectification       = '';
        $this->m_mention_adoption            = '';
        $this->m_mention_retablissement      = '';
    }

    public function saveMention(): void
    {
        $this->validate([
            'm_date_mariage_mention'        => 'nullable|date',
            'm_lieu_mariage_mention'        => 'nullable|string|max:150',
            'm_nom_prenom_conjoint_mention' => 'nullable|string|max:150',
            'm_date_mariage_dissous'        => 'nullable|date',
            'm_ref_act_dissous'             => 'nullable|string|max:100',
            'm_date_deces_mention'          => 'nullable|date',
            'm_lieu_deces_mention'          => 'nullable|string|max:150',
            'm_mention_reconnaissance'      => 'nullable|string',
            'm_mention_rectification'       => 'nullable|string',
            'm_mention_adoption'            => 'nullable|string',
            'm_mention_retablissement'      => 'nullable|string',
        ]);

        $data = [
            'commune_id'                  => $this->selectedExtrait?->commune_id,
            'extrait_id'                  => $this->selectedId,
            'date_mariage_mention'        => $this->m_date_mariage_mention        ?: null,
            'lieu_mariage_mention'        => $this->m_lieu_mariage_mention        ?: null,
            'nom_prenom_conjoint_mention' => $this->m_nom_prenom_conjoint_mention ?: null,
            'date_mariage_dissous'        => $this->m_date_mariage_dissous        ?: null,
            'ref_act_dissous'             => $this->m_ref_act_dissous             ?: null,
            'date_deces_mention'          => $this->m_date_deces_mention          ?: null,
            'lieu_deces_mention'          => $this->m_lieu_deces_mention          ?: null,
            'mention_reconnaissance'      => $this->m_mention_reconnaissance      ?: null,
            'mention_rectification'       => $this->m_mention_rectification       ?: null,
            'mention_adoption'            => $this->m_mention_adoption            ?: null,
            'mention_retablissement'      => $this->m_mention_retablissement      ?: null,
        ];

        if ($this->editingMentionId) {
            Mention::find($this->editingMentionId)?->update($data);
            session()->flash('success_fiche', 'La mention a été modifiée.');
        } else {
            Mention::create($data);
            session()->flash('success_fiche', 'La mention a été ajoutée.');
        }

        $this->closeMentionForm();
    }

    public function deleteMention(int $id): void
    {
        Mention::find($id)?->delete();
        session()->flash('success_fiche', 'La mention a été supprimée.');
    }

    // ═══════════════════════════════════════════════════════
    // SAUVEGARDE EXTRAIT (CRÉATION)
    // ═══════════════════════════════════════════════════════

    public function save(): void
    {
        $rules = $this->rulesForStep($this->step);
        if (! empty($rules)) {
            $this->validate($rules, $this->messagesForStep($this->step));
        }
        
        sleep(1); // Permet de visualiser le loader calmement

        $nomEnfant = strtoupper($this->nom_enfant) . ' ' . $this->prenom_enfant;

        try {
            DB::transaction(function () {
                $extrait = Extrait::create([
                    'commune_id'                  => $this->commune_id,
                    'centr_etat_civil'            => $this->centr_etat_civil            ?: null,
                    'annee_registre_extrai'       => $this->annee_registre_extrai       ?: null,
                    'nature_declarat_extrai'      => $this->nature_declarat_extrai      ?: null,
                    'numero_registre_extrai'      => $this->numero_registre_extrai      ?: null,
                    'numero_act_extrai'           => $this->numero_act_extrai           ?: null,
                    'numero_complet_act_extrai'   => $this->numero_complet_act_extrai   ?: null,
                    'officier_etat_civil'         => $this->officier_etat_civil         ?: null,
                    'qualite'                     => $this->qualite                     ?: null,
                    'nous_avons_signer'           => $this->nous_avons_signer           ?: null,
                    'date_dressage'               => $this->date_dressage               ?: null,
                    'heure_dressage'              => $this->heure_dressage              ?: null,
                    'date_dressage_copie_integrale' => $this->date_dressage_copie_integrale ?: null,
                    'nom_enfant'                  => strtoupper($this->nom_enfant)      ?: null,
                    'prenom_enfant'               => $this->prenom_enfant               ?: null,
                    'date_naissance_lettre'       => $this->date_naissance_lettre       ?: null,
                    'date_naissance'              => $this->date_naissance              ?: null,
                    'heure_min_naissance'         => $this->heure_min_naissance         ?: null,
                    'lieux_naissance'             => $this->lieux_naissance             ?: null,
                    'sexe'                        => $this->sexe                        ?: null,
                    'fils_fille'                  => $this->fils_fille                  ?: null,
                    'nom_prenom_pere'             => strtoupper($this->nom_prenom_pere) ?: null,
                    'date_naissance_pere'         => $this->date_naissance_pere         ?: null,
                    'annee_naissance_pere'        => $this->annee_naissance_pere        ?: null,
                    'lieu_naissance_pere'         => $this->lieu_naissance_pere         ?: null,
                    'profession_pere'             => $this->profession_pere             ?: null,
                    'nationnalite_pere'           => $this->nationnalite_pere           ?: null,
                    'domicile_pere'               => $this->domicile_pere               ?: null,
                    'nature_piece_pere'           => $this->nature_piece_pere           ?: null,
                    'nom_prenom_mere'             => strtoupper($this->nom_prenom_mere) ?: null,
                    'date_naissance_mere'         => $this->date_naissance_mere         ?: null,
                    'annee_naissance_mere'        => $this->annee_naissance_mere        ?: null,
                    'profession_mere'             => $this->profession_mere             ?: null,
                    'nationalite_mere'            => $this->nationalite_mere            ?: null,
                    'domicile_mere'               => $this->domicile_mere               ?: null,
                    'nature_piece_mere'           => $this->nature_piece_mere           ?: null,
                    'info_declarant'              => $this->info_declarant              ?: null,
                    'info_temoin_1'               => $this->info_temoin_1               ?: null,
                    'info_temoin_2'               => $this->info_temoin_2               ?: null,
                ]);

                // Mentions associées
                foreach ($this->mentions as $m) {
                    $hasDonnees = collect($m)->filter(fn($v) => ! empty($v))->isNotEmpty();
                    if ($hasDonnees) {
                        Mention::create(array_merge($m, [
                            'commune_id' => $this->commune_id,
                            'extrait_id' => $extrait->id,
                        ]));
                    }
                }
            });
        } catch (\Throwable $e) {
            Log::error('Erreur création extrait', ['message' => $e->getMessage()]);
            session()->flash('error', "Une erreur est survenue. Veuillez réessayer.");
            return;
        }

        $this->resetForm();
        session()->flash('form_success', "L'acte de naissance de {$nomEnfant} a été enregistré avec succès.");
        session()->flash('success', "L'acte de naissance de {$nomEnfant} a été enregistré."); // Garder pour la liste
    }

    // ═══════════════════════════════════════════════════════
    // MISE À JOUR EXTRAIT
    // ═══════════════════════════════════════════════════════

    public function update(): void
    {
        $e = $this->selectedExtrait;
        if (! $e) return;

        $this->validate([
            'edit_commune_id'            => 'required|exists:communes,id',
            'edit_annee_registre_extrai' => 'required|integer|min:1900',
            'edit_numero_act_extrai'     => 'required|string|max:50',
            'edit_date_dressage'         => 'required|date',
            'edit_nom_enfant'            => 'required|string|max:100',
            'edit_prenom_enfant'         => 'required|string|max:100',
            'edit_date_naissance'        => 'required|date',
            'edit_sexe'                  => 'required|in:M,F',
        ], [
            'edit_commune_id.required'        => 'La commune est obligatoire.',
            'edit_numero_act_extrai.required' => 'Le numéro d\'acte est obligatoire.',
            'edit_date_dressage.required'     => 'La date de dressage est obligatoire.',
            'edit_nom_enfant.required'        => 'Le nom est obligatoire.',
            'edit_prenom_enfant.required'     => 'Le prénom est obligatoire.',
            'edit_date_naissance.required'    => 'La date de naissance est obligatoire.',
            'edit_sexe.required'              => 'Le sexe est obligatoire.',
        ]);

        $e->update([
            'commune_id'                  => $this->edit_commune_id,
            'centr_etat_civil'            => $this->edit_centr_etat_civil            ?: null,
            'annee_registre_extrai'       => $this->edit_annee_registre_extrai       ?: null,
            'nature_declarat_extrai'      => $this->edit_nature_declarat_extrai      ?: null,
            'numero_registre_extrai'      => $this->edit_numero_registre_extrai      ?: null,
            'numero_act_extrai'           => $this->edit_numero_act_extrai           ?: null,
            'numero_complet_act_extrai'   => $this->edit_numero_complet_act_extrai   ?: null,
            'officier_etat_civil'         => $this->edit_officier_etat_civil         ?: null,
            'qualite'                     => $this->edit_qualite                     ?: null,
            'nous_avons_signer'           => $this->edit_nous_avons_signer           ?: null,
            'date_dressage'               => $this->edit_date_dressage               ?: null,
            'heure_dressage'              => $this->edit_heure_dressage              ?: null,
            'date_dressage_copie_integrale' => $this->edit_date_dressage_copie_integrale ?: null,
            'nom_enfant'                  => strtoupper($this->edit_nom_enfant)      ?: null,
            'prenom_enfant'               => $this->edit_prenom_enfant               ?: null,
            'date_naissance_lettre'       => $this->edit_date_naissance_lettre       ?: null,
            'date_naissance'              => $this->edit_date_naissance              ?: null,
            'heure_min_naissance'         => $this->edit_heure_min_naissance         ?: null,
            'lieux_naissance'             => $this->edit_lieux_naissance             ?: null,
            'sexe'                        => $this->edit_sexe                        ?: null,
            'fils_fille'                  => $this->edit_fils_fille                  ?: null,
            'nom_prenom_pere'             => strtoupper($this->edit_nom_prenom_pere) ?: null,
            'date_naissance_pere'         => $this->edit_date_naissance_pere         ?: null,
            'annee_naissance_pere'        => $this->edit_annee_naissance_pere        ?: null,
            'lieu_naissance_pere'         => $this->edit_lieu_naissance_pere         ?: null,
            'profession_pere'             => $this->edit_profession_pere             ?: null,
            'nationnalite_pere'           => $this->edit_nationnalite_pere           ?: null,
            'domicile_pere'               => $this->edit_domicile_pere               ?: null,
            'nature_piece_pere'           => $this->edit_nature_piece_pere           ?: null,
            'nom_prenom_mere'             => strtoupper($this->edit_nom_prenom_mere) ?: null,
            'date_naissance_mere'         => $this->edit_date_naissance_mere         ?: null,
            'annee_naissance_mere'        => $this->edit_annee_naissance_mere        ?: null,
            'profession_mere'             => $this->edit_profession_mere             ?: null,
            'nationalite_mere'            => $this->edit_nationalite_mere            ?: null,
            'domicile_mere'               => $this->edit_domicile_mere               ?: null,
            'nature_piece_mere'           => $this->edit_nature_piece_mere           ?: null,
            'info_declarant'              => $this->edit_info_declarant              ?: null,
            'info_temoin_1'               => $this->edit_info_temoin_1               ?: null,
            'info_temoin_2'               => $this->edit_info_temoin_2               ?: null,
        ]);

        $this->editMode = false;
        $this->resetErrorBag();
        session()->flash('success', "L'acte a été mis à jour.");
        $this->closeFicheModal();
    }

    // ═══════════════════════════════════════════════════════
    // SUPPRESSION EXTRAIT
    // ═══════════════════════════════════════════════════════

    public function confirmDelete(): void
    {
        $e = $this->selectedExtrait;
        if (! $e) return;
        $label = strtoupper($e->nom_enfant ?? '') . ' ' . ($e->prenom_enfant ?? '');
        $e->mentions()->delete();
        $e->delete();
        $this->closeFicheModal();
        session()->flash('success', "L'acte de {$label} a été supprimé.");
    }

    // ═══════════════════════════════════════════════════════
    // RENDU
    // ═══════════════════════════════════════════════════════

    public function render(): \Illuminate\View\View
    {
        $extraits = Extrait::with(['commune'])
            ->when($this->search, fn ($q) =>
                $q->where('nom_enfant',   'like', "%{$this->search}%")
                  ->orWhere('prenom_enfant', 'like', "%{$this->search}%")
                  ->orWhere('numero_act_extrai', 'like', "%{$this->search}%")
                  ->orWhere('numero_complet_act_extrai', 'like', "%{$this->search}%")
            )
            ->when($this->filtre_commune, fn ($q) => $q->where('commune_id', $this->filtre_commune))
            ->when($this->filtre_annee,   fn ($q) => $q->where('annee_registre_extrai', $this->filtre_annee))
            ->latest('date_naissance')
            ->paginate(12);

        // ✅ Communes passées via render() — plus fiable que computed property dans la blade
        $communes = Commune::orderBy('nom_commune')->get();

        // ✅ Extrait sélectionné + mentions passés directement
        $selectedExtrait   = $this->selectedId
            ? Extrait::with(['commune', 'mentions'])->find($this->selectedId)
            : null;

        $mentionsExtrait = $this->selectedId
            ? Mention::where('extrait_id', $this->selectedId)->latest()->get()
            : collect();

        return view('livewire.etat-civils.create-etat-civil', [
            'extraits'         => $extraits,
            'communes'         => $communes,
            'selectedExtrait'  => $selectedExtrait,
            'mentionsExtrait'  => $mentionsExtrait,
        ]);
    }
}
