<?php

namespace App\Livewire\Personnels;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CreateAdministration extends Component
{
    use AuthorizesPersonnelManagement;
    use WithFileUploads;
    use WithPagination;

    // ═══════════════════════════════════════════════════════
    // ÉTAT DES MODALS
    // ═══════════════════════════════════════════════════════

    public bool $showModal = false;

    public bool $showFicheModal = false;

    public bool $editMode = false;

    public ?int $selectedId = null;

    // ═══════════════════════════════════════════════════════
    // CHAMPS FORMULAIRE CRÉATION
    // ═══════════════════════════════════════════════════════

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $role = 'admin';

    public $profile_photo = null;

    // ═══════════════════════════════════════════════════════
    // CHAMPS ÉDITION
    // ═══════════════════════════════════════════════════════

    public string $edit_name = '';

    public string $edit_email = '';

    public string $edit_role = 'admin';

    public string $edit_password = '';

    public string $edit_password_confirmation = '';

    public bool $change_password = false;

    public $edit_profile_photo = null;

    // ═══════════════════════════════════════════════════════
    // FILTRES TABLE
    // ═══════════════════════════════════════════════════════

    public string $search = '';

    public string $filtre_role = '';

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
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = 'admin';
        $this->profile_photo = null;
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // GESTION MODAL FICHE
    // ═══════════════════════════════════════════════════════

    public function viewFiche(int $id): void
    {
        $this->selectedId = $id;
        $this->editMode = false;
        $this->resetErrorBag();
        $this->showFicheModal = true;
    }

    #[Computed]
    public function selectedUser(): ?User
    {
        return $this->selectedId ? User::find($this->selectedId) : null;
    }

    public function closeFicheModal(): void
    {
        $this->showFicheModal = false;
        $this->selectedId = null;
        $this->editMode = false;
        $this->change_password = false;
        $this->edit_profile_photo = null;
        $this->resetErrorBag();
    }

    public function enableEditMode(): void
    {
        $u = $this->selectedUser;
        if (! $u) {
            return;
        }

        $this->edit_name = $u->name;
        $this->edit_email = $u->email;
        $this->edit_role = $u->role ?? 'admin';
        $this->edit_password = '';
        $this->edit_password_confirmation = '';
        $this->change_password = false;
        $this->edit_profile_photo = null;

        $this->editMode = true;
    }

    public function cancelEdit(): void
    {
        $this->editMode = false;
        $this->change_password = false;
        $this->resetErrorBag();
    }

    // ═══════════════════════════════════════════════════════
    // UPLOAD PHOTO
    // ═══════════════════════════════════════════════════════

    public function updatedProfilePhoto(): void
    {
        $this->validateOnly('profile_photo', [
            'profile_photo' => 'nullable|image|max:2048',
        ]);
    }

    public function updatedEditProfilePhoto(): void
    {
        $this->validateOnly('edit_profile_photo', [
            'edit_profile_photo' => 'nullable|image|max:2048',
        ]);
    }

    // ═══════════════════════════════════════════════════════
    // VALIDATION
    // ═══════════════════════════════════════════════════════

    protected function rulesCreation(): array
    {
        return [
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|in:admin,utilisateur',
            'profile_photo' => 'nullable|image|max:2048',
        ];
    }

