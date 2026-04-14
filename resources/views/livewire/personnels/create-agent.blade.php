<div>

    {{-- ═══════════════════════════════════════════════════════
         ZONE PRINCIPALE (bannière + messages + table)
    ═══════════════════════════════════════════════════════ --}}
    <div class="p-4 sm:p-6 lg:p-8 max-w-6xl mx-auto space-y-6">

        {{-- ── Bannière en-tête page ── --}}
        <div class="animate-fadeInUp relative overflow-hidden
                    bg-gradient-to-r from-navy via-[#0f2d56] to-[#1a3a6b]
                    rounded-2xl px-6 py-7 text-white shadow-lg">
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-xs font-medium text-white/50 uppercase tracking-widest mb-1">
                        Personnel
                    </p>
                    <h1 class="font-serif text-2xl font-bold leading-tight">
                        Liste des agents permanents
                    </h1>
                    <p class="text-white/60 text-sm mt-1">
                        Retrouvez ici tous les agents permanents de la mairie.
                    </p>
                </div>

                {{-- Bouton Ajouter — utilise wire:click pour éviter de perdre l'état Alpine --}}
                <div class="shrink-0">
                    <button wire:click="openModal" class="inline-flex items-center gap-2 px-5 py-2.5
                                   bg-gold text-navy text-sm font-semibold rounded-xl
                                   hover:bg-yellow-400 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Ajouter un agent
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

        {{-- ── Message de succès ── --}}
        @if (session()->has('success'))
        <div
            class="p-4 rounded-xl bg-green/10 border border-green/20 text-green font-medium text-sm flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- ── Table des agents ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fadeInUp">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                Agent</th>
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">
                                Matricule</th>
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">
                                Contact</th>
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">
                                Fonction</th>
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">
                                Service</th>
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                Statut</th>
                            <th class="px-5 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($agents as $agent)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    @if($agent->photo_agent)
                                    <img src="{{ Storage::url($agent->photo_agent) }}" alt="Photo"
                                        class="w-8 h-8 rounded-full object-cover shadow-sm shrink-0">
                                    @else
                                    <div
                                        class="w-8 h-8 rounded-full bg-navy/10 flex items-center justify-center text-navy font-bold text-xs shrink-0">
                                        {{ Str::upper(substr($agent->nom_prenom_agent, 0, 1)) }}
                                    </div>
                                    @endif
                                    <div>
                                        <span
                                            class="block font-semibold text-navy text-xs">{{ $agent->nom_prenom_agent }}</span>

                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <span class="block text-xs text-navy font-medium">{{ $agent->matricule }}</span>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <span
                                    class="block text-xs text-navy font-medium">{{ $agent->contact_agent ?? '—' }}</span>
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                <span class="block text-xs text-navy font-medium">{{ $agent->fonction ?? '—' }}</span>
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                <span
                                    class="block text-xs text-navy font-medium">{{ $agent->service ?? 'Aucun service' }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                @if($agent->statut === 'Actif')
                                <span
                                    class="bg-green/10 text-green text-[10px] font-bold px-2.5 py-1 rounded-lg">{{ $agent->statut }}</span>
                                @elseif($agent->statut === 'Suspendu')
                                <span
                                    class="bg-red-50 text-red-500 text-[10px] font-bold px-2.5 py-1 rounded-lg">{{ $agent->statut }}</span>
                                @else
                                <span
                                    class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded-lg">{{ $agent->statut ?? '—' }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <button wire:click="viewAgent({{ $agent->id }})" class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center
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
                            <td colspan="5" class="px-5 py-8 text-center text-gray-400 text-sm">
                                Aucun agent permanent enregistré dans la base.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                {{ $agents->links() }}
            </div>
        </div>

        {{-- ── Footer ── --}}
        <p class="text-center text-xs text-gray-400 pb-4">
            &copy; {{ date('Y') }} Mairie de Cocody — Système de Gestion Municipale
        </p>

    </div>
    {{-- ═══════════════════════════════════════════════════════
     MODAL FICHE AGENT (consultation + modification)
═══════════════════════════════════════════════════════ --}}
@if($showAgentModal && $this->selectedAgent)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">

    {{-- Overlay --}}
    <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm"
         wire:click="closeAgentModal"></div>

    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative z-10 w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden">

            {{-- ── En-tête coloré ── --}}
            <div class="bg-gradient-to-r from-navy via-[#0f2d56] to-[#1a3a6b] px-8 py-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-5">
                        {{-- Avatar --}}
                        <div class="shrink-0">
                            @if($this->selectedAgent->photo_agent)
                                <img src="{{ Storage::url($this->selectedAgent->photo_agent) }}"
                                     class="w-16 h-16 rounded-2xl object-cover ring-2 ring-white/20">
                            @else
                                <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center text-2xl font-bold text-gold">
                                    {{ Str::upper(substr($this->selectedAgent->nom_prenom_agent, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            @if($editMode)
                                <input type="text" wire:model="edit_nom_prenom_agent"
                                       class="bg-white/10 border border-white/20 rounded-xl px-3 py-1.5
                                              text-white font-serif text-xl font-bold w-72
                                              focus:outline-none focus:ring-2 focus:ring-gold/50 placeholder-white/50">
                                @error('edit_nom_prenom_agent')
                                    <p class="text-xs text-red-300 mt-1">{{ $message }}</p>
                                @enderror
                            @else
                                <h2 class="font-serif text-xl font-bold">{{ $this->selectedAgent->nom_prenom_agent }}</h2>
                            @endif
                            <div class="flex items-center gap-3 mt-1.5">
                                <span class="text-white/60 text-sm font-mono">{{ $this->selectedAgent->matricule }}</span>
                                @if($this->selectedAgent->statut === 'Actif')
                                    <span class="bg-green/20 text-green-300 text-[10px] font-bold px-2.5 py-0.5 rounded-full">{{ $this->selectedAgent->statut }}</span>
                                @elseif($this->selectedAgent->statut === 'Suspendu')
                                    <span class="bg-red-500/20 text-red-300 text-[10px] font-bold px-2.5 py-0.5 rounded-full">{{ $this->selectedAgent->statut }}</span>
                                @else
                                    <span class="bg-white/10 text-white/60 text-[10px] font-bold px-2.5 py-0.5 rounded-full">{{ $this->selectedAgent->statut ?? '—' }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- Bouton fermer --}}
                    <button wire:click="closeAgentModal"
                            class="w-8 h-8 flex items-center justify-center rounded-xl
                                   bg-white/10 text-white/60 hover:bg-red-500 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- ── Erreurs globales (mode édition) ── --}}
            @if($editMode && $errors->any())
                <div class="mx-6 mt-4 p-3 bg-red-50 border border-red-200 rounded-xl">
                    <ul class="text-xs text-red-600 space-y-0.5 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ── Corps scrollable ── --}}
            <div class="max-h-[65vh] overflow-y-auto">
                <div class="p-6 space-y-5">

                    {{-- ┌─────────────────────────────────────────┐
                         │  SECTION 1 — Identité                   │
                         └─────────────────────────────────────────┘ --}}
                    <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                        <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                            </svg>
                            Identité
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">

                            {{-- Date de naissance --}}
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date de naissance</p>
                                @if($editMode)
                                    <input type="date" wire:model="edit_date_naissance_agent"
                                           class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @error('edit_date_naissance_agent') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                @else
                                    <p class="text-sm font-medium text-navy">
                                        {{ $this->selectedAgent->date_naissance_agent ? \Carbon\Carbon::parse($this->selectedAgent->date_naissance_agent)->locale('fr')->isoFormat('DD MMM YYYY') : '—' }}
                                    </p>
                                @endif
                            </div>

                            {{-- Sexe --}}
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Sexe</p>
                                @if($editMode)
                                    <div class="flex gap-2">
                                        <label class="flex-1 flex items-center justify-center py-2 border rounded-xl cursor-pointer text-xs font-medium transition-all
                                                     {{ $edit_sexe_agent === 'M' ? 'bg-navy text-white border-navy' : 'bg-white text-gray-600 border-gray-200' }}">
                                            <input type="radio" wire:model.live="edit_sexe_agent" value="M" class="sr-only"> Masculin
                                        </label>
                                        <label class="flex-1 flex items-center justify-center py-2 border rounded-xl cursor-pointer text-xs font-medium transition-all
                                                     {{ $edit_sexe_agent === 'F' ? 'bg-navy text-white border-navy' : 'bg-white text-gray-600 border-gray-200' }}">
                                            <input type="radio" wire:model.live="edit_sexe_agent" value="F" class="sr-only"> Féminin
                                        </label>
                                    </div>
                                    @error('edit_sexe_agent') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                @else
                                    <p class="text-sm font-medium text-navy">
                                        {{ $this->selectedAgent->sexe_agent === 'M' ? 'Masculin' : ($this->selectedAgent->sexe_agent === 'F' ? 'Féminin' : '—') }}
                                    </p>
                                @endif
                            </div>

                            {{-- Qualification --}}
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Qualification</p>
                                @if($editMode)
                                    <input type="text" wire:model="edit_qualification"
                                           placeholder="ex : Ingénieur"
                                           class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                @else
                                    <p class="text-sm font-medium text-navy">{{ $this->selectedAgent->qualification ?? '—' }}</p>
                                @endif
                            </div>

                        </div>
                    </div>

                    {{-- ┌─────────────────────────────────────────┐
                         │  SECTION 2 — Contacts                   │
                         └─────────────────────────────────────────┘ --}}
                    <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                        <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                            </svg>
                            Contacts
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                            @foreach([
                                'edit_contact_agent'     => ['label' => "Téléphone agent",    'field' => 'contact_agent'],
                                'edit_contact_urgence_1' => ['label' => 'Contact urgence 1',  'field' => 'contact_urgence_1'],
                                'edit_contact_urgence_2' => ['label' => 'Contact urgence 2',  'field' => 'contact_urgence_2'],
                            ] as $editField => $meta)
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ $meta['label'] }}</p>
                                @if($editMode)
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-xs font-medium select-none">+225</span>
                                        <input type="tel" wire:model="{{ $editField }}"
                                               placeholder="07 00 00 00 00"
                                               class="w-full pl-12 pr-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    </div>
                                @else
                                    <p class="text-sm font-medium text-navy">{{ $this->selectedAgent->{$meta['field']} ?? '—' }}</p>
                                @endif
                            </div>
                            @endforeach

                        </div>
                    </div>

                    {{-- ┌─────────────────────────────────────────┐
                         │  SECTION 3 — Embauche                   │
                         └─────────────────────────────────────────┘ --}}
                    <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                        <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"/>
                            </svg>
                            Embauche
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">

                            {{-- Commune --}}
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Commune</p>
                                @if($editMode)
                                    <select wire:model="edit_commune_id"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                   focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                        <option value="">— Sélectionner —</option>
                                        @foreach($communes as $commune)
                                            <option value="{{ $commune->id }}">{{ $commune->nom_commune }}</option>
                                        @endforeach
                                    </select>
                                    @error('edit_commune_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                @else
                                    <p class="text-sm font-medium text-navy">{{ $this->selectedAgent->commune?->nom_commune ?? '—' }}</p>
                                @endif
                            </div>

                            {{-- Nature embauche --}}
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Nature</p>
                                @if($editMode)
                                    <select wire:model="edit_nature_embauche"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                   focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                        <option value="">— Sélectionner —</option>
                                        <option value="Recrutement direct">Recrutement direct</option>
                                        <option value="Concours">Concours</option>
                                        <option value="Mutation">Mutation</option>
                                        <option value="Détachement">Détachement</option>
                                        <option value="Intégration">Intégration</option>
                                    </select>
                                @else
                                    <p class="text-sm font-medium text-navy">{{ $this->selectedAgent->nature_embauche ?? '—' }}</p>
                                @endif
                            </div>

                            {{-- N° acte --}}
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">N° acte</p>
                                @if($editMode)
                                    <input type="text" wire:model="edit_numero_embauche" placeholder="ACT-2025-001"
                                           class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                @else
                                    <p class="text-sm font-medium text-navy">{{ $this->selectedAgent->numero_embauche ?? '—' }}</p>
                                @endif
                            </div>

                            @foreach([
                                'edit_date_embauche'          => ['label' => "Date d'embauche",  'field' => 'date_embauche'],
                                'edit_date_fonction_embauche' => ['label' => 'Date fonction',     'field' => 'date_fonction_embauche'],
                                'edit_date_prise_service'     => ['label' => 'Prise de service',  'field' => 'date_prise_service'],
                            ] as $editField => $meta)
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ $meta['label'] }}</p>
                                @if($editMode)
                                    <input type="date" wire:model="{{ $editField }}"
                                           class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                @else
                                    <p class="text-sm font-medium text-navy">
                                        {{ $this->selectedAgent->{$meta['field']} ? \Carbon\Carbon::parse($this->selectedAgent->{$meta['field']})->locale('fr')->isoFormat('DD MMM YYYY') : '—' }}
                                    </p>
                                @endif
                            </div>
                            @endforeach

                        </div>
                    </div>

                    {{-- ┌─────────────────────────────────────────┐
                         │  SECTION 4 — Poste & Salaire            │
                         └─────────────────────────────────────────┘ --}}
                    <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                        <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            Poste & Salaire
                        </h3>

                        {{-- Barème (toujours lecture seule) --}}
                        <div class="mb-4 p-3 bg-navy/5 border border-navy/10 rounded-xl">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-[10px] font-bold text-navy/50 uppercase tracking-wide">Barème salarial</span>
                                <span class="text-[10px] bg-gray-200 text-gray-500 px-2 py-0.5 rounded-full">Lecture seule</span>
                            </div>
                            <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                                @foreach([
                                    'Catégorie'        => $this->selectedAgent->baremeSalarial?->categorie,
                                    'Échelon'          => $this->selectedAgent->baremeSalarial?->echelon,
                                    'Indice'           => $this->selectedAgent->baremeSalarial?->indice,
                                    'Salaire base'     => $this->selectedAgent->baremeSalarial ? number_format($this->selectedAgent->baremeSalarial->salaire_base, 0, ',', ' ').' FCFA' : null,
                                    'Salaire brut'     => $this->selectedAgent->baremeSalarial ? number_format($this->selectedAgent->baremeSalarial->salaire_brut, 0, ',', ' ').' FCFA' : null,
                                    'Indem. résidence' => $this->selectedAgent->baremeSalarial ? number_format($this->selectedAgent->baremeSalarial->indem_residence, 0, ',', ' ').' FCFA' : null,
                                ] as $label => $value)
                                <div>
                                    <p class="text-[10px] text-gray-400 mb-1">{{ $label }}</p>
                                    <div class="px-2.5 py-2 bg-gray-100 rounded-lg text-xs text-gray-600 font-medium">{{ $value ?? '—' }}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Champs éditables --}}
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            @foreach([
                                'edit_fonction'    => ['label' => 'Fonction',         'field' => 'fonction',    'placeholder' => 'Chef de service'],
                                'edit_service'     => ['label' => 'Service',           'field' => 'service',     'placeholder' => 'Direction Financière'],
                                'edit_post_travail'=> ['label' => 'Poste de travail',  'field' => 'post_travail','placeholder' => 'Bureau 201'],
                                'edit_groupe'      => ['label' => 'Groupe',            'field' => 'groupe',      'placeholder' => 'A1, B2…'],
                            ] as $editField => $meta)
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ $meta['label'] }}</p>
                                @if($editMode)
                                    <input type="text" wire:model="{{ $editField }}" placeholder="{{ $meta['placeholder'] }}"
                                           class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                @else
                                    <p class="text-sm font-medium text-navy">{{ $this->selectedAgent->{$meta['field']} ?? '—' }}</p>
                                @endif
                            </div>
                            @endforeach

                            {{-- Statut --}}
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Statut</p>
                                @if($editMode)
                                    <select wire:model="edit_statut"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                   focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                        <option value="">— Sélectionner —</option>
                                        <option value="Actif">Actif</option>
                                        <option value="Suspendu">Suspendu</option>
                                        <option value="En congé">En congé</option>
                                        <option value="En détachement">En détachement</option>
                                        <option value="Retraité">Retraité</option>
                                    </select>
                                @else
                                    <p class="text-sm font-medium text-navy">{{ $this->selectedAgent->statut ?? '—' }}</p>
                                @endif
                            </div>

                            {{-- Indemnités --}}
                            @foreach([
                                'edit_indem_transp'   => ['label' => 'Indem. transport', 'field' => 'indem_transp'],
                                'edit_indem_fonction' => ['label' => 'Indem. fonction',  'field' => 'indem_fonction'],
                                'edit_indem_techn'    => ['label' => 'Indem. technique', 'field' => 'indem_techn'],
                            ] as $editField => $meta)
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ $meta['label'] }}</p>
                                @if($editMode)
                                    <input type="number" wire:model="{{ $editField }}" min="0" step="500"
                                           class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                @else
                                    <p class="text-sm font-medium text-navy">
                                        {{ $this->selectedAgent->{$meta['field']} ? number_format($this->selectedAgent->{$meta['field']}, 0, ',', ' ').' FCFA' : '—' }}
                                    </p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ┌─────────────────────────────────────────┐
                         │  SECTION 5 — Budgétaire                 │
                         └─────────────────────────────────────────┘ --}}
                    <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                        <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V8.25z"/>
                            </svg>
                            Budgétaire
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @foreach([
                                'edit_imputa_budgetaire' => ['label' => 'Imputation budgétaire', 'field' => 'imputa_budgetaire', 'placeholder' => '2025-PERS-001'],
                                'edit_chapitre_paie'     => ['label' => 'Chapitre de paie',       'field' => 'chapitre_paie',     'placeholder' => 'CHAP-60'],
                                'edit_article_paie'      => ['label' => 'Article de paie',         'field' => 'article_paie',      'placeholder' => 'ART-6010'],
                            ] as $editField => $meta)
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ $meta['label'] }}</p>
                                @if($editMode)
                                    <input type="text" wire:model="{{ $editField }}" placeholder="{{ $meta['placeholder'] }}"
                                           class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                @else
                                    <p class="text-sm font-medium text-navy">{{ $this->selectedAgent->{$meta['field']} ?? '—' }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── Footer avec actions ── --}}
            <div class="px-6 py-4 border-t border-gray-100 bg-white flex items-center justify-between gap-3">

                {{-- Bouton Supprimer (toujours visible) --}}
                <button wire:click="confirmDelete"
                        wire:confirm="Êtes-vous sûr de vouloir supprimer cet agent ? Cette action est irréversible."
                        class="flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 text-sm font-semibold
                               rounded-xl hover:bg-red-100 transition-colors border border-red-100">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                    </svg>
                    Supprimer
                </button>

                <div class="flex items-center gap-2">
                    @if($editMode)
                        {{-- Mode édition : Annuler + Enregistrer --}}
                        <button wire:click="cancelEdit"
                                class="flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                            </svg>
                            Annuler
                        </button>
                        <button wire:click="updateAgent"
                                wire:loading.attr="disabled"
                                wire:target="updateAgent"
                                class="flex items-center gap-2 px-5 py-2.5 bg-green text-white text-sm font-semibold
                                       rounded-xl hover:bg-green/90 transition-colors shadow-sm disabled:opacity-60">
                            <span wire:loading.remove wire:target="updateAgent" class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                                Enregistrer les modifications
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
                        {{-- Mode consultation : Modifier --}}
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

        </div>
    </div>
