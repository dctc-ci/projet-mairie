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
                    <p class="text-xs font-medium text-white/50 uppercase tracking-widest mb-1">Personnel</p>
                    <h1 class="font-serif text-2xl font-bold leading-tight">Liste des stagiaires</h1>
                    <p class="text-white/60 text-sm mt-1">Retrouvez ici tous les stagiaires de la mairie.</p>
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
                        Ajouter un stagiaire
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
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Stagiaire</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">Diplôme</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Stage</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Note</th>
                            <th class="px-5 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($stagiaires as $stagiaire)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    {{-- Avatar initiales violet/indigo pour distinguer les stagiaires --}}
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs shrink-0">
                                        {{ Str::upper(substr($stagiaire->nom_prenom_stagiaire, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="block font-semibold text-navy text-xs">{{ $stagiaire->nom_prenom_stagiaire }}</span>
                                        <span class="block text-[10px] text-gray-400 mt-0.5">
                                            {{ $stagiaire->annee_exercice ? 'Année '.$stagiaire->annee_exercice : 'Année non définie' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <span class="block text-xs text-navy font-medium">{{ $stagiaire->nature_diplome ?? '—' }}</span>
                                <span class="block text-[10px] text-gray-400 mt-0.5">{{ $stagiaire->option ?? '' }}</span>
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                <span class="block text-xs text-navy font-medium">{{ $stagiaire->service_accueil ?? '—' }}</span>
                                <span class="block text-[10px] text-gray-400 mt-0.5">
                                    @if($stagiaire->date_demarrage && $stagiaire->date_fin)
                                        {{ \Carbon\Carbon::parse($stagiaire->date_demarrage)->locale('fr')->isoFormat('DD MMM') }}
                                        →
                                        {{ \Carbon\Carbon::parse($stagiaire->date_fin)->locale('fr')->isoFormat('DD MMM YYYY') }}
                                    @else
                                        Dates non définies
                                    @endif
                                </span>
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                @if($stagiaire->note !== null)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold
                                        {{ $stagiaire->note >= 14 ? 'bg-green/10 text-green' : ($stagiaire->note >= 10 ? 'bg-gold/10 text-gold' : 'bg-red-50 text-red-500') }}">
                                        {{ number_format($stagiaire->note, 2) }}/20
                                    </span>
                                    @if($stagiaire->appreciation)
                                        <span class="block text-[10px] text-gray-400 mt-0.5">{{ $stagiaire->appreciation }}</span>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <button wire:click="viewAgent({{ $stagiaire->id }})"
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
                                Aucun stagiaire enregistré dans la base.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($stagiaires->hasPages())
                <div class="px-5 py-3 border-t border-gray-100">
                    {{ $stagiaires->links() }}
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <p class="text-center text-xs text-gray-400 pb-4">
            &copy; {{ date('Y') }} Mairie de Cocody — Système de Gestion Municipale
        </p>

    </div>


    {{-- ═══════════════════════════════════════════════════════
         MODAL FICHE STAGIAIRE (consultation + modification)
    ═══════════════════════════════════════════════════════ --}}
    @if($showAgentModal && $this->selectedStagiaire)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeAgentModal"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative z-10 w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden">

                {{-- En-tête --}}
                <div class="bg-gradient-to-r from-navy via-[#0f2d56] to-[#1a3a6b] px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 rounded-2xl bg-indigo-500/30 flex items-center justify-center text-2xl font-bold text-white shrink-0">
                                {{ Str::upper(substr($this->selectedStagiaire->nom_prenom_stagiaire, 0, 1)) }}
                            </div>
                            <div>
                                @if($editMode)
                                    <input type="text" wire:model="edit_nom_prenom_stagiaire"
                                           class="bg-white/10 border border-white/20 rounded-xl px-3 py-1.5
                                                  text-white font-serif text-xl font-bold w-72
                                                  focus:outline-none focus:ring-2 focus:ring-gold/50 placeholder-white/50">
                                    @error('edit_nom_prenom_stagiaire')
                                        <p class="text-xs text-red-300 mt-1">{{ $message }}</p>
                                    @enderror
                                @else
                                    <h2 class="font-serif text-xl font-bold">{{ $this->selectedStagiaire->nom_prenom_stagiaire }}</h2>
                                @endif
                                <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                                    <span class="text-white/60 text-sm">Stagiaire</span>
                                    @if($this->selectedStagiaire->annee_exercice)
                                        <span class="bg-white/10 text-white/80 text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                                            Année {{ $this->selectedStagiaire->annee_exercice }}
                                        </span>
                                    @endif
                                    @if($this->selectedStagiaire->inscri_emploi_jeune)
                                        <span class="bg-gold/20 text-gold text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                                            Emploi Jeune
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <button wire:click="closeAgentModal"
                                class="w-8 h-8 flex items-center justify-center rounded-xl
                                       bg-white/10 text-white/60 hover:bg-red-500 hover:text-white transition-colors">
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
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Corps --}}
                <div class="max-h-[60vh] overflow-y-auto">
                    <div class="p-6 space-y-4">

                        {{-- Section Identité & Contacts --}}
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                            <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                </svg>
                                Identité & Contacts
                            </h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">

                                @php
                                    $identiteFields = [
                                        'edit_date_naissance_stagiaire'  => ['label' => 'Date de naissance', 'field' => 'date_naissance_stagiaire', 'type' => 'date'],
                                        'edit_lieu_naissance_stagiaire'  => ['label' => 'Lieu de naissance', 'field' => 'lieu_naissance_stagiaire',  'type' => 'text'],
                                        'edit_contact_stagiaire'         => ['label' => 'Téléphone',          'field' => 'contact_stagiaire',         'type' => 'tel'],
                                        'edit_contact_urgence_stagiaire' => ['label' => 'Contact urgence',    'field' => 'contact_urgence_stagiaire', 'type' => 'tel'],
                                    ];
                                @endphp

                                @foreach($identiteFields as $editField => $meta)
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ $meta['label'] }}</p>
                                    @if($editMode)
                                        <input type="{{ $meta['type'] }}" wire:model="{{ $editField }}"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                        @error($editField) <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    @else
                                        <p class="text-sm font-medium text-navy">
                                            @if($meta['type'] === 'date' && $this->selectedStagiaire->{$meta['field']})
                                                {{ \Carbon\Carbon::parse($this->selectedStagiaire->{$meta['field']})->locale('fr')->isoFormat('DD MMM YYYY') }}
                                            @else
                                                {{ $this->selectedStagiaire->{$meta['field']} ?? '—' }}
                                            @endif
                                        </p>
                                    @endif
                                </div>
                                @endforeach

                            </div>
                        </div>

                        {{-- Section Diplôme --}}
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                            <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 10.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/>
                                </svg>
                                Diplôme
                            </h3>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

                                @php
                                    $diplomeFields = [
                                        'edit_nature_diplome' => ['label' => 'Nature du diplôme', 'field' => 'nature_diplome', 'placeholder' => 'ex : BTS, Licence…'],
                                        'edit_numero_diplome' => ['label' => 'N° diplôme',         'field' => 'numero_diplome', 'placeholder' => 'ex : DIP-2025-001'],
                                        'edit_session'        => ['label' => 'Session',             'field' => 'session',        'placeholder' => 'ex : 2024'],
                                        'edit_option'         => ['label' => 'Option / Spécialité', 'field' => 'option',         'placeholder' => 'ex : Comptabilité'],
                                    ];
                                @endphp

                                @foreach($diplomeFields as $editField => $meta)
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ $meta['label'] }}</p>
                                    @if($editMode)
                                        <input type="text" wire:model="{{ $editField }}" placeholder="{{ $meta['placeholder'] }}"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedStagiaire->{$meta['field']} ?? '—' }}</p>
                                    @endif
                                </div>
                                @endforeach

                            </div>
                        </div>

                        {{-- Section Stage --}}
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                            <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"/>
                                </svg>
                                Informations du stage
                            </h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">

                                {{-- Année d'exercice --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Année d'exercice</p>
                                    @if($editMode)
                                        <input type="text" wire:model="edit_annee_exercice" placeholder="ex : 2025"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedStagiaire->annee_exercice ?? '—' }}</p>
                                    @endif
                                </div>

                                {{-- Service d'accueil --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Service d'accueil</p>
                                    @if($editMode)
                                        <input type="text" wire:model="edit_service_accueil" placeholder="ex : Direction Financière"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedStagiaire->service_accueil ?? '—' }}</p>
                                    @endif
                                </div>

                                {{-- Maître de stage --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Maître de stage</p>
                                    @if($editMode)
                                        <input type="text" wire:model="edit_maitre_stage" placeholder="ex : M. KOUASSI"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedStagiaire->maitre_stage ?? '—' }}</p>
                                    @endif
                                </div>

                                {{-- Date démarrage --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date de démarrage</p>
                                    @if($editMode)
                                        <input type="date" wire:model="edit_date_demarrage"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">
                                            {{ $this->selectedStagiaire->date_demarrage ? \Carbon\Carbon::parse($this->selectedStagiaire->date_demarrage)->locale('fr')->isoFormat('DD MMM YYYY') : '—' }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Date fin --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date de fin</p>
                                    @if($editMode)
                                        <input type="date" wire:model="edit_date_fin"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                        @error('edit_date_fin') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    @else
                                        <p class="text-sm font-medium text-navy">
                                            {{ $this->selectedStagiaire->date_fin ? \Carbon\Carbon::parse($this->selectedStagiaire->date_fin)->locale('fr')->isoFormat('DD MMM YYYY') : '—' }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Thème de stage (col-span) --}}
                                <div class="sm:col-span-3">
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Thème du stage</p>
                                    @if($editMode)
                                        <input type="text" wire:model="edit_theme_stage" placeholder="ex : Gestion budgétaire des collectivités locales"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedStagiaire->theme_stage ?? '—' }}</p>
                                    @endif
                                </div>

                            </div>
                        </div>

                        {{-- Section Évaluation --}}
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                            <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>
                                </svg>
                                Évaluation
                            </h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">

                                {{-- Note --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Note /20</p>
                                    @if($editMode)
                                        <input type="number" wire:model="edit_note" min="0" max="20" step="0.5" placeholder="ex : 15"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                        @error('edit_note') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    @else
                                        @if($this->selectedStagiaire->note !== null)
                                            <div class="flex items-center gap-2">
                                                <span class="text-lg font-bold text-navy">{{ number_format($this->selectedStagiaire->note, 2) }}</span>
                                                <span class="text-xs text-gray-400">/20</span>
                                            </div>
                                        @else
                                            <p class="text-sm font-medium text-navy">—</p>
                                        @endif
                                    @endif
                                </div>

                                {{-- Appréciation --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Appréciation</p>
                                    @if($editMode)
                                        <select wire:model="edit_appreciation"
                                                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                       focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                            <option value="">— Sélectionner —</option>
                                            <option value="Très bien">Très bien</option>
                                            <option value="Bien">Bien</option>
                                            <option value="Assez bien">Assez bien</option>
                                            <option value="Passable">Passable</option>
                                            <option value="Insuffisant">Insuffisant</option>
                                        </select>
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedStagiaire->appreciation ?? '—' }}</p>
                                    @endif
                                </div>

                                {{-- Inscrit emploi jeune --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Emploi jeune</p>
                                    @if($editMode)
                                        <label class="flex items-center gap-3 mt-1 cursor-pointer">
                                            <div class="relative">
                                                <input type="checkbox" wire:model.live="edit_inscri_emploi_jeune" class="sr-only peer">
                                                <div class="w-10 h-5 bg-gray-200 rounded-full peer
                                                            peer-checked:bg-navy transition-colors duration-200"></div>
                                                <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow
                                                            peer-checked:translate-x-5 transition-transform duration-200"></div>
                                            </div>
                                            <span class="text-sm text-gray-600 font-medium">
                                                {{ $edit_inscri_emploi_jeune ? 'Inscrit' : 'Non inscrit' }}
                                            </span>
                                        </label>
                                    @else
                                        @if($this->selectedStagiaire->inscri_emploi_jeune)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gold/10 text-gold text-xs font-bold rounded-lg">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>
                                                Inscrit
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 text-gray-500 text-xs font-bold rounded-lg">
                                                Non inscrit
                                            </span>
                                        @endif
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                {{-- Footer actions --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-white flex items-center justify-between gap-3 flex-wrap">

    {{-- Gauche : Supprimer --}}
    @if($this->canManagePersonnel)
    <button wire:click="confirmDelete"
            wire:confirm="Êtes-vous sûr de vouloir supprimer ce stagiaire ? Cette action est irréversible."
            class="flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 text-sm font-semibold
                   rounded-xl hover:bg-red-100 transition-colors border border-red-100">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
        </svg>
        Supprimer
    </button>
    @endif

    {{-- Droite : 3 boutons impression + Modifier/Enregistrer --}}
    <div class="flex items-center gap-2 flex-wrap">

        @if(!$editMode)
        {{-- Fiche stagiaire --}}
        <a href="{{ route('stagiaires.print.fiche', $this->selectedStagiaire->id) }}"
           target="_blank"
           class="flex items-center gap-1.5 px-3 py-2.5 bg-indigo-50 text-indigo-700 text-xs font-semibold
                  rounded-xl hover:bg-indigo-100 transition-colors border border-indigo-100">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
            </svg>
            Fiche stagiaire
        </a>

        {{-- Fiche démarrage --}}
        <a href="{{ route('stagiaires.print.demarrage', $this->selectedStagiaire->id) }}"
           target="_blank"
           class="flex items-center gap-1.5 px-3 py-2.5 bg-gold/10 text-gold text-xs font-semibold
                  rounded-xl hover:bg-gold/20 transition-colors border border-gold/20">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z"/>
            </svg>
            Fiche démarrage
        </a>

        {{-- Fiche fin de stage --}}
        <a href="{{ route('stagiaires.print.fin', $this->selectedStagiaire->id) }}"
           target="_blank"
           class="flex items-center gap-1.5 px-3 py-2.5 bg-green/8 text-green text-xs font-semibold
                  rounded-xl hover:bg-green/15 transition-colors border border-green/20">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            Fiche fin de stage
        </a>
        @endif

        @if($editMode)
            <button wire:click="cancelEdit"
                    class="flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
                Annuler
            </button>
            <button wire:click="updateAgent"
                    wire:loading.attr="disabled" wire:target="updateAgent"
                    class="flex items-center gap-2 px-5 py-2.5 bg-green text-white text-sm font-semibold
                           rounded-xl hover:bg-green/90 transition-colors shadow-sm disabled:opacity-60">
                <span wire:loading.remove wire:target="updateAgent" class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg>
                    Enregistrer
                </span>
                <span wire:loading wire:target="updateAgent" class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Enregistrement…
                </span>
            </button>
        @else
            @if($this->canManagePersonnel)
            <button wire:click="enableEditMode"
                    class="flex items-center gap-2 px-5 py-2.5 bg-navy text-white text-sm font-semibold
                           rounded-xl hover:bg-[#0f2d56] transition-colors shadow-sm shadow-navy/20">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                </svg>
                Modifier
            </button>
            @endif
        @endif
    </div>

</div>

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
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
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
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                                </svg>
                                            @break
                                            @case(2)
                                                <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 10.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/>
                                                </svg>
                                            @break
                                            @case(3)
                                                <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"/>
                                                </svg>
                                            @break
                                        @endswitch
                                    </div>
                                    <div>
                                        <h2 class="font-semibold text-navy text-sm">{{ $this->stepLabel($step) }}</h2>
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            @switch($step)
                                                @case(1) Nom, date de naissance et contacts @break
                                                @case(2) Diplôme obtenu et spécialité @break
                                                @case(3) Informations du stage et évaluation @break
                                            @endswitch
                                        </p>
                                    </div>
                                </div>

                                {{-- ════════ ÉTAPE 1 — Identité ════════ --}}
                                @if ($step === 1)
                                <div class="p-6 space-y-5">

                                    {{-- Nom & Prénom --}}
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Nom & Prénom <span class="text-red-400">*</span>
                                        </label>
                                        <input type="text" wire:model="nom_prenom_stagiaire"
                                               placeholder="ex : KOUAMÉ Adjoua Marie"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                      text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                      transition-all @error('nom_prenom_stagiaire') border-red-300 bg-red-50/30 @enderror">
                                        @error('nom_prenom_stagiaire')
                                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Date naissance + Lieu naissance --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Date de naissance
                                            </label>
                                            <input type="date" wire:model="date_naissance_stagiaire"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all
                                                          @error('date_naissance_stagiaire') border-red-300 bg-red-50/30 @enderror">
                                            @error('date_naissance_stagiaire')
                                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Lieu de naissance
                                            </label>
                                            <input type="text" wire:model="lieu_naissance_stagiaire"
                                                   placeholder="ex : Abidjan"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                    </div>

                                    {{-- Contacts --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @foreach([
                                            'contact_stagiaire'         => 'Téléphone du stagiaire',
                                            'contact_urgence_stagiaire' => "Contact d'urgence",
                                        ] as $field => $label)
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                {{ $label }}
                                            </label>
                                            <div class="relative">
                                                <span class="absolute inset-y-0 left-4 flex items-center text-gray-400 text-sm font-medium select-none">+225</span>
                                                <input type="tel" wire:model="{{ $field }}"
                                                       placeholder="07 00 00 00 00"
                                                       class="w-full pl-16 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                              text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                </div>
                                @endif

                                {{-- ════════ ÉTAPE 2 — Diplôme ════════ --}}
                                @if ($step === 2)
                                <div class="p-6 space-y-5">

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Nature du diplôme
                                            </label>
                                            <input type="text" wire:model="nature_diplome"
                                                   placeholder="ex : BTS, Licence, Master…"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Numéro du diplôme
                                            </label>
                                            <input type="text" wire:model="numero_diplome"
                                                   placeholder="ex : DIP-2024-001"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Session
                                            </label>
                                            <input type="text" wire:model="session"
                                                   placeholder="ex : Juin 2024"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Option / Spécialité
                                            </label>
                                            <input type="text" wire:model="option"
                                                   placeholder="ex : Comptabilité, Informatique…"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                    </div>

                                </div>
                                @endif

                                {{-- ════════ ÉTAPE 3 — Stage ════════ --}}
                                @if ($step === 3)
                                <div class="p-6 space-y-5">

                                    {{-- Année + Service + Maître --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Année d'exercice
                                            </label>
                                            <input type="text" wire:model="annee_exercice" placeholder="ex : 2025"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Service d'accueil
                                            </label>
                                            <input type="text" wire:model="service_accueil" placeholder="ex : Direction Financière"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Maître de stage
                                            </label>
                                            <input type="text" wire:model="maitre_stage" placeholder="ex : M. KOUASSI"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                    </div>

                                    {{-- Dates --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Date de démarrage
                                            </label>
                                            <input type="date" wire:model="date_demarrage"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Date de fin
                                            </label>
                                            <input type="date" wire:model="date_fin"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all
                                                          @error('date_fin') border-red-300 bg-red-50/30 @enderror">
                                            @error('date_fin')
                                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Thème --}}
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Thème du stage
                                        </label>
                                        <input type="text" wire:model="theme_stage"
                                               placeholder="ex : Gestion budgétaire des collectivités locales"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                      text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                    </div>

                                    {{-- Note + Appréciation + Emploi jeune --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Note /20
                                            </label>
                                            <input type="number" wire:model="note" min="0" max="20" step="0.5" placeholder="ex : 15"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all
                                                          @error('note') border-red-300 bg-red-50/30 @enderror">
                                            @error('note')
                                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Appréciation
                                            </label>
                                            <select wire:model="appreciation"
                                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                           text-sm text-navy appearance-none
                                                           focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                                <option value="">— Sélectionner —</option>
                                                <option value="Très bien">Très bien</option>
                                                <option value="Bien">Bien</option>
                                                <option value="Assez bien">Assez bien</option>
                                                <option value="Passable">Passable</option>
                                                <option value="Insuffisant">Insuffisant</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Emploi jeune
                                            </label>
                                            <label class="flex items-center gap-3 mt-2.5 cursor-pointer">
                                                <div class="relative">
                                                    <input type="checkbox" wire:model.live="inscri_emploi_jeune" class="sr-only peer">
                                                    <div class="w-10 h-5 bg-gray-200 rounded-full peer peer-checked:bg-navy transition-colors duration-200"></div>
                                                    <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow peer-checked:translate-x-5 transition-transform duration-200"></div>
                                                </div>
                                                <span class="text-sm text-gray-600 font-medium">
                                                    {{ $inscri_emploi_jeune ? 'Inscrit' : 'Non inscrit' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    {{-- Récapitulatif --}}
                                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl">
                                        <p class="text-xs font-semibold text-navy/70 uppercase tracking-wide mb-3">Récapitulatif</p>
                                        <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-xs">
                                            @foreach([
                                                'Nom & Prénom'  => $nom_prenom_stagiaire,
                                                'Diplôme'       => $nature_diplome,
                                                'Option'        => $option,
                                                'Service'       => $service_accueil,
                                                'Maître stage'  => $maitre_stage,
                                                'Emploi jeune'  => $inscri_emploi_jeune ? 'Oui' : 'Non',
                                            ] as $label => $value)
                                            <div class="flex justify-between gap-2 py-1 border-b border-gray-100 last:border-0">
                                                <span class="text-gray-400 shrink-0">{{ $label }}</span>
                                                <span class="font-medium text-navy truncate text-right">{{ $value ?: '—' }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

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
                                                Enregistrer le stagiaire
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
