<div>

    {{-- ═══════════════════════════════════════════════════════
         ZONE PRINCIPALE
    ═══════════════════════════════════════════════════════ --}}
    <div class="p-4 sm:p-6 lg:p-8 max-w-5xl mx-auto space-y-6">

        {{-- ── Bannière ── --}}
        <div class="animate-fadeInUp relative overflow-hidden
                    bg-gradient-to-r from-[#1A6B3A] via-[#1d7a41] to-[#2d9b5a]
                    rounded-2xl px-6 py-7 text-white shadow-lg">
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-xs font-medium text-white/50 uppercase tracking-widest mb-1">État Civil</p>
                    <h1 class="font-serif text-2xl font-bold leading-tight">Administration</h1>
                    <p class="text-white/60 text-sm mt-1">Gestion des comptes utilisateurs du module État Civil.</p>
                </div>
                <div class="shrink-0">
                    <button wire:click="openModal"
                            class="inline-flex items-center gap-2 px-5 py-2.5
                                   bg-white text-[#8a6d00] text-sm font-semibold rounded-xl
                                   hover:bg-yellow-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Nouvel utilisateur
                    </button>
                </div>
            </div>
            <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full border-[28px] border-white/5 pointer-events-none"></div>
            <div class="absolute right-16 -bottom-8 w-28 h-28 rounded-full border-[14px] border-white/5 pointer-events-none"></div>
        </div>

        {{-- ── Flash ── --}}
        @if(session()->has('success'))
            <div class="p-4 rounded-xl bg-green/10 border border-green/20 text-green font-medium text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 font-medium text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H4.645c-1.73 0-2.813-1.874-1.948-3.374l7.5-13.001c.866-1.5 3.032-1.5 3.898 0l7.5 13.001Z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- ── Filtres ── --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="Rechercher par nom ou email…"
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl
                              text-sm text-navy placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
            </div>
            <div class="sm:w-48">
                <select wire:model.live="filtre_role"
                        class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-navy appearance-none
                               focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                    <option value="">Tous les rôles</option>
                    <option value="admin">Administrateur</option>
                    <option value="utilisateur">Utilisateur</option>
                </select>
            </div>
        </div>

        {{-- ── Grille utilisateurs ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($users as $u)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden
                        hover:-translate-y-1 hover:shadow-md transition-all cursor-pointer"
                 wire:click="viewFiche({{ $u->id }})">

                {{-- Bande top colorée selon rôle --}}
                <div class="h-1.5 w-full {{ $u->role === 'admin' ? 'bg-gradient-to-r from-[#1A6B3A] to-[#2d9b5a]' : 'bg-gradient-to-r from-navy to-[#1a3a6b]' }}"></div>

                <div class="p-5">
                    <div class="flex items-start gap-4">
                        {{-- Avatar --}}
                        <div class="shrink-0">
                            @if($u->profile_photo_path)
                                <img src="{{ Storage::url($u->profile_photo_path) }}"
                                     class="w-14 h-14 rounded-2xl object-cover ring-2 ring-gray-100">
                            @else
                                <div class="w-14 h-14 rounded-2xl {{ $u->role === 'admin' ? 'bg-green/10' : 'bg-navy/8' }}
                                            flex items-center justify-center text-2xl font-bold
                                            {{ $u->role === 'admin' ? 'text-green' : 'text-navy' }}">
                                    {{ Str::upper(substr($u->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        {{-- Infos --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="font-bold text-navy text-sm truncate">{{ $u->name }}</p>
                                    <p class="text-xs text-gray-400 truncate mt-0.5">{{ $u->email }}</p>
                                </div>
                                {{-- Badge rôle --}}
                                <span class="shrink-0 inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold
                                    {{ $u->role === 'admin'
                                        ? 'bg-green/10 text-green border border-green/20'
                                        : 'bg-navy/8 text-navy border border-navy/12' }}">
                                    {{ $u->role === 'admin' ? 'Admin' : 'Utilisateur' }}
                                </span>
                            </div>

                            {{-- Indicateur soi-même --}}
                            @if($u->id === auth()->id())
                                <span class="mt-2 inline-flex items-center gap-1 text-[10px] text-green font-semibold">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/>
                                    </svg>
                                    Votre compte
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 py-12 text-center bg-white rounded-2xl border border-gray-100">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
                <p class="text-gray-400 text-sm">Aucun utilisateur trouvé.</p>
                <button wire:click="openModal"
                        class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-green hover:text-green/80 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Créer le premier utilisateur
                </button>
            </div>
            @endforelse
        </div>

        @if($users->hasPages())
            <div class="bg-white rounded-2xl border border-gray-100 px-5 py-3">
                {{ $users->links() }}
            </div>
        @endif

        <p class="text-center text-xs text-gray-400 pb-4">
            &copy; {{ date('Y') }} Mairie de Cocody — Système de Gestion Municipale
        </p>
    </div>


    {{-- ═══════════════════════════════════════════════════════
         MODAL FICHE UTILISATEUR
    ═══════════════════════════════════════════════════════ --}}
    @if($showFicheModal && $selectedUser)
    @php $u = $selectedUser; $isSelf = $u->id === auth()->id(); @endphp
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeFicheModal"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative z-10 w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">

                {{-- En-tête --}}
                <div class="bg-gradient-to-r {{ $u->role === 'admin' ? 'from-[#1A6B3A] via-[#1d7a41] to-[#2d9b5a]' : 'from-navy via-[#0f2d56] to-[#1a3a6b]' }}
                            px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            {{-- Avatar --}}
                            <div class="relative">
                                @if($u->profile_photo_path)
                                    <img src="{{ Storage::url($u->profile_photo_path) }}"
                                         class="w-16 h-16 rounded-2xl object-cover ring-4 ring-white/20">
                                @else
                                    <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-3xl font-bold">
                                        {{ Str::upper(substr($u->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                @if($editMode)
                                    <input type="text" wire:model="edit_name"
                                           class="bg-white/10 border border-white/20 rounded-xl px-3 py-1.5 text-white font-bold text-lg w-64
                                                  focus:outline-none focus:ring-2 focus:ring-white/30">
                                @else
                                    <h2 class="font-serif text-xl font-bold">{{ $u->name }}</h2>
                                @endif
                                <div class="flex items-center gap-2 mt-1.5">
                                    <span class="text-white/60 text-xs">{{ $u->email }}</span>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-white/20
                                        {{ $u->role === 'admin' ? 'text-white' : 'text-white/80' }}">
                                        {{ $u->role === 'admin' ? 'Administrateur' : 'Utilisateur' }}
                                    </span>
                                </div>
                                @if($isSelf)
                                    <span class="mt-1 inline-flex items-center gap-1 text-[10px] text-white/70">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/>
                                        </svg>
                                        Votre compte
                                    </span>
                                @endif
                            </div>
                        </div>
                        <button wire:click="closeFicheModal"
                                class="w-8 h-8 flex items-center justify-center rounded-xl bg-white/10 text-white/60
                                       hover:bg-red-500 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Erreurs --}}
                @if($editMode && $errors->any())
                    <div class="mx-6 mt-4 p-3 bg-red-50 border border-red-200 rounded-xl">
                        <ul class="text-xs text-red-600 space-y-0.5 list-disc list-inside">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div class="max-h-[60vh] overflow-y-auto">
                    <div class="p-6 space-y-4">

                        @if(! $editMode)
                        {{-- ── CONSULTATION ── --}}
                        <div class="grid grid-cols-2 gap-3">
                            @foreach([
                                'Nom complet' => $u->name,
                                'Email'       => $u->email,
                                'Rôle'        => $u->role === 'admin' ? 'Administrateur' : 'Utilisateur',
                                'Créé le'     => $u->created_at->locale('fr')->isoFormat('DD MMMM YYYY'),
                            ] as $lbl => $val)
                            <div class="bg-gray-50 rounded-xl border border-gray-100 p-3">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">{{ $lbl }}</p>
                                <p class="text-xs font-semibold text-navy">{{ $val }}</p>
                            </div>
                            @endforeach
                        </div>

                        @if($u->profile_photo_path)
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 flex items-center gap-3">
                            <img src="{{ Storage::url($u->profile_photo_path) }}"
                                 class="w-16 h-16 rounded-xl object-cover">
                            <div>
                                <p class="text-xs font-semibold text-navy">Photo de profil</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Cliquez sur Modifier pour changer la photo.</p>
                            </div>
                        </div>
                        @endif

                        @else
                        {{-- ── FORMULAIRE ÉDITION ── --}}
                        @php $ic = 'w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all'; @endphp
                        <div class="space-y-4">

                            {{-- Email --}}
                            <div>
                                <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                    Adresse email <span class="text-red-400">*</span>
                                </label>
                                <input type="email" wire:model="edit_email" class="{{ $ic }} @error('edit_email') border-red-300 @enderror">
                                @error('edit_email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Rôle --}}
                            <div>
                                <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Rôle</label>
                                <div class="flex gap-3">
                                    @foreach(['admin' => ' Administrateur', 'utilisateur' => 'Utilisateur'] as $val => $lbl)
                                    <label class="flex-1 flex items-center justify-center py-2.5 border rounded-xl cursor-pointer text-sm font-medium transition-all
                                                 {{ $edit_role === $val
                                                    ? 'bg-green/10 text-green border-green/30'
                                                    : 'bg-gray-50 text-gray-500 border-gray-200 hover:border-green/20' }}">
                                        <input type="radio" wire:model.live="edit_role" value="{{ $val }}" class="sr-only">
                                        {{ $lbl }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Photo --}}
                            <div>
                                <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Photo de profil</label>
                                <input type="file" wire:model="edit_photo" accept="image/*"
                                       class="w-full text-xs text-gray-600 file:mr-3 file:py-2 file:px-4
                                              file:rounded-xl file:border-0 file:text-xs file:font-semibold
                                              file:bg-green/10 file:text-green hover:file:bg-green/20">
                                @error('edit_photo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Changer mot de passe --}}
                            <div class="pt-2 border-t border-gray-100">
                                <label class="flex items-center gap-3 cursor-pointer select-none">
                                    <div class="relative">
                                        <input type="checkbox" wire:model.live="change_password" class="sr-only peer">
                                        <div class="w-10 h-6 bg-gray-200 peer-checked:bg-green rounded-full transition-colors"></div>
                                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform
                                                    peer-checked:translate-x-4"></div>
                                    </div>
                                    <span class="text-sm font-medium text-navy">Changer le mot de passe</span>
                                </label>

                                @if($change_password)
                                <div class="mt-3 space-y-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Nouveau mot de passe <span class="text-red-400">*</span>
                                        </label>
                                        <input type="password" wire:model="edit_password" placeholder="Min. 8 caractères"
                                               class="{{ $ic }} @error('edit_password') border-red-300 @enderror">
                                        @error('edit_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Confirmer le mot de passe
                                        </label>
                                        <input type="password" wire:model="edit_password_confirmation" placeholder="Retaper le mot de passe"
                                               class="{{ $ic }}">
                                    </div>
                                </div>
                                @endif
                            </div>

                        </div>
                        @endif

                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-6 py-3.5 border-t border-gray-100 bg-white flex items-center justify-between gap-3">
                    {{-- Suppression désactivée sur son propre compte --}}
                    @if(!$isSelf)
                        <button wire:click="confirmDelete"
                                wire:confirm="Supprimer le compte de {{ $u->name }} ? Cette action est irréversible."
                                class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 text-sm font-semibold
                                       rounded-xl hover:bg-red-100 transition-colors border border-red-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                            Supprimer
                        </button>
                    @else
                        <div></div>
                    @endif

                    <div class="flex items-center gap-2">
                        @if($editMode)
                            <button wire:click="cancelEdit"
                                    class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
                                Annuler
                            </button>
                            <button wire:click="update" wire:loading.attr="disabled" wire:target="update"
                                    class="flex items-center gap-2 px-5 py-2 bg-green text-white text-sm font-semibold
                                           rounded-xl hover:bg-green/90 transition-colors shadow-sm disabled:opacity-60">
                                <span wire:loading.remove wire:target="update" class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                    Enregistrer
                                </span>
                                <span wire:loading wire:target="update" class="flex items-center gap-2">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    Enregistrement…
                                </span>
                            </button>
                        @else
                            <button wire:click="enableEditMode"
                                    class="flex items-center gap-2 px-5 py-2 bg-navy text-white text-sm font-semibold
                                           rounded-xl hover:bg-[#0f2d56] transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                                </svg>
                                Modifier
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif


    {{-- ═══════════════════════════════════════════════════════
         MODAL CRÉATION
    ═══════════════════════════════════════════════════════ --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeModal"></div>
        <div class="flex min-h-full items-end justify-center p-4 sm:items-center sm:p-0">
            <div class="relative z-10 transform overflow-hidden rounded-2xl bg-white text-left
                        shadow-2xl sm:my-8 sm:w-full sm:max-w-lg">

                {{-- En-tête modal --}}
                <div class="bg-gradient-to-r from-[#1A6B3A] to-[#2d9b5a] px-6 py-5 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-base">Nouvel utilisateur</h3>
                                <p class="text-white/60 text-xs">Créer un accès au système</p>
                            </div>
                        </div>
                        <button wire:click="closeModal"
                                class="w-8 h-8 flex items-center justify-center rounded-xl bg-white/10 text-white/60
                                       hover:bg-red-500 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-6 space-y-4">

                    {{-- Erreurs --}}
                    @if($errors->any())
                        <div class="p-3 bg-red-50 border border-red-200 rounded-xl">
                            <ul class="text-xs text-red-600 space-y-0.5 list-disc list-inside">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    @php $ic = 'w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all'; @endphp

                    {{-- Nom --}}
                    <div>
                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                            Nom complet <span class="text-red-400">*</span>
                        </label>
                        <input type="text" wire:model="name" placeholder="ex : KONÉ Amadou Ibrahim"
                               class="{{ $ic }} @error('name') border-red-300 @enderror">
                        @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                            Adresse email <span class="text-red-400">*</span>
                        </label>
                        <input type="email" wire:model="email" placeholder="exemple@mairie-cocody.ci"
                               class="{{ $ic }} @error('email') border-red-300 @enderror">
                        @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Rôle --}}
                    <div>
                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Rôle</label>
                        <div class="flex gap-3">
                            @foreach(['admin' => ' Administrateur', 'utilisateur' => 'Utilisateur'] as $val => $lbl)
                            <label class="flex-1 flex items-center justify-center py-2.5 border rounded-xl cursor-pointer text-sm font-medium transition-all
                                         {{ $role === $val
                                            ? 'bg-green/10 text-green border-green/30'
                                            : 'bg-gray-50 text-gray-500 border-gray-200 hover:border-green/20' }}">
                                <input type="radio" wire:model.live="role" value="{{ $val }}" class="sr-only">
                                {{ $lbl }}
                            </label>
                            @endforeach
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1.5">
                            L'administrateur a accès à toutes les fonctionnalités. L'utilisateur a un accès limité à la consultation et à la saisie.
                        </p>
                    </div>

                    {{-- Mot de passe --}}
                    <div>
                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                            Mot de passe <span class="text-red-400">*</span>
                        </label>
                        <input type="password" wire:model="password" placeholder="Minimum 8 caractères"
                               class="{{ $ic }} @error('password') border-red-300 @enderror">
                        @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Confirmation --}}
                    <div>
                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                            Confirmer le mot de passe <span class="text-red-400">*</span>
                        </label>
                        <input type="password" wire:model="password_confirmation" placeholder="Retaper le mot de passe"
                               class="{{ $ic }}">
                    </div>

                    {{-- Photo --}}
                    <div>
                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                            Photo de profil <span class="text-gray-400 font-normal">(optionnel)</span>
                        </label>
                        <input type="file" wire:model="photo" accept="image/*"
                               class="w-full text-sm text-gray-600
                                      file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0
                                      file:text-xs file:font-semibold file:bg-green/10 file:text-green
                                      hover:file:bg-green/20 transition-all">
                        @error('photo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        @if($photo)
                            <div class="mt-2 flex items-center gap-2">
                                <img src="{{ $photo->temporaryUrl() }}" class="w-10 h-10 rounded-lg object-cover">
                                <span class="text-xs text-gray-500">Aperçu de la photo</span>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- Footer modal --}}
                <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-3">
                    <button wire:click="closeModal"
                            class="px-5 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
                        Annuler
                    </button>
                    <button wire:click="save" wire:loading.attr="disabled" wire:target="save"
                            class="flex items-center gap-2 px-6 py-2.5 bg-green text-white text-sm font-semibold
                                   rounded-xl hover:bg-green/90 transition-colors shadow-sm disabled:opacity-60">
                        <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            Créer le compte
                        </span>
                        <span wire:loading wire:target="save" class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Création…
                        </span>
                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif

</div>