</div>
@endif

    {{-- ═══════════════════════════════════════════════════════
         MODAL — géré entièrement par Livewire ($showModal)
    ═══════════════════════════════════════════════════════ --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">

        {{-- Overlay --}}
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>

        {{-- Conteneur centré --}}
        <div class="flex min-h-full items-end justify-center p-4 sm:items-center sm:p-0">
            <div class="relative z-10 transform overflow-hidden rounded-2xl bg-gray-50 text-left
                        shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-white/20">

                {{-- Bouton fermer --}}
                <button wire:click="closeModal" class="absolute top-4 right-4 z-[60] w-8 h-8 flex items-center justify-center
                               rounded-xl bg-gray-200 text-gray-600
                               hover:bg-red-500 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>

                {{-- Contenu du formulaire multi-étapes --}}
                <div class="max-h-[85vh] overflow-y-auto scrollbar-thin">
                    <div class="bg-gray-50 p-4 sm:p-6 lg:p-8">
                        <div class="max-w-3xl mx-auto">

                            {{-- ── Stepper visuel ── --}}
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= $maxSteps; $i++) <div class="flex flex-col items-center flex-1">
                                        <div @class([ 'w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300'
                                            , 'bg-navy text-white shadow-md shadow-navy/25'=> $i === $step,
                                            'bg-green/90 text-white' => $i < $step, 'bg-gray-100 text-gray-400'=> $i >
                                                $step,
                                                ])>
                                                @if ($i < $step) <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4.5 12.75l6 6 9-13.5" />
                                                    </svg>
                                                    @else
                                                    {{ $i }}
                                                    @endif
                                        </div>
                                        <span
                                            @class([ 'text-[10px] mt-1.5 font-medium text-center leading-tight hidden sm:block'
                                            , 'text-navy'=> $i === $step,
                                            'text-green' => $i < $step, 'text-gray-400'=> $i > $step,
                                                ])>
                                                {{ $this->stepLabel($i) }}
                                        </span>
                                </div>
                                @if ($i < $maxSteps) <div @class([ 'h-0.5 flex-1 mx-1 transition-all duration-500'
                                    , 'bg-green/80'=> $i < $step, 'bg-gray-200'=> $i >= $step,
                                        ])>
                            </div>
                            @endif
                            @endfor
                        </div>
                    </div>

                    {{-- ── Messages d'erreurs de validation ── --}}
                    @if ($errors->any())
                    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <div class="flex items-start gap-2 text-red-700 font-medium text-sm mb-2">
                            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                            Veuillez corriger les erreurs suivantes :
                        </div>
                        <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if (session()->has('error'))
                    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                        {{ session('error') }}
                    </div>
                    @endif

                    {{-- ── Card formulaire ── --}}
                    {{--
                                IMPORTANT : on n'utilise plus wire:submit sur le <form>
                                Les boutons utilisent wire:click directement → pas de rechargement,
                                pas de perte du modal.
                            --}}
                    <div>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                            {{-- Bandeau titre étape --}}
                            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-navy/8 flex items-center justify-center shrink-0">
                                    @switch($step)
                                    @case(1)
                                    <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    @break
                                    @case(2)
                                    <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                    </svg>
                                    @break
                                    @case(3)
                                    <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                    </svg>
                                    @break
                                    @case(4)
                                    <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    @break
                                    @case(5)
                                    <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V8.25z" />
                                    </svg>
                                    @break
                                    @endswitch
                                </div>
                                <div>
                                    <h2 class="font-semibold text-navy text-sm">{{ $this->stepLabel($step) }}</h2>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        @switch($step)
                                        @case(1) Informations personnelles de base @break
                                        @case(2) Numéros de téléphone et contacts d'urgence @break
                                        @case(3) Commune de rattachement et informations d'embauche @break
                                        @case(4) Catégorie salariale, poste occupé et indemnités @break
                                        @case(5) Imputation budgétaire et comptable @break
                                        @endswitch
                                    </p>
                                </div>
                            </div>

                            {{-- ════════════ ÉTAPE 1 — Identité ════════════ --}}
                            @if ($step === 1)
                            <div class="p-6 space-y-5">

                                {{-- Photo --}}
                                <div class="flex flex-col sm:flex-row items-start gap-5 pb-5 border-b border-gray-100">
                                    <div class="shrink-0">
                                        <div
                                            class="w-20 h-20 rounded-2xl border-2 border-dashed border-gray-200
                                                            bg-gray-50 flex items-center justify-center overflow-hidden">
                                            @if ($photo_agent)
                                            <img src="{{ $photo_agent->temporaryUrl() }}"
                                                class="w-full h-full object-cover">
                                            @else
                                            <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Photo de l'agent</p>
                                        <label class="inline-flex items-center gap-2 px-4 py-2
                                                              bg-gray-50 border border-gray-200 rounded-xl
                                                              text-xs font-medium text-gray-600 cursor-pointer
                                                              hover:bg-gray-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                            </svg>
                                            Choisir une photo
                                            <input type="file" wire:model="photo_agent" accept="image/*" class="hidden">
                                        </label>
                                        <p class="text-[11px] text-gray-400 mt-1.5">JPG, PNG — Max 2 Mo</p>
                                        @error('photo_agent')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                        <div wire:loading wire:target="photo_agent"
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
                                </div>

                                {{-- Nom & Prénom --}}
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                        Nom & Prénom <span class="text-red-400">*</span>
                                    </label>
                                    <input type="text" wire:model="nom_prenom_agent"
                                        placeholder="ex : KONÉ Amadou Ibrahim"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                          transition-all @error('nom_prenom_agent') border-red-300 bg-red-50/30 @enderror">
                                    @error('nom_prenom_agent')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Date naissance + Sexe --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Date de naissance <span class="text-red-400">*</span>
                                        </label>
                                        <input type="date" wire:model="date_naissance_agent"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                              text-sm text-navy
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                              transition-all @error('date_naissance_agent') border-red-300 bg-red-50/30 @enderror">
                                        @error('date_naissance_agent')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Sexe — CORRIGÉ : wire:model.live sur les inputs radio + classes Blade conditionnelles --}}
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Sexe <span class="text-red-400">*</span>
                                        </label>
                                        <div class="flex gap-3">
                                            <label
                                                class="flex-1 flex items-center justify-center gap-2 py-2.5 border rounded-xl cursor-pointer transition-all
                                                                 {{ $sexe_agent === 'M' ? 'bg-navy text-white border-navy' : 'bg-gray-50 text-gray-600 border-gray-200 hover:border-navy/30' }}">
                                                <input type="radio" wire:model.live="sexe_agent" value="M"
                                                    class="sr-only">
                                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="1.5">
                                                    <circle cx="10.5" cy="7.5" r="4.5" stroke="currentColor" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.5 3.5 20 2m0 0v4m0-4h-4M6 14.5A7.5 7.5 0 0 0 13.5 22" />
                                                </svg>
                                                <span class="text-sm font-medium">Masculin</span>
                                            </label>
                                            <label
                                                class="flex-1 flex items-center justify-center gap-2 py-2.5 border rounded-xl cursor-pointer transition-all
                                                                 {{ $sexe_agent === 'F' ? 'bg-navy text-white border-navy' : 'bg-gray-50 text-gray-600 border-gray-200 hover:border-navy/30' }}">
                                                <input type="radio" wire:model.live="sexe_agent" value="F"
                                                    class="sr-only">
                                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="1.5">
                                                    <circle cx="12" cy="8" r="5" stroke="currentColor" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 13v8m-3-3h6" />
                                                </svg>
                                                <span class="text-sm font-medium">Féminin</span>
                                            </label>
                                        </div>
                                        @error('sexe_agent')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Matricule + Qualification --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Matricule <span class="text-red-400">*</span>
                                        </label>
                                        <input type="text" wire:model.blur="matricule" placeholder="ex : MAT-2025-001"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                              text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                              transition-all @error('matricule') border-red-300 bg-red-50/30 @enderror">
                                        @error('matricule')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Qualification
                                        </label>
                                        <input type="text" wire:model="qualification"
                                            placeholder="ex : Ingénieur, Technicien…"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                              text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                    </div>
                                </div>

                            </div>
                            @endif

                            {{-- ════════════ ÉTAPE 2 — Contacts ════════════ --}}
                            @if ($step === 2)
                            <div class="p-6 space-y-5">

                                <div>
                                    <label
                                        class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                        Téléphone de l'agent
                                    </label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-4 flex items-center text-gray-400 text-sm font-medium select-none">+225</span>
                                        <input type="tel" wire:model="contact_agent" placeholder="07 00 00 00 00"
                                            class="w-full pl-16 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                              text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                    </div>
                                    @error('contact_agent') <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="p-4 bg-orange/5 border border-orange/15 rounded-xl">
                                    <p
                                        class="text-xs font-semibold text-orange/80 uppercase tracking-wide mb-4 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                        </svg>
                                        Contacts d'urgence
                                    </p>
                                    <div class="space-y-4">
                                        @foreach (['contact_urgence_1' => 'Contact urgence 1', 'contact_urgence_2' =>
                                        'Contact urgence 2'] as $field => $label)
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">{{ $label }}</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-4 flex items-center text-gray-400 text-sm font-medium select-none">+225</span>
                                                <input type="tel" wire:model="{{ $field }}" placeholder="07 00 00 00 00"
                                                    class="w-full pl-16 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl
                                                                      text-sm text-navy placeholder-gray-400
                                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                            </div>
                                            @error($field) <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                            @endif

                            {{-- ════════════ ÉTAPE 3 — Embauche ════════════ --}}
                            @if ($step === 3)
                            <div class="p-6 space-y-5">

                                <div>
                                    <label
                                        class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                        Commune de rattachement <span class="text-red-400">*</span>
                                    </label>
                                    <div class="relative">
                                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                        <select wire:model="commune_id"
                                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                               text-sm text-navy appearance-none
                                                               focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                               transition-all @error('commune_id') border-red-300 bg-red-50/30 @enderror">
                                            <option value="">— Sélectionner une commune —</option>
                                            @forelse ($communes as $commune)
                                            <option value="{{ $commune->id }}">
                                                {{ $commune->nom_commune }}
                                                @if($commune->code_commune) ({{ $commune->code_commune }}) @endif
                                            </option>
                                            @empty
                                            <option value="" disabled>Aucune commune disponible</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    @error('commune_id')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                    @if($communes->isEmpty())
                                    <p class="text-xs text-orange mt-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                        </svg>
                                        Aucune commune enregistrée. Veuillez d'abord créer des communes.
                                    </p>
                                    @endif
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Nature de l'embauche
                                        </label>
                                        <select wire:model="nature_embauche"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                               text-sm text-navy
                                                               focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                            <option value="">— Sélectionner —</option>
                                            <option value="Recrutement direct">Recrutement direct</option>
                                            <option value="Concours">Concours</option>
                                            <option value="Mutation">Mutation</option>
                                            <option value="Détachement">Détachement</option>
                                            <option value="Intégration">Intégration</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            N° de l'acte d'embauche
                                        </label>
                                        <input type="text" wire:model="numero_embauche" placeholder="ex : ACT-2025-001"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                              text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    @foreach ([
                                    'date_embauche' => "Date d'embauche",
                                    'date_fonction_embauche' => 'Date de fonction',
                                    'date_prise_service' => 'Prise de service',
                                    ] as $field => $label)
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            {{ $label }}
                                        </label>
                                        <input type="date" wire:model="{{ $field }}"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                              text-sm text-navy
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                            @endif

                            {{-- ════════════ ÉTAPE 4 — Poste & Salaire ════════════ --}}
                            @if ($step === 4)
                            <div class="p-6 space-y-5">

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Catégorie salariale <span class="text-red-400">*</span>
                                        </label>
                                        <div class="relative">
                                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <select wire:model.live="bareme_salarial_id"
                                                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                                   text-sm text-navy appearance-none
                                                                   focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                                   transition-all @error('bareme_salarial_id') border-red-300 bg-red-50/30 @enderror">
                                                <option value="">— Sélectionner —</option>
                                                @forelse ($baremes as $bareme)
                                                <option value="{{ $bareme->id }}">
                                                    {{ $bareme->categorie }} — Échelon {{ $bareme->echelon }}
                                                </option>
                                                @empty
                                                <option value="" disabled>Aucun barème disponible</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        @error('bareme_salarial_id')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                        @if($baremes->isEmpty())
                                        <p class="text-xs text-orange mt-1 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                            </svg>
                                            Aucun barème enregistré. Créez d'abord un barème salarial.
                                        </p>
                                        @endif
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Groupe
                                        </label>
                                        <input type="text" wire:model="groupe" placeholder="ex : A1, B2…"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                              text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                    </div>
                                </div>

                                @if ($bareme_salarial_id)
                                <div class="p-4 bg-navy/4 border border-navy/10 rounded-xl">
                                    <div class="flex items-center gap-2 mb-4">
                                        <div
                                            class="w-5 h-5 rounded-full bg-green/15 flex items-center justify-center shrink-0">
                                            <svg class="w-3 h-3 text-green" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                        </div>
                                        <p class="text-xs font-semibold text-navy/70 uppercase tracking-wide">
                                            Informations salariales — remplissage automatique
                                        </p>
                                        <span
                                            class="ml-auto text-[10px] text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">Lecture
                                            seule</span>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                        @foreach ([
                                        'Catégorie' => $readonly_categorie,
                                        'Échelon' => $readonly_echelon,
                                        'Indice' => $readonly_indice,
                                        'Salaire de base' => $readonly_salaire_base,
                                        'Salaire brut' => $readonly_salaire_brut,
                                        'Indem. résidence' => $readonly_indem_residence,
                                        ] as $label => $value)
                                        <div>
                                            <label
                                                class="block text-[10px] font-medium text-gray-400 uppercase tracking-wide mb-1">
                                                {{ $label }}
                                            </label>
                                            <div
                                                class="px-3 py-2.5 bg-gray-100 border border-gray-200 rounded-xl
                                                                text-sm text-gray-600 font-medium cursor-not-allowed select-none">
                                                {{ $value ?: '—' }}
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @else
                                <div class="p-4 bg-gray-50 border border-dashed border-gray-200 rounded-xl text-center">
                                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <p class="text-xs text-gray-400">Sélectionnez une catégorie salariale pour afficher
                                        les détails du barème.</p>
                                </div>
                                @endif

                                <div class="p-4 bg-green/5 border border-green/15 rounded-xl">
                                    <p class="text-xs font-semibold text-green/80 uppercase tracking-wide mb-4">
                                        Indemnités (FCFA)</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        @foreach ([
                                        'indem_transp' => 'Transport',
                                        'indem_fonction' => 'Fonction',
                                        'indem_techn' => 'Technique',
                                        ] as $field => $label)
                                        <div>
                                            <label
                                                class="block text-xs font-medium text-navy/60 mb-1.5">{{ $label }}</label>
                                            <input type="number" wire:model="{{ $field }}" min="0" step="500"
                                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl
                                                                  text-sm text-navy
                                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Fonction</label>
                                        <input type="text" wire:model="fonction" placeholder="ex : Chef de service"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                              text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Service</label>
                                        <input type="text" wire:model="service" placeholder="ex : Direction Financière"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                              text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Poste
                                            de travail</label>
                                        <input type="text" wire:model="post_travail" placeholder="ex : Bureau 201"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                              text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Statut</label>
                                        <select wire:model="statut"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                               text-sm text-navy
                                                               focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                            <option value="">— Sélectionner —</option>
                                            <option value="Actif">Actif</option>
                                            <option value="Suspendu">Suspendu</option>
                                            <option value="En congé">En congé</option>
                                            <option value="En détachement">En détachement</option>
                                            <option value="Retraité">Retraité</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            @endif

                            {{-- ════════════ ÉTAPE 5 — Budgétaire ════════════ --}}
                            @if ($step === 5)
                            <div class="p-6 space-y-5">

                                <div class="p-4 bg-blue-50/50 border border-blue-100 rounded-xl">
                                    <p class="text-xs text-blue-600 flex items-center gap-2">
                                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                        </svg>
                                        Ces informations sont utilisées pour l'imputation comptable des bulletins de
                                        salaire. Elles peuvent être laissées vides et complétées ultérieurement.
                                    </p>
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                        Imputation budgétaire
                                    </label>
                                    <input type="text" wire:model="imputa_budgetaire" placeholder="ex : 2025-PERS-001"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Chapitre de paie
                                        </label>
                                        <input type="text" wire:model="chapitre_paie" placeholder="ex : CHAP-60"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                              text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Article de paie
                                        </label>
                                        <input type="text" wire:model="article_paie" placeholder="ex : ART-6010"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                              text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                    </div>
                                </div>

                                {{-- Récapitulatif final --}}
                                <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl">
                                    <p
                                        class="text-xs font-semibold text-navy/70 uppercase tracking-wide mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V8.25z" />
                                        </svg>
                                        Récapitulatif de l'agent
                                    </p>
                                    <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-xs">
                                        @foreach ([
                                        'Nom & Prénom' => $nom_prenom_agent,
                                        'Matricule' => $matricule,
                                        'Sexe' => $sexe_agent === 'M' ? 'Masculin' : ($sexe_agent === 'F' ? 'Féminin' :
                                        ''),
                                        'Catégorie' => $readonly_categorie,
                                        'Fonction' => $fonction,
                                        'Service' => $service,
                                        'Statut' => $statut,
                                        'Salaire brut' => $readonly_salaire_brut,
                                        ] as $label => $value)
                                        <div
                                            class="flex justify-between gap-2 py-1 border-b border-gray-100 last:border-0">
                                            <span class="text-gray-400 shrink-0">{{ $label }}</span>
                                            <span
                                                class="font-medium text-navy truncate text-right">{{ $value ?: '—' }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                            @endif

                            {{-- ── Footer navigation ── --}}
                            {{--
                                        CORRECTION MAJEURE : wire:click sur les boutons (type="button")
                                        → Livewire intercepte le clic, appelle nextStep()/prevStep()/save()
                                        → Pas de soumission de formulaire → pas de rechargement → modal reste ouvert
                                    --}}
                            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-3">

                                @if ($step > 1)
                                <button type="button" wire:click="prevStep" wire:loading.attr="disabled"
                                    wire:target="prevStep" class="flex items-center gap-2 px-5 py-2.5
                                                           bg-gray-100 text-gray-700 text-sm font-medium rounded-xl
                                                           hover:bg-gray-200 transition-colors disabled:opacity-50">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                    </svg>
                                    Précédent
                                </button>
                                @else
                                <div></div>
                                @endif

                                <span class="text-xs text-gray-400 hidden sm:block">{{ $step }} / {{ $maxSteps }}</span>

                                @if ($step < $maxSteps)
                                    {{-- Bouton "Suivant" — wire:click="nextStep" + type="button" --}} <button
                                    type="button" wire:click="nextStep" wire:loading.attr="disabled"
                                    wire:target="nextStep" class="flex items-center gap-2 px-6 py-2.5
                                                           bg-navy text-white text-sm font-semibold rounded-xl
                                                           hover:bg-[#0f2d56] transition-colors shadow-sm shadow-navy/20
                                                           disabled:opacity-60 disabled:cursor-not-allowed">
                                    <span wire:loading.remove wire:target="nextStep" class="flex items-center gap-2">
                                        Suivant
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                        </svg>
                                    </span>
                                    <span wire:loading wire:target="nextStep" class="flex items-center gap-2">
                                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        Validation…
                                    </span>
                                    </button>
                                    @else
                                    {{-- Bouton "Enregistrer" — wire:click="save" + type="button" --}}
                                    <button type="button" wire:click="save" wire:loading.attr="disabled"
                                        wire:target="save" class="flex items-center gap-2 px-6 py-2.5
                                                           bg-green text-white text-sm font-semibold rounded-xl
                                                           hover:bg-green/90 transition-colors shadow-sm shadow-green/20
                                                           disabled:opacity-60 disabled:cursor-not-allowed">
                                        <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                            Enregistrer l'agent
                                        </span>
                                        <span wire:loading wire:target="save" class="flex items-center gap-2">
                                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                            Enregistrement…
                                        </span>
                                    </button>
                                    @endif

                            </div>
                        </div>
                    </div>
                    {{-- fin card formulaire --}}

                </div>
            </div>
        </div>
        {{-- fin scrollable --}}

    </div>
    {{-- fin conteneur modal --}}
</div>
{{-- fin fixed --}}
</div>
@endif
{{-- fin @if($showModal) --}}

</div>
{{-- fin root Livewire --}}