    protected function messagesCreation(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => "L'adresse email est obligatoire.",
            'email.email' => "L'adresse email n'est pas valide.",
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'role.required' => 'Le rôle est obligatoire.',
            'profile_photo.image' => 'La photo doit être une image.',
            'profile_photo.max' => 'La photo ne doit pas dépasser 2 Mo.',
        ];
    }

    // ═══════════════════════════════════════════════════════
    // SAUVEGARDE (CRÉATION)
    // ═══════════════════════════════════════════════════════

    public function save(): void
    {
        $this->authorizePersonnelManagement();
        $this->validate($this->rulesCreation(), $this->messagesCreation());

        try {
            $photoPath = null;
            if ($this->profile_photo) {
                $photoPath = $this->profile_photo->store('profile-photos', 'public');
            }

            User::create([
                'name' => trim($this->name),
                'email' => strtolower(trim($this->email)),
                'password' => Hash::make($this->password),
                'role' => $this->role,
                'profile_photo_path' => $photoPath,
            ]);
        } catch (\Throwable $e) {
            Log::error('Erreur création utilisateur', ['message' => $e->getMessage()]);
            session()->flash('error', 'Une erreur est survenue. Veuillez réessayer.');

            return;
        }

        $nom = $this->name;
        $this->closeModal();
        session()->flash('success', "L'utilisateur {$nom} a été créé avec succès.");
    }

    // ═══════════════════════════════════════════════════════
    // MISE À JOUR (ÉDITION)
    // ═══════════════════════════════════════════════════════

    public function update(): void
    {
        $this->authorizePersonnelManagement();
        $u = $this->selectedUser;
        if (! $u) {
            return;
        }

        abort_if($u->role === 'superadmin', 403);

        $rules = [
            'edit_name' => 'required|string|max:150',
            'edit_email' => "required|email|max:255|unique:users,email,{$u->id}",
            'edit_role' => 'required|in:admin,utilisateur',
            'edit_profile_photo' => 'nullable|image|max:2048',
        ];

        if ($this->change_password) {
            $rules['edit_password'] = ['required', 'confirmed', Password::min(8)];
        }

        $this->validate($rules, [
            'edit_name.required' => 'Le nom est obligatoire.',
            'edit_email.required' => "L'email est obligatoire.",
            'edit_email.unique' => 'Cette adresse email est déjà utilisée.',
            'edit_password.required' => 'Le mot de passe est obligatoire.',
            'edit_password.confirmed' => 'La confirmation ne correspond pas.',
        ]);

        $data = [
            'name' => trim($this->edit_name),
            'email' => strtolower(trim($this->edit_email)),
            'role' => $this->edit_role,
        ];

        if ($this->change_password && $this->edit_password) {
            $data['password'] = Hash::make($this->edit_password);
        }

        if ($this->edit_profile_photo) {
            // Supprimer l'ancienne photo
            if ($u->profile_photo_path) {
                Storage::disk('public')->delete($u->profile_photo_path);
            }
            $data['profile_photo_path'] = $this->edit_profile_photo->store('profile-photos', 'public');
        }

        $u->update($data);

        $this->editMode = false;
        $this->change_password = false;
        $this->resetErrorBag();
        session()->flash('success', "L'utilisateur {$u->name} a été mis à jour.");
        $this->closeFicheModal();
    }

    // ═══════════════════════════════════════════════════════
    // SUPPRESSION
    // ═══════════════════════════════════════════════════════

    public function confirmDelete(): void
    {
        $this->authorizePersonnelManagement();
        $u = $this->selectedUser;
        if (! $u) {
            return;
        }

        abort_if($u->role === 'superadmin', 403);

        // Empêcher la suppression de son propre compte
        if ($u->id === auth()->id()) {
            session()->flash('error', 'Vous ne pouvez pas supprimer votre propre compte.');

            return;
        }

        $nom = $u->name;

        if ($u->profile_photo_path) {
            Storage::disk('public')->delete($u->profile_photo_path);
        }

        $u->delete();

        $this->closeFicheModal();
        session()->flash('success', "L'utilisateur {$nom} a été supprimé.");
    }

    // ═══════════════════════════════════════════════════════
    // HELPERS
    // ═══════════════════════════════════════════════════════

    public function roleLabel(string $role): string
    {
        return match ($role) {

            'admin' => 'Administrateur',
            'utilisateur' => 'Utilisateur',
            default => $role,
        };
    }

    public function roleBadgeClass(string $role): string
    {
        return match ($role) {
            'admin' => 'bg-navy/10 text-navy border border-navy/20',
            'utilisateur' => 'bg-gray-100 text-gray-600 border border-gray-200',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFiltreRole(): void
    {
        $this->resetPage();
    }

    // ═══════════════════════════════════════════════════════
    // RENDU
    // ═══════════════════════════════════════════════════════

    public function render(): View
    {
        $users = User::query()
            ->where('role', '!=', 'superadmin')
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
            )
            ->when($this->filtre_role, fn ($q) => $q->where('role', $this->filtre_role)
            )
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.personnels.create-administration', [
            'users' => $users,
        ]);
    }
}
