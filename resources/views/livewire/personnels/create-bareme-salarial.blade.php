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
                    <p class="text-xs font-medium text-white/50 uppercase tracking-widest mb-1">Paie</p>
                    <h1 class="font-serif text-2xl font-bold leading-tight">Barème salarial</h1>
                    <p class="text-white/60 text-sm mt-1">Gérez les catégories, échelons et grilles de salaires.</p>
                </div>
                @if($this->canManagePersonnel)
                <div class="shrink-0">
                    <button wire:click="openModal"
                            class="inline-flex items-center gap-2 px-5 py-2.5
                                   bg-gold text-navy text-sm font-semibold rounded-xl
                                   hover:bg-yellow-400 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Ajouter un barème
                    </button>
                </div>
                @endif
            </div>
            <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full border-[28px] border-white/5 pointer-events-none"></div>
            <div class="absolute right-16 -bottom-8 w-28 h-28 rounded-full border-[14px] border-white/5 pointer-events-none"></div>
            <div class="absolute right-6 top-6 w-10 h-10 rounded-full bg-gold/20 pointer-events-none"></div>
        </div>

        {{-- ── Messages flash ── --}}
        @if (session()->has('success'))
            <div class="p-4 rounded-xl bg-green/10 border border-green/20 text-green font-medium text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 font-medium text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- ── Barre de recherche + filtre ── --}}
        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Recherche --}}
            <div class="relative flex-1">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
                <input type="text"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Rechercher par catégorie ou échelon…"
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl
                              text-sm text-navy placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
            </div>
            {{-- Filtre catégorie --}}
            <div class="relative sm:w-56">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
                </svg>
                <select wire:model.live="filtre_categorie"
                        class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl
                               text-sm text-navy appearance-none
                               focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                    <option value="">Toutes les catégories</option>
                    @foreach($this->categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- ── Table ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fadeInUp">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Catégorie / Échelon</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Indice</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">Salaire de base</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Salaire brut</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Indem. résidence</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($baremes as $b)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-navy/8 flex items-center justify-center shrink-0">
                                        <span class="text-xs font-bold text-navy">{{ Str::upper(substr($b->categorie, 0, 2)) }}</span>
                                    </div>
                                    <div>
                                        <span class="block font-bold text-navy text-xs">{{ $b->categorie }}</span>
                                        <span class="block text-[10px] text-gray-400 mt-0.5">Échelon {{ $b->echelon }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex px-2.5 py-1 bg-navy/8 text-navy text-xs font-bold rounded-lg">
                                    {{ number_format($b->indice, 0, ',', ' ') }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <span class="text-xs font-semibold text-navy">
                                    {{ number_format($b->salaire_base, 0, ',', ' ') }}
                                </span>
                                <span class="text-[10px] text-gray-400 ml-1">FCFA</span>
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                <span class="text-xs font-semibold text-green">
                                    {{ number_format($b->salaire_brut, 0, ',', ' ') }}
                                </span>
                                <span class="text-[10px] text-gray-400 ml-1">FCFA</span>
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                @if($b->indem_residence > 0)
                                    <span class="text-xs font-medium text-gray-600">
                                        {{ number_format($b->indem_residence, 0, ',', ' ') }}
                                    </span>
                                    <span class="text-[10px] text-gray-400 ml-1">FCFA</span>
                                @else
                                    <span class="text-xs text-gray-300">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <button wire:click="viewFiche({{ $b->id }})"
                                        class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center
                                               text-gray-400 hover:text-navy hover:bg-gray-100 transition-colors ml-auto">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center">
                                <svg class="w-10 h-10 mx-auto mb-3 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <p class="text-gray-400 text-sm">Aucun barème enregistré.</p>
                                @if($this->canManagePersonnel)
                                <button wire:click="openModal"
                                        class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-navy hover:text-gold transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                    </svg>
                                    Créer le premier barème
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($baremes->hasPages())
                <div class="px-5 py-3 border-t border-gray-100">{{ $baremes->links() }}</div>
            @endif
        </div>

        <p class="text-center text-xs text-gray-400 pb-4">
            &copy; {{ date('Y') }} Mairie de Cocody — Système de Gestion Municipale
        </p>
    </div>


    {{-- ═══════════════════════════════════════════════════════
         MODAL FICHE (consultation + modification)
    ═══════════════════════════════════════════════════════ --}}
    @if($showFicheModal && $this->selectedBareme)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeFicheModal"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative z-10 w-full max-w-xl bg-white rounded-2xl shadow-2xl overflow-hidden">

                {{-- En-tête --}}
                <div class="bg-gradient-to-r from-navy via-[#0f2d56] to-[#1a3a6b] px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-gold font-bold text-lg shrink-0">
                                {{ Str::upper(substr($this->selectedBareme->categorie, 0, 2)) }}
                            </div>
                            <div>
                                @if($editMode)
                                    <div class="flex items-center gap-2">
                                        <input type="text" wire:model="edit_categorie"
                                               class="bg-white/10 border border-white/20 rounded-xl px-3 py-1.5
                                                      text-white font-serif text-lg font-bold w-28
                                                      focus:outline-none focus:ring-2 focus:ring-gold/50 placeholder-white/50"
                                               placeholder="Catégorie">
                                        <span class="text-white/60">—</span>
                                        <input type="text" wire:model="edit_echelon"
                                               class="bg-white/10 border border-white/20 rounded-xl px-3 py-1.5
                                                      text-white text-sm font-medium w-28
                                                      focus:outline-none focus:ring-2 focus:ring-gold/50 placeholder-white/50"
                                               placeholder="Échelon">
                                    </div>
                                    @error('edit_categorie') <p class="text-xs text-red-300 mt-1">{{ $message }}</p> @enderror
                                @else
                                    <h2 class="font-serif text-xl font-bold">{{ $this->selectedBareme->categorie }}</h2>
                                    <p class="text-white/60 text-sm mt-0.5">Échelon {{ $this->selectedBareme->echelon }}</p>
                                @endif
                            </div>
                        </div>
                        <button wire:click="closeFicheModal"
                                class="w-8 h-8 flex items-center justify-center rounded-xl bg-white/10 text-white/60 hover:bg-red-500 hover:text-white transition-colors">
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

                {{-- Corps --}}
                <div class="p-6 space-y-4">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Indice --}}
                        <div class="bg-gray-50 rounded-xl border border-gray-100 p-4">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1.5">Indice</p>
                            @if($editMode)
                                <input type="number" wire:model="edit_indice" min="1" placeholder="ex : 320"
                                       class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                              @error('edit_indice') border-red-300 @enderror">
                                @error('edit_indice') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            @else
                                <p class="text-2xl font-bold text-navy">{{ number_format($this->selectedBareme->indice, 0, ',', ' ') }}</p>
                            @endif
                        </div>

                        {{-- Salaire de base --}}
                        <div class="bg-gray-50 rounded-xl border border-gray-100 p-4">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1.5">Salaire de base</p>
                            @if($editMode)
                                <div class="relative">
                                    <input type="number" wire:model="edit_salaire_base" min="0" step="100" placeholder="ex : 150000"
                                           class="w-full px-3 py-2 pr-14 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                  @error('edit_salaire_base') border-red-300 @enderror">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 font-medium">FCFA</span>
                                </div>
                                @error('edit_salaire_base') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            @else
                                <p class="text-lg font-bold text-navy">{{ number_format($this->selectedBareme->salaire_base, 0, ',', ' ') }}</p>
                                <p class="text-[10px] text-gray-400">FCFA</p>
                            @endif
                        </div>

                        {{-- Salaire brut --}}
                        <div class="bg-green/5 rounded-xl border border-green/15 p-4">
                            <p class="text-[10px] font-bold text-green/70 uppercase tracking-wide mb-1.5">Salaire brut</p>
                            @if($editMode)
                                <div class="relative">
                                    <input type="number" wire:model="edit_salaire_brut" min="0" step="100" placeholder="ex : 175000"
                                           class="w-full px-3 py-2 pr-14 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                  @error('edit_salaire_brut') border-red-300 @enderror">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 font-medium">FCFA</span>
                                </div>
                                @error('edit_salaire_brut') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            @else
                                <p class="text-lg font-bold text-green">{{ number_format($this->selectedBareme->salaire_brut, 0, ',', ' ') }}</p>
                                <p class="text-[10px] text-gray-400">FCFA</p>
                            @endif
                        </div>

                        {{-- Indemnité de résidence --}}
                        <div class="bg-gray-50 rounded-xl border border-gray-100 p-4">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1.5">Indem. de résidence</p>
                            @if($editMode)
                                <div class="relative">
                                    <input type="number" wire:model="edit_indem_residence" min="0" step="100" placeholder="ex : 25000"
                                           class="w-full px-3 py-2 pr-14 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 font-medium">FCFA</span>
                                </div>
                            @else
                                @if($this->selectedBareme->indem_residence > 0)
                                    <p class="text-lg font-bold text-navy">{{ number_format($this->selectedBareme->indem_residence, 0, ',', ' ') }}</p>
                                    <p class="text-[10px] text-gray-400">FCFA</p>
                                @else
                                    <p class="text-sm text-gray-400">Non définie</p>
                                @endif
                            @endif
                        </div>

                    </div>

                    {{-- Agents rattachés --}}
                    @if(! $editMode)
                    <div class="flex items-center gap-2 p-3 bg-navy/4 border border-navy/10 rounded-xl">
                        <svg class="w-4 h-4 text-navy/50 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                        </svg>
                        @php $nbAgents = $this->selectedBareme->agents()->count(); @endphp
                        <p class="text-xs text-navy/70">
                            <span class="font-bold">{{ $nbAgents }}</span>
                            agent{{ $nbAgents > 1 ? 's' : '' }} rattaché{{ $nbAgents > 1 ? 's' : '' }} à ce barème
                        </p>
                    </div>
                    @endif

                </div>

                {{-- Footer (masqué pour les rôles sans droits d'édition) --}}
                @if($this->canManagePersonnel)
                <div class="px-6 py-4 border-t border-gray-100 bg-white flex items-center justify-between gap-3">
                    <button wire:click="confirmDelete"
                            wire:confirm="Êtes-vous sûr de vouloir supprimer ce barème ? Les agents rattachés ne pourront pas être supprimés."
                            class="flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 text-sm font-semibold
                                   rounded-xl hover:bg-red-100 transition-colors border border-red-100">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                        </svg>
                        Supprimer
                    </button>
                    <div class="flex items-center gap-2">
                        @if($editMode)
                            <button wire:click="cancelEdit"
                                    class="flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                </svg>
                                Annuler
                            </button>
                            <button wire:click="update"
                                    wire:loading.attr="disabled" wire:target="update"
                                    class="flex items-center gap-2 px-5 py-2.5 bg-green text-white text-sm font-semibold
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
                                    class="flex items-center gap-2 px-5 py-2.5 bg-navy text-white text-sm font-semibold
                                           rounded-xl hover:bg-[#0f2d56] transition-colors shadow-sm shadow-navy/20">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                                </svg>
                                Modifier
                            </button>
                        @endif
                    </div>
                </div>
                @endif

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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="max-h-[85vh] overflow-y-auto">
                    <div class="p-6">

                        {{-- Erreurs --}}
                        @if ($errors->any())
                            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">
                                <p class="text-sm font-medium text-red-700 mb-2">Veuillez corriger les erreurs :</p>
                                <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5">
                                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Card formulaire --}}
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                            {{-- Titre --}}
                            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-navy/8 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="font-semibold text-navy text-sm">Nouveau barème salarial</h2>
                                    <p class="text-xs text-gray-400 mt-0.5">Renseignez la catégorie, l'échelon et les montants</p>
                                </div>
                            </div>

                            <div class="p-6 space-y-4">

                                {{-- Catégorie + Échelon --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Catégorie <span class="text-red-400">*</span>
                                        </label>
                                        <input type="text" wire:model="categorie"
                                               placeholder="ex : A1, B2, C…"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                      text-sm text-navy placeholder-gray-400 uppercase
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all
                                                      @error('categorie') border-red-300 bg-red-50/30 @enderror">
                                        @error('categorie') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Échelon <span class="text-red-400">*</span>
                                        </label>
                                        <input type="text" wire:model="echelon"
                                               placeholder="ex : 1, 2, 3, A…"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                      text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all
                                                      @error('echelon') border-red-300 bg-red-50/30 @enderror">
                                        @error('echelon') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                {{-- Indice --}}
                                <div>
                                    <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                        Indice <span class="text-red-400">*</span>
                                    </label>
                                    <input type="number" wire:model="indice" min="1" placeholder="ex : 320"
                                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                  text-sm text-navy placeholder-gray-400
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all
                                                  @error('indice') border-red-300 bg-red-50/30 @enderror">
                                    @error('indice') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Salaire de base + Salaire brut --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Salaire de base <span class="text-red-400">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="number" wire:model="salaire_base" min="0" step="100"
                                                   placeholder="ex : 150 000"
                                                   class="w-full px-4 py-2.5 pr-14 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all
                                                          @error('salaire_base') border-red-300 bg-red-50/30 @enderror">
                                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 font-medium select-none">FCFA</span>
                                        </div>
                                        @error('salaire_base') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Salaire brut <span class="text-red-400">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="number" wire:model="salaire_brut" min="0" step="100"
                                                   placeholder="ex : 175 000"
                                                   class="w-full px-4 py-2.5 pr-14 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all
                                                          @error('salaire_brut') border-red-300 bg-red-50/30 @enderror">
                                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 font-medium select-none">FCFA</span>
                                        </div>
                                        @error('salaire_brut') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                {{-- Indemnité de résidence --}}
                                <div>
                                    <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                        Indemnité de résidence
                                    </label>
                                    <div class="relative">
                                        <input type="number" wire:model="indem_residence" min="0" step="100"
                                               placeholder="ex : 25 000"
                                               class="w-full px-4 py-2.5 pr-14 bg-gray-50 border border-gray-200 rounded-xl
                                                      text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 font-medium select-none">FCFA</span>
                                    </div>
                                </div>

                                {{-- Récapitulatif live --}}
                                @if($salaire_base || $salaire_brut)
                                <div class="p-4 bg-navy/4 border border-navy/10 rounded-xl">
                                    <p class="text-[10px] font-bold text-navy/50 uppercase tracking-wide mb-3">Aperçu</p>
                                    <div class="grid grid-cols-3 gap-3 text-center">
                                        <div>
                                            <p class="text-[10px] text-gray-400">Base</p>
                                            <p class="text-sm font-bold text-navy">{{ $salaire_base ? number_format((float)$salaire_base, 0, ',', ' ') : '—' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400">Brut</p>
                                            <p class="text-sm font-bold text-green">{{ $salaire_brut ? number_format((float)$salaire_brut, 0, ',', ' ') : '—' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400">Résidence</p>
                                            <p class="text-sm font-bold text-navy">{{ $indem_residence ? number_format((float)$indem_residence, 0, ',', ' ') : '—' }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>

                            {{-- Footer --}}
                            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-3">
                                <button wire:click="closeModal"
                                        class="flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
                                    Annuler
                                </button>
                                <button wire:click="save"
                                        wire:loading.attr="disabled" wire:target="save"
                                        class="flex items-center gap-2 px-6 py-2.5 bg-navy text-white text-sm font-semibold rounded-xl
                                               hover:bg-[#0f2d56] transition-colors shadow-sm shadow-navy/20 disabled:opacity-60 disabled:cursor-not-allowed">
                                    <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                        </svg>
                                        Enregistrer le barème
                                    </span>
                                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        Enregistrement…
                                    </span>
                                </button>
                            </div>

                        </div>
                        {{-- fin card --}}

                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif

</div>
