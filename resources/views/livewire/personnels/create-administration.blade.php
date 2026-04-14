<div>

    {{-- ═══════════════════════════════════════════════════════
         ZONE PRINCIPALE
    ═══════════════════════════════════════════════════════ --}}
    <div class="p-4 sm:p-6 lg:p-8 max-w-6xl mx-auto space-y-6">

        {{-- ── Bannière ── --}}
        <div class="animate-fadeInUp relative overflow-hidden
                    bg-gradient-to-r from-navy via-[#0f2d56] to-[#1a3a6b]
                    rounded-2xl px-6 py-7 text-white shadow-lg">
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-xs font-medium text-white/50 uppercase tracking-widest mb-1">Système</p>
                    <h1 class="font-serif text-2xl font-bold leading-tight">Administration</h1>
                    <p class="text-white/60 text-sm mt-1">Gérez les comptes utilisateurs et leurs accès.</p>
                </div>
                <div class="shrink-0">
                    <button wire:click="openModal" class="inline-flex items-center gap-2 px-5 py-2.5
                                   bg-gold text-navy text-sm font-semibold rounded-xl
                                   hover:bg-yellow-400 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Nouvel utilisateur
                    </button>
                </div>
            </div>
            {{-- Déco --}}
            <div
                class="absolute -right-12 -top-12 w-48 h-48 rounded-full border-[28px] border-white/5 pointer-events-none">
            </div>
            <div
                class="absolute right-16 -bottom-8 w-28 h-28 rounded-full border-[14px] border-white/5 pointer-events-none">
            </div>
            <div class="absolute right-6 top-6 w-10 h-10 rounded-full bg-gold/20 pointer-events-none"></div>
        </div>

        {{-- ── Flash messages ── --}}
        @if(session()->has('success'))
        <div
            class="p-4 rounded-xl bg-green/10 border border-green/20 text-green font-medium text-sm flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session()->has('error'))
        <div
            class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 font-medium text-sm flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
            {{ session('error') }}
        </div>
        @endif

        {{-- ── Filtres ── --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher par nom ou email…"
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl
                              text-sm text-navy placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
            </div>
            <div class="sm:w-52">
                <select wire:model.live="filtre_role" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-navy appearance-none
                               focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                    <option value="">Tous les rôles</option>
                    <option value="admin">Administrateur</option>
                    <option value="utilisateur">Utilisateur</option>
                </select>
            </div>
        </div>

        {{-- ── Table ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fadeInUp">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                Utilisateur</th>
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">
                                Email</th>
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                Rôle</th>
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">
                                Créé le</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($users as $user)
                        <tr
                            class="hover:bg-gray-50/50 transition-colors {{ $user->id === auth()->id() ? 'bg-gold/5' : '' }}">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    @if($user->profile_photo_path)
                                    <img src="{{ Storage::url($user->profile_photo_path) }}"
                                        class="w-9 h-9 rounded-full object-cover ring-2 ring-gray-100 shrink-0">
                                    @else
                                    <div class="w-9 h-9 rounded-full bg-navy/10 flex items-center justify-center
                                                    text-navy font-bold text-sm shrink-0">
                                        {{ Str::upper(substr($user->name, 0, 1)) }}
                                    </div>
                                    @endif
                                    <div>
                                        <span class="block font-semibold text-navy text-xs">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                            <span class="ml-1 text-[10px] text-gold font-normal">(vous)</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <span class="text-xs text-gray-600">{{ $user->email }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span
                                    class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold {{ $this->roleBadgeClass($user->role ?? 'admin') }}">
                                    {{ $this->roleLabel($user->role ?? 'admin') }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                <span class="text-xs text-gray-500">
                                    {{ $user->created_at?->locale('fr')->isoFormat('DD MMM YYYY') ?? '—' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <button wire:click="viewFiche({{ $user->id }})"
                                    class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center
                                               text-gray-400 hover:text-navy hover:bg-gray-100 transition-colors ml-auto">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center">
                                <svg class="w-10 h-10 mx-auto mb-3 text-gray-200" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <p class="text-gray-400 text-sm">Aucun utilisateur trouvé.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
            <div class="px-5 py-3 border-t border-gray-100">{{ $users->links() }}</div>
            @endif
        </div>

        <p class="text-center text-xs text-gray-400 pb-4">
            &copy; {{ date('Y') }} Mairie de Cocody — Système de Gestion Municipale
        </p>
    </div>


    {{-- ═══════════════════════════════════════════════════════
         MODAL FICHE UTILISATEUR (consultation + modification)
    ═══════════════════════════════════════════════════════ --}}
    @if($showFicheModal && $this->selectedUser)
    @php $u = $this->selectedUser; @endphp
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeFicheModal"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative z-10 w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">

                {{-- En-tête --}}
                <div class="bg-gradient-to-r from-navy via-[#0f2d56] to-[#1a3a6b] px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            @if($u->profile_photo_path && !$editMode)
                            <img src="{{ Storage::url($u->profile_photo_path) }}"
                                class="w-14 h-14 rounded-2xl object-cover ring-2 ring-white/20 shrink-0">
                            @elseif($editMode && $edit_profile_photo)
                            <img src="{{ $edit_profile_photo->temporaryUrl() }}"
                                class="w-14 h-14 rounded-2xl object-cover ring-2 ring-white/20 shrink-0">
                            @else
                            <div
                                class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-2xl font-bold text-gold shrink-0">
                                {{ Str::upper(substr($u->name, 0, 1)) }}
                            </div>
                            @endif
                            <div>
                                @if($editMode)
                                <input type="text" wire:model="edit_name" class="bg-white/10 border border-white/20 rounded-xl px-3 py-1.5
                                                  text-white font-serif text-lg font-bold w-64
                                                  focus:outline-none focus:ring-2 focus:ring-gold/50">
                                @error('edit_name') <p class="text-xs text-red-300 mt-1">{{ $message }}</p> @enderror
                                @else
                                <h2 class="font-serif text-xl font-bold">{{ $u->name }}</h2>
                                @endif
                                <div class="flex items-center gap-2 mt-1.5">
                                    <span class="text-white/60 text-xs">{{ $u->email }}</span>
                                    @if($u->id === auth()->id())
                                    <span
                                        class="bg-gold/20 text-gold text-[10px] font-bold px-2 py-0.5 rounded-full">Vous</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <button wire:click="closeFicheModal"
                            class="w-8 h-8 flex items-center justify-center rounded-xl bg-white/10 text-white/60 hover:bg-red-500 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
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

                {{-- Corps --}}
                <div class="p-6 space-y-4">

                    {{-- Email --}}
                    <div class="bg-gray-50 rounded-xl border border-gray-100 p-4">
                        <p
                            class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-2 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 2.012l-7.5 4.5a2.25 2.25 0 0 1-2.36 0l-7.5-4.5A2.25 2.25 0 0 1 2.25 6.993V6.75" />
                            </svg>
                            Adresse email
                        </p>
                        @if($editMode)
                        <input type="email" wire:model="edit_email" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                        @error('edit_email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        @else
                        <p class="text-sm font-medium text-navy">{{ $u->email }}</p>
                        @endif
                    </div>

                    {{-- Rôle --}}
                    <div class="bg-gray-50 rounded-xl border border-gray-100 p-4">
                        <p
                            class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-2 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                            </svg>
                            Rôle & Permissions
                        </p>
                        @if($editMode)
                        <div class="flex gap-2">
                            @foreach(['admin' => 'Administrateur', 'utilisateur' => 'Utilisateur'] as $val => $label)
                            <label class="flex-1 flex items-center justify-center py-2 border rounded-xl cursor-pointer text-xs font-medium transition-all
             {{ $edit_role === $val ? 'bg-navy text-white border-navy' : 'bg-white text-gray-600 border-gray-200' }}">
                                <input type="radio" wire:model.live="edit_role" value="{{ $val }}" class="sr-only">
                                {{ $label }}
                            </label>
                            @endforeach
                        </div>
                        @else
                        <span
                            class="inline-flex px-3 py-1.5 rounded-xl text-xs font-bold {{ $this->roleBadgeClass($u->role ?? 'admin') }}">
                            {{ $this->roleLabel($u->role ?? 'admin') }}
                        </span>
                        @endif
                    </div>

                    {{-- Mot de passe (mode édition uniquement) --}}
                    @if($editMode)
                    <div class="bg-gray-50 rounded-xl border border-gray-100 p-4">
                        <div class="flex items-center justify-between mb-3">
                            <p
                                class="text-[10px] font-bold text-gray-400 uppercase tracking-wide flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                                </svg>
                                Mot de passe
                            </p>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" wire:model.live="change_password" class="sr-only peer">
                                    <div
                                        class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:bg-navy transition-colors duration-200">
                                    </div>
                                    <div
                                        class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow peer-checked:translate-x-4 transition-transform duration-200">
                                    </div>
                                </div>
                                <span class="text-xs text-gray-600">Modifier</span>
                            </label>
                        </div>
                        @if($change_password)
                        <div class="space-y-3">
                            <div>
                                <label
                                    class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">
                                    Nouveau mot de passe
                                </label>
                                <input type="password" wire:model="edit_password" placeholder="8 caractères minimum"
                                    class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                  @error('edit_password') border-red-300 @enderror">
                                @error('edit_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">
                                    Confirmation
                                </label>
                                <input type="password" wire:model="edit_password_confirmation"
                                    placeholder="Répéter le mot de passe"
                                    class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                            </div>
                        </div>
                        @else
                        <p class="text-xs text-gray-400 italic">Le mot de passe actuel sera conservé.</p>
                        @endif
                    </div>

                    {{-- Photo de profil --}}
                    <div class="bg-gray-50 rounded-xl border border-gray-100 p-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-2">Photo de profil</p>
                        <label
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl
                                      text-xs font-medium text-gray-600 cursor-pointer hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                            </svg>
                            Changer la photo
                            <input type="file" wire:model="edit_profile_photo" accept="image/*" class="hidden">
                        </label>
                        <p class="text-[11px] text-gray-400 mt-1.5">JPG, PNG — Max 2 Mo</p>
                        @error('edit_profile_photo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        <div wire:loading wire:target="edit_profile_photo"
                            class="mt-1 text-xs text-navy/60 flex items-center gap-1">
                            <svg class="animate-spin w-3 h-3" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Chargement…
                        </div>
                    </div>
                    @else
                    {{-- Mode consultation : infos complémentaires --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-50 rounded-xl border border-gray-100 p-3 text-center">
                            <p class="text-[10px] text-gray-400 mb-1">Créé le</p>
                            <p class="text-xs font-semibold text-navy">
                                {{ $u->created_at?->locale('fr')->isoFormat('DD MMM YYYY') ?? '—' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 rounded-xl border border-gray-100 p-3 text-center">
                            <p class="text-[10px] text-gray-400 mb-1">Dernière connexion</p>
                            <p class="text-xs font-semibold text-navy">
                                {{ $u->updated_at?->locale('fr')->isoFormat('DD MMM YYYY') ?? '—' }}
                            </p>
                        </div>
                    </div>
                    @endif

                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-white flex items-center justify-between gap-3">

                    {{-- Supprimer (désactivé pour son propre compte) --}}
                    @if($u->id !== auth()->id())
                    <button wire:click="confirmDelete"
                        wire:confirm="Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible."
                        class="flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 text-sm font-semibold
                                       rounded-xl hover:bg-red-100 transition-colors border border-red-100">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                        Supprimer
                    </button>
                    @else
                    <div></div>
                    @endif

                    <div class="flex items-center gap-2">
                        @if($editMode)
                        <button wire:click="cancelEdit"
                            class="flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                            Annuler
                        </button>
                        <button wire:click="update" wire:loading.attr="disabled" wire:target="update"
                            class="flex items-center gap-2 px-5 py-2.5 bg-green text-white text-sm font-semibold
                                           rounded-xl hover:bg-green/90 transition-colors shadow-sm disabled:opacity-60">
                            <span wire:loading.remove wire:target="update" class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                Enregistrer
                            </span>
                            <span wire:loading wire:target="update" class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Enregistrement…
                            </span>
                        </button>
                        @else
                        <button wire:click="enableEditMode" class="flex items-center gap-2 px-5 py-2.5 bg-navy text-white text-sm font-semibold
                                           rounded-xl hover:bg-[#0f2d56] transition-colors shadow-sm shadow-navy/20">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
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
            <div class="relative z-10 transform overflow-hidden rounded-2xl bg-gray-50 text-left
                        shadow-2xl sm:my-8 sm:w-full sm:max-w-lg border border-white/20">

                <button wire:click="closeModal"
                    class="absolute top-4 right-4 z-[60] w-8 h-8 flex items-center justify-center
                               rounded-xl bg-gray-200 text-gray-600 hover:bg-red-500 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="max-h-[85vh] overflow-y-auto">
                    <div class="p-6">

                        @if($errors->any())
                        <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                            {{-- Titre --}}
                            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-navy/8 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="font-semibold text-navy text-sm">Nouvel utilisateur</h2>
                                    <p class="text-xs text-gray-400 mt-0.5">Créez un compte d'accès au système</p>
                                </div>
                            </div>

                            <div class="p-6 space-y-4">

                                {{-- Photo --}}
                                <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
                                    <div class="w-16 h-16 rounded-2xl border-2 border-dashed border-gray-200
                                                bg-gray-50 flex items-center justify-center overflow-hidden shrink-0">
                                        @if($profile_photo)
                                        <img src="{{ $profile_photo->temporaryUrl() }}"
                                            class="w-full h-full object-cover">
                                        @else
                                        <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Photo de profil</p>
                                        <label
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl
                                                      text-xs font-medium text-gray-600 cursor-pointer hover:bg-gray-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                            </svg>
                                            Choisir
                                            <input type="file" wire:model="profile_photo" accept="image/*"
                                                class="hidden">
                                        </label>
                                        <p class="text-[11px] text-gray-400 mt-1">JPG, PNG — Max 2 Mo</p>
                                        @error('profile_photo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Nom --}}
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                        Nom complet <span class="text-red-400">*</span>
                                    </label>
                                    <input type="text" wire:model="name" placeholder="ex : BAMBA Souleymane" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                  text-sm text-navy placeholder-gray-400
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all
                                                  @error('name') border-red-300 bg-red-50/30 @enderror">
                                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                        Adresse email <span class="text-red-400">*</span>
                                    </label>
                                    <input type="email" wire:model="email" placeholder="ex : utilisateur@mairie.ci"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                  text-sm text-navy placeholder-gray-400
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all
                                                  @error('email') border-red-300 bg-red-50/30 @enderror">
                                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Rôle --}}
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                        Rôle <span class="text-red-400">*</span>
                                    </label>
                                    <div class="flex gap-2">
                                        @foreach(['admin' => 'Administrateur', 'utilisateur' => 'Utilisateur'] as $val
                                        => $label)
                                        <label
                                            class="flex-1 flex items-center justify-center py-2.5 border rounded-xl cursor-pointer text-xs font-medium transition-all
             {{ $role === $val ? 'bg-navy text-white border-navy' : 'bg-gray-50 text-gray-600 border-gray-200 hover:border-navy/30' }}">
                                            <input type="radio" wire:model.live="role" value="{{ $val }}"
                                                class="sr-only">
                                            {{ $label }}
                                        </label>
                                        @endforeach{{-- Description contextuelle --}}
                                        <div class="mt-2 p-2.5 bg-navy/4 rounded-lg">
                                            <p class="text-[11px] text-gray-500">
                                                @if($role === 'admin') Accès complet à tous les modules du système.
                                                @else Accès limité — consultation et saisies de base uniquement.
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    @error('role') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror

                                    {{-- Description du rôle --}}
                                    <div class="mt-2 p-2.5 bg-navy/4 rounded-lg">
                                        <p class="text-[11px] text-gray-500">
                                            @if($role === 'superadmin') Accès complet au système, gestion des
                                            utilisateurs incluse.
                                            @elseif($role === 'admin') Accès complet aux modules, sans gestion des
                                            utilisateurs.
                                            @else Accès en lecture seule — consultation sans modification.
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                {{-- Mot de passe --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Mot de passe <span class="text-red-400">*</span>
                                        </label>
                                        <input type="password" wire:model="password" placeholder="8 caractères minimum"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                      text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all
                                                      @error('password') border-red-300 bg-red-50/30 @enderror">
                                        @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Confirmation <span class="text-red-400">*</span>
                                        </label>
                                        <input type="password" wire:model="password_confirmation"
                                            placeholder="Répéter le mot de passe"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                      text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                    </div>
                                </div>

                            </div>

                            {{-- Footer --}}
                            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-3">
                                <button wire:click="closeModal"
                                    class="px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
                                    Annuler
                                </button>
                                <button wire:click="save" wire:loading.attr="disabled" wire:target="save"
                                    class="flex items-center gap-2 px-6 py-2.5 bg-navy text-white text-sm font-semibold rounded-xl
                                               hover:bg-[#0f2d56] transition-colors shadow-sm shadow-navy/20 disabled:opacity-60 disabled:cursor-not-allowed">
                                    <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        Créer l'utilisateur
                                    </span>
                                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        Création…
                                    </span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>