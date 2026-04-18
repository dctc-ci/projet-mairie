<?php

namespace App\Livewire\EtatCivils;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CreateAdministrateur extends Component
{
    use WithPagination, WithFileUploads;

    // ═══════════════════════════════════════════════════════
    // MODALS
    // ═══════════════════════════════════════════════════════

    public bool $showModal      = false;
    public bool $showFicheModal = false;
    public bool $editMode       = false;
    public ?int $selectedId     = null;

    // ═══════════════════════════════════════════════════════
    // FORMULAIRE CRÉATION
    // ═══════════════════════════════════════════════════════

    public string $name     = '';
    public string $email    = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role     = 'utilisateur';
    public $photo = null;   // upload fichier

    // ═══════════════════════════════════════════════════════
    // FORMULAIRE ÉDITION
    // ═══════════════════════════════════════════════════════

    public string $edit_name     = '';
    public string $edit_email    = '';
    public string $edit_role     = 'utilisateur';
    public bool   $change_password = false;
    public string $edit_password = '';
    public string $edit_password_confirmation = '';
    public $edit_photo = null;

    // ═══════════════════════════════════════════════════════
    // FILTRES
    // ═══════════════════════════════════════════════════════

    public string $search      = '';
    public string $filtre_role = '';

    public function updatedSearch(): void    { $this->resetPage(); }
    public function updatedFiltreRole(): void { $this->resetPage(); }

    public function updatedChangePassword(bool $val): void
    {
        if (! $val) {
            $this->edit_password              = '';
            $this->edit_password_confirmation = '';
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
        $this->name                  = '';
        $this->email                 = '';
        $this->password              = '';
        $this->password_confirmation = '';
        $this->role                  = 'utilisateur';
        $this->photo                 = null;
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // GESTION MODAL FICHE
    // ═══════════════════════════════════════════════════════

    public function viewFiche(int $id): void
    {
        $this->selectedId       = $id;
        $this->editMode         = false;
        $this->change_password  = false;
        $this->edit_photo       = null;
        $this->resetErrorBag();
        $this->showFicheModal   = true;
    }

    public function closeFicheModal(): void
    {
        $this->showFicheModal  = false;
        $this->selectedId      = null;
        $this->editMode        = false;
        $this->change_password = false;
        $this->edit_photo      = null;
        $this->resetErrorBag();
    }

    public function enableEditMode(): void
    {
        $u = $this->selectedUser;
        if (! $u) return;

        $this->edit_name              = $u->name;
        $this->edit_email             = $u->email;
        $this->edit_role              = $u->role;
        $this->change_password        = false;
        $this->edit_password          = '';
        $this->edit_password_confirmation = '';
        $this->edit_photo             = null;
        $this->editMode               = true;
        $this->resetErrorBag();
    }

    public function cancelEdit(): void
    {
        $this->editMode        = false;
        $this->change_password = false;
        $this->edit_photo      = null;
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // SAUVEGARDE CRÉATION
    // ═══════════════════════════════════════════════════════

    public function save(): void
    {
        $this->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'role'                  => 'required|in:admin,utilisateur',
            'photo'                 => 'nullable|image|max:2048',
        ], [
            'name.required'         => 'Le nom complet est obligatoire.',
            'email.required'        => 'L\'adresse email est obligatoire.',
            'email.unique'          => 'Cette adresse email est déjà utilisée.',
            'password.required'     => 'Le mot de passe est obligatoire.',
            'password.min'          => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed'    => 'La confirmation du mot de passe ne correspond pas.',
            'role.required'         => 'Le rôle est obligatoire.',
        ]);

        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('profile-photos', 'public');
        }

        $nom = $this->name;

        User::create([
            'name'                => $this->name,
            'email'               => $this->email,
            'password'            => Hash::make($this->password),
            'role'                => $this->role,
            'profile_photo_path'  => $photoPath,
        ]);

        $this->closeModal();
        session()->flash('success', "Le compte de {$nom} a été créé.");
    }

    // ═══════════════════════════════════════════════════════
    // MISE À JOUR
    // ═══════════════════════════════════════════════════════

    public function update(): void
    {
        $u = $this->selectedUser;
        if (! $u) return;

        $rules = [
            'edit_name'  => 'required|string|max:255',
            'edit_email' => 'required|email|unique:users,email,' . $u->id,
            'edit_role'  => 'required|in:admin,utilisateur',
            'edit_photo' => 'nullable|image|max:2048',
        ];

        if ($this->change_password) {
            $rules['edit_password'] = 'required|string|min:8|confirmed';
        }

        $this->validate($rules, [
            'edit_name.required'      => 'Le nom est obligatoire.',
            'edit_email.required'     => 'L\'email est obligatoire.',
            'edit_email.unique'       => 'Cette adresse email est déjà utilisée.',
            'edit_role.required'      => 'Le rôle est obligatoire.',
            'edit_password.required'  => 'Le mot de passe est obligatoire.',
            'edit_password.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
            'edit_password.confirmed' => 'La confirmation ne correspond pas.',
        ]);

        $data = [
            'name'  => $this->edit_name,
            'email' => $this->edit_email,
            'role'  => $this->edit_role,
        ];

        if ($this->change_password && $this->edit_password) {
            $data['password'] = Hash::make($this->edit_password);
        }

        if ($this->edit_photo) {
            // Supprimer l'ancienne photo
            if ($u->profile_photo_path) {
                Storage::disk('public')->delete($u->profile_photo_path);
            }
            $data['profile_photo_path'] = $this->edit_photo->store('profile-photos', 'public');
        }

        $u->update($data);

        $this->editMode = false;
        $this->change_password = false;
        $this->edit_photo = null;
        $this->resetErrorBag();
        session()->flash('success', "Le compte de {$this->edit_name} a été mis à jour.");
        $this->closeFicheModal();
    }

    // ═══════════════════════════════════════════════════════
    // SUPPRESSION
    // ═══════════════════════════════════════════════════════

    public function confirmDelete(): void
    {
        $u = $this->selectedUser;
        if (! $u) return;

        // Interdit de se supprimer soi-même
        if ($u->id === auth()->id()) {
            session()->flash('error', "Vous ne pouvez pas supprimer votre propre compte.");
            return;
        }

        $nom = $u->name;

        if ($u->profile_photo_path) {
            Storage::disk('public')->delete($u->profile_photo_path);
        }

        $u->delete();
        $this->closeFicheModal();
        session()->flash('success', "Le compte de {$nom} a été supprimé.");
    }

    // ═══════════════════════════════════════════════════════
    // RENDU
    // ═══════════════════════════════════════════════════════

    public function render(): \Illuminate\View\View
    {
        $users = User::when($this->search, fn($q) =>
                $q->where('name',  'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
            )
            ->when($this->filtre_role, fn($q) => $q->where('role', $this->filtre_role))
            ->latest()
            ->paginate(12);

        $selectedUser = $this->selectedId ? User::find($this->selectedId) : null;

        return view('livewire.etat-civils.create-administrateur', [
            'users'        => $users,
            'selectedUser' => $selectedUser,
        ]);
    }

    public function getSelectedUserProperty(): ?User
    {
        return $this->selectedId ? User::find($this->selectedId) : null;
    }
}
