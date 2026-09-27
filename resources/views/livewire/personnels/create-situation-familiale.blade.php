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
                    <p class="text-xs font-medium text-white/50 uppercase tracking-widest mb-1">Carrière</p>
                    <h1 class="font-serif text-2xl font-bold leading-tight">Situations familiales</h1>
                    <p class="text-white/60 text-sm mt-1">Gérez les données familiales des agents permanents.</p>
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
                        Ajouter une fiche
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

        {{-- ── Table ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fadeInUp">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Agent</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">Situation</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Conjoint(e)</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Enfants</th>
                            <th class="px-5 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($fiches as $fiche)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    @if($fiche->agent?->photo_agent)
                                        <img src="{{ Storage::url($fiche->agent->photo_agent) }}"
                                             class="w-8 h-8 rounded-full object-cover shadow-sm shrink-0">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-navy/10 flex items-center justify-center text-navy font-bold text-xs shrink-0">
                                            {{ Str::upper(substr($fiche->agent?->nom_prenom_agent ?? '?', 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <span class="block font-semibold text-navy text-xs">{{ $fiche->agent?->nom_prenom_agent ?? '—' }}</span>
                                        <span class="block text-[10px] text-gray-400 font-mono mt-0.5">{{ $fiche->agent?->matricule ?? '—' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                @if($fiche->situation_mariale)
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold
                                        {{ in_array($fiche->situation_mariale, ['Marié(e)', 'Pacsé(e)']) ? 'bg-green/10 text-green' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $fiche->situation_mariale }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                <span class="text-xs text-navy font-medium">{{ $fiche->nom_prenom_femme ?? '—' }}</span>
                                @if($fiche->date_mariage)
                                    <span class="block text-[10px] text-gray-400 mt-0.5">
                                        Marié le {{ \Carbon\Carbon::parse($fiche->date_mariage)->locale('fr')->isoFormat('DD MMM YYYY') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                @php $nbEnfants = is_array($fiche->enfants) ? count($fiche->enfants) : count(json_decode($fiche->enfants ?? '[]', true)); @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-bold
                                             {{ $nbEnfants > 0 ? 'bg-navy/8 text-navy' : 'bg-gray-100 text-gray-400' }}">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                                    </svg>
                                    {{ $nbEnfants }} enfant{{ $nbEnfants > 1 ? 's' : '' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <button wire:click="viewFiche({{ $fiche->id }})"
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
                            <td colspan="5" class="px-5 py-8 text-center text-gray-400 text-sm">
                                Aucune situation familiale enregistrée.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($fiches->hasPages())
                <div class="px-5 py-3 border-t border-gray-100">{{ $fiches->links() }}</div>
            @endif
        </div>

        <p class="text-center text-xs text-gray-400 pb-4">
            &copy; {{ date('Y') }} Mairie de Cocody — Système de Gestion Municipale
        </p>
    </div>


    {{-- ═══════════════════════════════════════════════════════
         MODAL FICHE (consultation + modification)
    ═══════════════════════════════════════════════════════ --}}
    @if($showFicheModal && $this->selectedFiche)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeFicheModal"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative z-10 w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden">

                {{-- En-tête --}}
                <div class="bg-gradient-to-r from-navy via-[#0f2d56] to-[#1a3a6b] px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-5">
                            @if($this->selectedFiche->agent?->photo_agent)
                                <img src="{{ Storage::url($this->selectedFiche->agent->photo_agent) }}"
                                     class="w-16 h-16 rounded-2xl object-cover ring-2 ring-white/20 shrink-0">
                            @else
                                <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center text-2xl font-bold text-gold shrink-0">
                                    {{ Str::upper(substr($this->selectedFiche->agent?->nom_prenom_agent ?? '?', 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h2 class="font-serif text-xl font-bold">{{ $this->selectedFiche->agent?->nom_prenom_agent ?? '—' }}</h2>
                                <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                                    <span class="text-white/60 text-sm font-mono">{{ $this->selectedFiche->agent?->matricule ?? '' }}</span>
                                    @if($this->selectedFiche->situation_mariale)
                                        <span class="bg-white/10 text-white/80 text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                                            {{ $this->selectedFiche->situation_mariale }}
                                        </span>
                                    @endif
                                    @php $nbE = is_array($this->selectedFiche->enfants) ? count($this->selectedFiche->enfants) : count(json_decode($this->selectedFiche->enfants ?? '[]', true)); @endphp
                                    @if($nbE > 0)
                                        <span class="bg-gold/20 text-gold text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                                            {{ $nbE }} enfant{{ $nbE > 1 ? 's' : '' }}
                                        </span>
                                    @endif
                                </div>
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
                <div class="max-h-[60vh] overflow-y-auto">
                    <div class="p-6 space-y-4">

                        {{-- Section Pièce & Situation --}}
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                            <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z"/>
                                </svg>
                                Identité & Pièce d'identité
                            </h3>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

                                {{-- Situation maritale --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Situation maritale</p>
                                    @if($editMode)
                                        <select wire:model="edit_situation_mariale"
                                                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                       focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                            <option value="">— Sélectionner —</option>
                                            <option value="Célibataire">Célibataire</option>
                                            <option value="Marié(e)">Marié(e)</option>
                                            <option value="Divorcé(e)">Divorcé(e)</option>
                                            <option value="Veuf(ve)">Veuf(ve)</option>
                                            <option value="Pacsé(e)">Pacsé(e)</option>
                                        </select>
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedFiche->situation_mariale ?? '—' }}</p>
                                    @endif
                                </div>

                                {{-- Nature pièce --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Nature de la pièce</p>
                                    @if($editMode)
                                        <input type="text" wire:model="edit_nature_piece" placeholder="ex : CNI, Passeport…"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedFiche->nature_piece ?? '—' }}</p>
                                    @endif
                                </div>

                                {{-- N° pièce --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">N° de la pièce</p>
                                    @if($editMode)
                                        <input type="text" wire:model="edit_numero_piece" placeholder="ex : CI-2025-001"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedFiche->numero_piece ?? '—' }}</p>
                                    @endif
                                </div>

                                {{-- Date établissement --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date d'établissement</p>
                                    @if($editMode)
                                        <input type="date" wire:model="edit_date_etabli_piece"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">
                                            {{ $this->selectedFiche->date_etabli_piece ? \Carbon\Carbon::parse($this->selectedFiche->date_etabli_piece)->locale('fr')->isoFormat('DD MMM YYYY') : '—' }}
                                        </p>
                                    @endif
                                </div>

                            </div>
                        </div>

                        {{-- Section Conjoint --}}
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                            <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                </svg>
                                Conjoint(e)
                            </h3>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

                                @foreach([
                                    'edit_nom_prenom_femme' => ['label' => 'Nom & Prénom',      'field' => 'nom_prenom_femme', 'type' => 'text',  'placeholder' => 'ex : BAMBA Aminata'],
                                    'edit_group_sangin'     => ['label' => 'Groupe sanguin',     'field' => 'group_sangin',     'type' => 'text',  'placeholder' => 'ex : A+'],
                                    'edit_date_mariage'     => ['label' => 'Date de mariage',    'field' => 'date_mariage',     'type' => 'date',  'placeholder' => ''],
                                    'edit_lieu_mariage'     => ['label' => 'Lieu de mariage',    'field' => 'lieu_mariage',     'type' => 'text',  'placeholder' => 'ex : Abidjan'],
                                ] as $editField => $meta)
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ $meta['label'] }}</p>
                                    @if($editMode)
                                        <input type="{{ $meta['type'] }}" wire:model="{{ $editField }}"
                                               @if($meta['placeholder']) placeholder="{{ $meta['placeholder'] }}" @endif
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">
                                            @if($meta['type'] === 'date' && $this->selectedFiche->{$meta['field']})
                                                {{ \Carbon\Carbon::parse($this->selectedFiche->{$meta['field']})->locale('fr')->isoFormat('DD MMM YYYY') }}
                                            @else
                                                {{ $this->selectedFiche->{$meta['field']} ?? '—' }}
                                            @endif
                                        </p>
                                    @endif
                                </div>
                                @endforeach

                            </div>
                        </div>

                        {{-- Section Enfants --}}
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                            <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                                </svg>
                                Enfants
                                <span class="ml-auto text-[10px] bg-navy/8 text-navy px-2 py-0.5 rounded-full font-bold">
                                    {{ count($editMode ? $edit_enfants : (is_array($this->selectedFiche->enfants) ? $this->selectedFiche->enfants : json_decode($this->selectedFiche->enfants ?? '[]', true))) }}
                                </span>
                            </h3>

                            {{-- Liste des enfants --}}
                            @php
                                $listeEnfants = $editMode
                                    ? $edit_enfants
                                    : (is_array($this->selectedFiche->enfants) ? $this->selectedFiche->enfants : json_decode($this->selectedFiche->enfants ?? '[]', true));
                            @endphp

                            @if(count($listeEnfants) > 0)
                                <div class="space-y-2 mb-4">
                                    @foreach($listeEnfants as $idx => $enfant)
                                    <div class="flex items-center gap-3 bg-white border border-gray-100 rounded-xl px-4 py-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs shrink-0">
                                            {{ Str::upper(substr($enfant['nom_prenom'] ?? '?', 0, 1)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-navy truncate">{{ $enfant['nom_prenom'] ?? '—' }}</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">
                                                @if(!empty($enfant['date_naissance']))
                                                    Né(e) le {{ \Carbon\Carbon::parse($enfant['date_naissance'])->locale('fr')->isoFormat('DD MMM YYYY') }}
                                                    @if(!empty($enfant['lieu_naissance'])) à {{ $enfant['lieu_naissance'] }} @endif
                                                @endif
                                                @if(!empty($enfant['numero_extrait'])) · Extrait N° {{ $enfant['numero_extrait'] }} @endif
                                            </p>
                                        </div>
                                        @if($editMode)
                                            <button wire:click="supprimerEnfantEdit({{ $idx }})"
                                                    class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-600 transition-colors shrink-0">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-xs text-gray-400 mb-4 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                                    </svg>
                                    Aucun enfant enregistré.
                                </p>
                            @endif

                            {{-- Formulaire ajout enfant (mode édition uniquement) --}}
                            @if($editMode)
                                <div class="border-t border-gray-200 pt-4">
                                    <p class="text-xs font-semibold text-navy/60 uppercase tracking-wide mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                        </svg>
                                        Ajouter un enfant
                                    </p>
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                        <div class="sm:col-span-2">
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Nom & Prénom <span class="text-red-400">*</span></label>
                                            <input type="text" wire:model="edit_enfant_nom_prenom" placeholder="ex : KONÉ Junior"
                                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                          @error('edit_enfant_nom_prenom') border-red-300 @enderror">
                                            @error('edit_enfant_nom_prenom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date de naissance</label>
                                            <input type="date" wire:model="edit_enfant_date_naissance"
                                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Lieu de naissance</label>
                                            <input type="text" wire:model="edit_enfant_lieu_naissance" placeholder="ex : Abidjan"
                                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">N° extrait naissance</label>
                                            <input type="text" wire:model="edit_enfant_numero_extrait" placeholder="ex : EXT-001"
                                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                        </div>
                                        <div class="sm:col-span-3 flex items-end">
                                            <button wire:click="ajouterEnfantEdit"
                                                    class="flex items-center gap-2 px-4 py-2 bg-navy/8 text-navy text-xs font-semibold rounded-xl hover:bg-navy/12 transition-colors border border-navy/15">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                                </svg>
                                                Ajouter cet enfant à la liste
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>

                {{-- Footer (masqué pour les rôles sans droits d'édition) --}}
                @if($this->canManagePersonnel)
                <div class="px-6 py-4 border-t border-gray-100 bg-white flex items-center justify-between gap-3">
                    <button wire:click="confirmDelete"
                            wire:confirm="Êtes-vous sûr de vouloir supprimer cette fiche ? Cette action est irréversible."
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
                            <button wire:click="updateFiche" wire:loading.attr="disabled" wire:target="updateFiche"
                                    class="flex items-center gap-2 px-5 py-2.5 bg-green text-white text-sm font-semibold
                                           rounded-xl hover:bg-green/90 transition-colors shadow-sm disabled:opacity-60">
                                <span wire:loading.remove wire:target="updateFiche" class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                    Enregistrer
                                </span>
                                <span wire:loading wire:target="updateFiche" class="flex items-center gap-2">
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
         MODAL CRÉATION — 3 ÉTAPES
    ═══════════════════════════════════════════════════════ --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeModal"></div>
        <div class="flex min-h-full items-end justify-center p-4 sm:items-center sm:p-0">
            <div class="relative z-10 transform overflow-hidden rounded-2xl bg-gray-50 text-left
                        shadow-2xl sm:my-8 sm:w-full sm:max-w-3xl border border-white/20">

                <button wire:click="closeModal"
                        class="absolute top-4 right-4 z-[60] w-8 h-8 flex items-center justify-center
                               rounded-xl bg-gray-200 text-gray-600 hover:bg-red-500 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="max-h-[85vh] overflow-y-auto">
                    <div class="p-4 sm:p-6">
                        <div class="max-w-2xl mx-auto">

                            {{-- ── Stepper ── --}}
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= $maxSteps; $i++)
                                        <div class="flex flex-col items-center flex-1">
                                            <div @class([
                                                'w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300',
                                                'bg-navy text-white shadow-md shadow-navy/25' => $i === $step,
                                                'bg-green/90 text-white'                      => $i < $step,
                                                'bg-gray-100 text-gray-400'                   => $i > $step,
                                            ])>
                                                @if ($i < $step)
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                    </svg>
                                                @else
                                                    {{ $i }}
                                                @endif
                                            </div>
                                            <span @class([
                                                'text-[10px] mt-1.5 font-medium text-center leading-tight hidden sm:block',
                                                'text-navy'     => $i === $step,
                                                'text-green'    => $i < $step,
                                                'text-gray-400' => $i > $step,
                                            ])>{{ $this->stepLabel($i) }}</span>
                                        </div>
                                        @if ($i < $maxSteps)
                                            <div @class([
                                                'h-0.5 flex-1 mx-1 transition-all duration-500',
                                                'bg-green/80' => $i < $step,
                                                'bg-gray-200' => $i >= $step,
                                            ])></div>
                                        @endif
                                    @endfor
                                </div>
                            </div>

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

                                {{-- Titre étape --}}
                                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-navy/8 flex items-center justify-center shrink-0">
                                        @switch($step)
                                            @case(1)
                                                <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z"/>
                                                </svg>
                                            @break
                                            @case(2)
                                                <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                                </svg>
                                            @break
                                            @case(3)
                                                <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                                                </svg>
                                            @break
                                        @endswitch
                                    </div>
                                    <div>
                                        <h2 class="font-semibold text-navy text-sm">{{ $this->stepLabel($step) }}</h2>
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            @switch($step)
                                                @case(1) Rechercher l'agent par matricule puis compléter la pièce d'identité @break
                                                @case(2) Informations sur le conjoint ou le partenaire @break
                                                @case(3) Ajouter les enfants un par un @break
                                            @endswitch
                                        </p>
                                    </div>
                                </div>

                                {{-- ════════ ÉTAPE 1 — Agent & Pièce ════════ --}}
                                @if ($step === 1)
                                <div class="p-6 space-y-5">

                                    {{-- Recherche matricule --}}
                                    <div class="p-4 bg-navy/4 border border-navy/10 rounded-xl">
                                        <p class="text-xs font-semibold text-navy/70 uppercase tracking-wide mb-3 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                            </svg>
                                            Rechercher un agent par matricule
                                        </p>
                                        <div class="flex gap-2">
                                            <input type="text"
                                                   wire:model="matricule_search"
                                                   wire:keydown.enter="searchAgent"
                                                   placeholder="ex : MAT-2025-001"
                                                   class="flex-1 px-4 py-2.5 bg-white border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400 font-mono
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                            <button wire:click="searchAgent"
                                                    wire:loading.attr="disabled" wire:target="searchAgent"
                                                    class="flex items-center gap-2 px-4 py-2.5 bg-navy text-white text-sm font-semibold rounded-xl
                                                           hover:bg-[#0f2d56] transition-colors disabled:opacity-60">
                                                <span wire:loading.remove wire:target="searchAgent">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                                    </svg>
                                                </span>
                                                <span wire:loading wire:target="searchAgent">
                                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>

                                        {{-- Erreur de recherche --}}
                                        @if($agent_search_error)
                                            <div class="mt-3 flex items-start gap-2 text-red-600 text-xs">
                                                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                                                </svg>
                                                {{ $agent_search_error }}
                                            </div>
                                        @endif

                                        {{-- Agent trouvé --}}
                                        @if($agent_found)
                                            <div class="mt-3 flex items-center gap-3 p-3 bg-green/8 border border-green/20 rounded-xl">
                                                <div class="w-8 h-8 rounded-full bg-green/15 flex items-center justify-center shrink-0">
                                                    <svg class="w-4 h-4 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-green">Agent trouvé</p>
                                                    <p class="text-sm font-semibold text-navy">{{ $agent_nom_prenom }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    @error('agent_id')
                                        <p class="text-xs text-red-500 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H4.645c-1.73 0-2.813-1.874-1.948-3.374l7.52-13.02c.866-1.5 3.032-1.5 3.898 0l4.942 8.567ZM12 15.75h.007v.008H12v-.008Z"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror

                                    {{-- Situation maritale + Pièce --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Situation maritale
                                            </label>
                                            <select wire:model="situation_mariale"
                                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                           text-sm text-navy appearance-none
                                                           focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                                <option value="">— Sélectionner —</option>
                                                <option value="Célibataire">Célibataire</option>
                                                <option value="Marié(e)">Marié(e)</option>
                                                <option value="Divorcé(e)">Divorcé(e)</option>
                                                <option value="Veuf(ve)">Veuf(ve)</option>
                                                <option value="Pacsé(e)">Pacsé(e)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Nature de la pièce d'identité
                                            </label>
                                            <input type="text" wire:model="nature_piece" placeholder="ex : CNI, Passeport, Carte de résident…"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Numéro de la pièce
                                            </label>
                                            <input type="text" wire:model="numero_piece" placeholder="ex : CI-2025-0001"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Date d'établissement
                                            </label>
                                            <input type="date" wire:model="date_etabli_piece"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                    </div>

                                </div>
                                @endif

                                {{-- ════════ ÉTAPE 2 — Conjoint ════════ --}}
                                @if ($step === 2)
                                <div class="p-6 space-y-5">

                                    {{-- Info agent sélectionné --}}
                                    <div class="flex items-center gap-3 p-3 bg-navy/4 border border-navy/10 rounded-xl">
                                        <div class="w-8 h-8 rounded-full bg-navy/10 flex items-center justify-center text-navy font-bold text-xs shrink-0">
                                            {{ Str::upper(substr($agent_nom_prenom, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-medium">Agent concerné</p>
                                            <p class="text-sm font-semibold text-navy">{{ $agent_nom_prenom }}</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Nom & Prénom du conjoint(e)
                                            </label>
                                            <input type="text" wire:model="nom_prenom_femme" placeholder="ex : BAMBA Aminata Fatou"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Groupe sanguin
                                            </label>
                                            <select wire:model="group_sangin"
                                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                           text-sm text-navy appearance-none
                                                           focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                                <option value="">— Sélectionner —</option>
                                                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $gs)
                                                    <option value="{{ $gs }}">{{ $gs }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Date de mariage
                                            </label>
                                            <input type="date" wire:model="date_mariage"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Lieu de mariage
                                            </label>
                                            <input type="text" wire:model="lieu_mariage" placeholder="ex : Mairie de Cocody, Abidjan"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                    </div>

                                </div>
                                @endif

                                {{-- ════════ ÉTAPE 3 — Enfants ════════ --}}
                                @if ($step === 3)
                                <div class="p-6 space-y-5">

                                    {{-- Info agent --}}
                                    <div class="flex items-center gap-3 p-3 bg-navy/4 border border-navy/10 rounded-xl">
                                        <div class="w-8 h-8 rounded-full bg-navy/10 flex items-center justify-center text-navy font-bold text-xs shrink-0">
                                            {{ Str::upper(substr($agent_nom_prenom, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-medium">Agent concerné</p>
                                            <p class="text-sm font-semibold text-navy">{{ $agent_nom_prenom }}</p>
                                        </div>
                                        <span class="ml-auto text-xs font-bold text-navy bg-navy/8 px-3 py-1 rounded-full">
                                            {{ count($enfants) }} enfant{{ count($enfants) > 1 ? 's' : '' }}
                                        </span>
                                    </div>

                                    {{-- Liste des enfants ajoutés --}}
                                    @if(count($enfants) > 0)
                                        <div class="space-y-2">
                                            @foreach($enfants as $idx => $enfant)
                                            <div class="flex items-center gap-3 bg-gray-50 border border-gray-100 rounded-xl px-4 py-3">
                                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs shrink-0">
                                                    {{ Str::upper(substr($enfant['nom_prenom'] ?? '?', 0, 1)) }}
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-semibold text-navy">{{ $enfant['nom_prenom'] }}</p>
                                                    <p class="text-[10px] text-gray-400 mt-0.5">
                                                        @if(!empty($enfant['date_naissance']))
                                                            Né(e) le {{ \Carbon\Carbon::parse($enfant['date_naissance'])->locale('fr')->isoFormat('DD MMM YYYY') }}
                                                            @if(!empty($enfant['lieu_naissance'])) à {{ $enfant['lieu_naissance'] }} @endif
                                                        @endif
                                                        @if(!empty($enfant['numero_extrait'])) · N° {{ $enfant['numero_extrait'] }} @endif
                                                    </p>
                                                </div>
                                                <button wire:click="supprimerEnfant({{ $idx }})"
                                                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-600 transition-colors shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Formulaire saisie d'un enfant --}}
                                    <div class="p-4 bg-indigo-50/50 border border-indigo-100 rounded-xl">
                                        <p class="text-xs font-semibold text-indigo-700/80 uppercase tracking-wide mb-3 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                            </svg>
                                            {{ count($enfants) === 0 ? 'Ajouter un enfant' : 'Ajouter un autre enfant' }}
                                        </p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <div class="sm:col-span-2">
                                                <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">
                                                    Nom & Prénom <span class="text-red-400">*</span>
                                                </label>
                                                <input type="text" wire:model="enfant_nom_prenom" placeholder="ex : KONÉ Junior"
                                                       class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                              @error('enfant_nom_prenom') border-red-300 @enderror">
                                                @error('enfant_nom_prenom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date de naissance</label>
                                                <input type="date" wire:model="enfant_date_naissance"
                                                       class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                                @error('enfant_date_naissance') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Lieu de naissance</label>
                                                <input type="text" wire:model="enfant_lieu_naissance" placeholder="ex : Abidjan"
                                                       class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">N° extrait de naissance</label>
                                                <input type="text" wire:model="enfant_numero_extrait" placeholder="ex : EXT-2025-001"
                                                       class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                            </div>
                                            <div class="sm:col-span-2">
                                                <button wire:click="ajouterEnfant"
                                                        class="flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-xs font-semibold
                                                               rounded-xl hover:bg-indigo-700 transition-colors w-full sm:w-auto justify-center">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                                    </svg>
                                                    Ajouter cet enfant à la liste
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="text-[11px] text-gray-400 text-center flex items-center justify-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                                        </svg>
                                        Vous pouvez enregistrer sans ajouter d'enfant. Vous pourrez en ajouter plus tard via la modification.
                                    </p>

                                </div>
                                @endif

                                {{-- ── Footer navigation ── --}}
                                <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-3">

                                    @if ($step > 1)
                                        <button type="button" wire:click="prevStep"
                                                wire:loading.attr="disabled" wire:target="prevStep"
                                                class="flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl
                                                       hover:bg-gray-200 transition-colors disabled:opacity-50">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                                            </svg>
                                            Précédent
                                        </button>
                                    @else
                                        <div></div>
                                    @endif

                                    <span class="text-xs text-gray-400 hidden sm:block">{{ $step }} / {{ $maxSteps }}</span>

                                    @if ($step < $maxSteps)
                                        <button type="button" wire:click="nextStep"
                                                wire:loading.attr="disabled" wire:target="nextStep"
                                                class="flex items-center gap-2 px-6 py-2.5 bg-navy text-white text-sm font-semibold rounded-xl
                                                       hover:bg-[#0f2d56] transition-colors shadow-sm shadow-navy/20 disabled:opacity-60 disabled:cursor-not-allowed">
                                            <span wire:loading.remove wire:target="nextStep" class="flex items-center gap-2">
                                                Suivant
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                                                </svg>
                                            </span>
                                            <span wire:loading wire:target="nextStep" class="flex items-center gap-2">
                                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                </svg>
                                                Validation…
                                            </span>
                                        </button>
                                    @else
                                        <button type="button" wire:click="save"
                                                wire:loading.attr="disabled" wire:target="save"
                                                class="flex items-center gap-2 px-6 py-2.5 bg-green text-white text-sm font-semibold rounded-xl
                                                       hover:bg-green/90 transition-colors shadow-sm shadow-green/20 disabled:opacity-60 disabled:cursor-not-allowed">
                                            <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>
                                                Enregistrer la fiche
                                            </span>
                                            <span wire:loading wire:target="save" class="flex items-center gap-2">
                                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                </svg>
                                                Enregistrement…
                                            </span>
                                        </button>
                                    @endif

                                </div>

                            </div>
                            {{-- fin card --}}

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif

</div>
