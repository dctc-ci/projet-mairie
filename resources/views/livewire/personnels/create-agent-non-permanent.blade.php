<div>

    {{-- ═══════════════════════════════════════════════════════
         ZONE PRINCIPALE (bannière + messages + table)
    ═══════════════════════════════════════════════════════ --}}
    <div class="p-4 sm:p-6 lg:p-8 max-w-6xl mx-auto space-y-6">

        {{-- ── Bannière ── --}}
        <div class="animate-fadeInUp relative overflow-hidden
                    bg-gradient-to-r from-navy via-[#0f2d56] to-[#1a3a6b]
                    rounded-2xl px-6 py-7 text-white shadow-lg">
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-xs font-medium text-white/50 uppercase tracking-widest mb-1">Personnel</p>
                    <h1 class="font-serif text-2xl font-bold leading-tight">Liste des agents non permanents</h1>
                    <p class="text-white/60 text-sm mt-1">Retrouvez ici tous les agents non permanents de la mairie.</p>
                </div>
                <div class="shrink-0">
                    <button wire:click="openModal"
                            class="inline-flex items-center gap-2 px-5 py-2.5
                                   bg-gold text-navy text-sm font-semibold rounded-xl
                                   hover:bg-yellow-400 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Ajouter un agent
                    </button>
                </div>
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
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">Sexe</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">Contact</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Fonction</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">Service</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Statut</th>
                            <th class="px-5 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($agents as $agent)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    @if($agent->photo_agent_nopermanent)
                                        <img src="{{ Storage::url($agent->photo_agent_nopermanent) }}" alt="Photo"
                                             class="w-8 h-8 rounded-full object-cover shadow-sm shrink-0">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-orange/10 flex items-center justify-center text-orange font-bold text-xs shrink-0">
                                            {{ Str::upper(substr($agent->nom_prenom_nopermanent, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <span class="block font-semibold text-navy text-xs">{{ $agent->nom_prenom_nopermanent }}</span>
                                        <span class="block text-[10px] text-gray-400 mt-0.5">
                                            
                                            @if($agent->situa_marial_nopermanent)
                                                · {{ $agent->situa_marial_nopermanent }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <span class="text-xs text-gray-600 font-medium">{{ $agent->sexe_nopermanent === 'M' ? 'Masculin' : 'Féminin' }}</span>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <span class="text-xs text-gray-600 font-medium">{{ $agent->contact_agent_nopermanent ?? '—' }}</span>
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                <span class="block text-xs text-navy font-medium">{{ $agent->fonction_nopermanent ?? '—' }}</span>
                               
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <span class="text-xs text-gray-600 font-medium">{{ $agent->service_nopermanent ?? '—' }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                @if($agent->statut_nopermanent === 'Actif')
                                    <span class="bg-green/10 text-green text-[10px] font-bold px-2.5 py-1 rounded-lg">{{ $agent->statut_nopermanent }}</span>
                                @elseif($agent->statut_nopermanent === 'Suspendu')
                                    <span class="bg-red-50 text-red-500 text-[10px] font-bold px-2.5 py-1 rounded-lg">{{ $agent->statut_nopermanent }}</span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded-lg">{{ $agent->statut_nopermanent ?? '—' }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <button wire:click="viewAgent({{ $agent->id }})"
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
                                Aucun agent non permanent enregistré dans la base.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            @if($agents->hasPages())
                <div class="px-5 py-3 border-t border-gray-100">
                    {{ $agents->links() }}
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <p class="text-center text-xs text-gray-400 pb-4">
            &copy; {{ date('Y') }} Mairie de Cocody — Système de Gestion Municipale
        </p>

    </div>


    {{-- ═══════════════════════════════════════════════════════
         MODAL FICHE AGENT (consultation + modification)
    ═══════════════════════════════════════════════════════ --}}
    @if($showAgentModal && $this->selectedAgent)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeAgentModal"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative z-10 w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden">

                {{-- En-tête --}}
                <div class="bg-gradient-to-r from-navy via-[#0f2d56] to-[#1a3a6b] px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-5">
                            <div class="shrink-0">
                                @if($this->selectedAgent->photo_agent_nopermanent)
                                    <img src="{{ Storage::url($this->selectedAgent->photo_agent_nopermanent) }}"
                                         class="w-16 h-16 rounded-2xl object-cover ring-2 ring-white/20">
                                @else
                                    <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center text-2xl font-bold text-gold">
                                        {{ Str::upper(substr($this->selectedAgent->nom_prenom_nopermanent, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                @if($editMode)
                                    <input type="text" wire:model="edit_nom_prenom_nopermanent"
                                           class="bg-white/10 border border-white/20 rounded-xl px-3 py-1.5
                                                  text-white font-serif text-xl font-bold w-72
                                                  focus:outline-none focus:ring-2 focus:ring-gold/50 placeholder-white/50">
                                    @error('edit_nom_prenom_nopermanent')
                                        <p class="text-xs text-red-300 mt-1">{{ $message }}</p>
                                    @enderror
                                @else
                                    <h2 class="font-serif text-xl font-bold">{{ $this->selectedAgent->nom_prenom_nopermanent }}</h2>
                                @endif
                                <div class="flex items-center gap-3 mt-1.5">
                                    <span class="text-white/60 text-sm">Agent non permanent</span>
                                    @if($this->selectedAgent->statut_nopermanent === 'Actif')
                                        <span class="bg-green/20 text-green-300 text-[10px] font-bold px-2.5 py-0.5 rounded-full">{{ $this->selectedAgent->statut_nopermanent }}</span>
                                    @elseif($this->selectedAgent->statut_nopermanent === 'Suspendu')
                                        <span class="bg-red-500/20 text-red-300 text-[10px] font-bold px-2.5 py-0.5 rounded-full">{{ $this->selectedAgent->statut_nopermanent }}</span>
                                    @else
                                        <span class="bg-white/10 text-white/60 text-[10px] font-bold px-2.5 py-0.5 rounded-full">{{ $this->selectedAgent->statut_nopermanent ?? '—' }}</span>
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

                        {{-- Section Identité --}}
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                            <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                </svg>
                                Identité
                            </h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">

                                {{-- Sexe --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Sexe</p>
                                    @if($editMode)
                                        <div class="flex gap-2">
                                            <label class="flex-1 flex items-center justify-center py-2 border rounded-xl cursor-pointer text-xs font-medium transition-all
                                                         {{ $edit_sexe_nopermanent === 'M' ? 'bg-navy text-white border-navy' : 'bg-white text-gray-600 border-gray-200' }}">
                                                <input type="radio" wire:model.live="edit_sexe_nopermanent" value="M" class="sr-only"> Masculin
                                            </label>
                                            <label class="flex-1 flex items-center justify-center py-2 border rounded-xl cursor-pointer text-xs font-medium transition-all
                                                         {{ $edit_sexe_nopermanent === 'F' ? 'bg-navy text-white border-navy' : 'bg-white text-gray-600 border-gray-200' }}">
                                                <input type="radio" wire:model.live="edit_sexe_nopermanent" value="F" class="sr-only"> Féminin
                                            </label>
                                        </div>
                                        @error('edit_sexe_nopermanent') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    @else
                                        <p class="text-sm font-medium text-navy">
                                            {{ $this->selectedAgent->sexe_nopermanent === 'M' ? 'Masculin' : ($this->selectedAgent->sexe_nopermanent === 'F' ? 'Féminin' : '—') }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Situation maritale --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Situation maritale</p>
                                    @if($editMode)
                                        <select wire:model="edit_situa_marial_nopermanent"
                                                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                       focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                            <option value="">— Sélectionner —</option>
                                            <option value="Célibataire">Célibataire</option>
                                            <option value="Marié(e)">Marié(e)</option>
                                            <option value="Divorcé(e)">Divorcé(e)</option>
                                            <option value="Veuf(ve)">Veuf(ve)</option>
                                        </select>
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedAgent->situa_marial_nopermanent ?? '—' }}</p>
                                    @endif
                                </div>

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

                            </div>
                        </div>

                        {{-- Section Contacts --}}
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                            <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                                </svg>
                                Contacts
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                @foreach([
                                    'edit_contact_agent_nopermanent'         => ['label' => 'Téléphone agent',    'field' => 'contact_agent_nopermanent'],
                                    'edit_contact_urgence_1_nopermanent'     => ['label' => 'Contact urgence 1',  'field' => 'contact_urgence_1_nopermanent'],
                                    'edit_contact_urgence_2_nopermanent'     => ['label' => 'Contact urgence 2',  'field' => 'contact_urgence_2_nopermanent'],
                                ] as $editField => $meta)
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ $meta['label'] }}</p>
                                    @if($editMode)
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-xs font-medium select-none">+225</span>
                                            <input type="tel" wire:model="{{ $editField }}" placeholder="07 00 00 00 00"
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

                        {{-- Section Recrutement --}}
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                            <h3 class="text-xs font-bold text-navy/50 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"/>
                                </svg>
                                Recrutement & Poste
                            </h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">

                                {{-- Acte de recrutement --}}
                                <div class="sm:col-span-2">
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Acte de recrutement</p>
                                    @if($editMode)
                                        <input type="text" wire:model="edit_act_recrutement_nopermanent" placeholder="ex : Décision N°…"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedAgent->act_recrutement_nopermanent ?? '—' }}</p>
                                    @endif
                                </div>

                                {{-- N° acte --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">N° acte</p>
                                    @if($editMode)
                                        <input type="text" wire:model="edit_numero_act_recrutement_nopermanent" placeholder="ACT-2025-001"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedAgent->numero_act_recrutement_nopermanent ?? '—' }}</p>
                                    @endif
                                </div>

                                {{-- Date de recrutement --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date de recrutement</p>
                                    @if($editMode)
                                        <input type="date" wire:model="edit_date_recrutement_nopermanent"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">
                                            {{ $this->selectedAgent->date_recrutement_nopermanent ? \Carbon\Carbon::parse($this->selectedAgent->date_recrutement_nopermanent)->locale('fr')->isoFormat('DD MMM YYYY') : '—' }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Fonction --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Fonction</p>
                                    @if($editMode)
                                        <input type="text" wire:model="edit_fonction_nopermanent" placeholder="ex : Agent de sécurité"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedAgent->fonction_nopermanent ?? '—' }}</p>
                                    @endif
                                </div>

                                {{-- Service --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Service</p>
                                    @if($editMode)
                                        <input type="text" wire:model="edit_service_nopermanent" placeholder="ex : Voirie"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedAgent->service_nopermanent ?? '—' }}</p>
                                    @endif
                                </div>

                                {{-- Statut --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Statut</p>
                                    @if($editMode)
                                        <select wire:model="edit_statut_nopermanent"
                                                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                       focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                            <option value="">— Sélectionner —</option>
                                            <option value="Actif">Actif</option>
                                            <option value="Suspendu">Suspendu</option>
                                            <option value="En congé">En congé</option>
                                            <option value="Contrat terminé">Contrat terminé</option>
                                        </select>
                                    @else
                                        <p class="text-sm font-medium text-navy">{{ $this->selectedAgent->statut_nopermanent ?? '—' }}</p>
                                    @endif
                                </div>

                                {{-- Indemnité --}}
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Indemnité (FCFA)</p>
                                    @if($editMode)
                                        <input type="number" wire:model="edit_indemnite" min="0" step="500"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                        @error('edit_indemnite') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    @else
                                        <p class="text-sm font-medium text-navy">
                                            {{ $this->selectedAgent->indemnite ? number_format($this->selectedAgent->indemnite, 0, ',', ' ').' FCFA' : '—' }}
                                        </p>
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                {{-- Footer actions --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-white flex items-center justify-between gap-3">
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
                            <button wire:click="cancelEdit"
                                    class="flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                </svg>
                                Annuler
                            </button>
                            <button wire:click="updateAgent" wire:loading.attr="disabled" wire:target="updateAgent"
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
         MODAL CRÉATION — 3 ÉTAPES
    ═══════════════════════════════════════════════════════ --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeModal"></div>
        <div class="flex min-h-full items-end justify-center p-4 sm:items-center sm:p-0">
            <div class="relative z-10 transform overflow-hidden rounded-2xl bg-gray-50 text-left
                        shadow-2xl sm:my-8 sm:w-full sm:max-w-3xl border border-white/20">

                {{-- Bouton fermer --}}
                <button wire:click="closeModal"
                        class="absolute top-4 right-4 z-[60] w-8 h-8 flex items-center justify-center
                               rounded-xl bg-gray-200 text-gray-600
                               hover:bg-red-500 hover:text-white transition-colors">
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

                            {{-- ── Card formulaire ── --}}
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
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
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
                                                @case(1) Photo, nom complet et informations personnelles @break
                                                @case(2) Numéros de téléphone et contacts d'urgence @break
                                                @case(3) Commune, acte de recrutement et poste occupé @break
                                            @endswitch
                                        </p>
                                    </div>
                                </div>

                                {{-- ════════ ÉTAPE 1 — Identité ════════ --}}
                                @if ($step === 1)
                                <div class="p-6 space-y-5">

                                    {{-- Photo --}}
                                    <div class="flex flex-col sm:flex-row items-start gap-5 pb-5 border-b border-gray-100">
                                        <div class="shrink-0">
                                            <div class="w-20 h-20 rounded-2xl border-2 border-dashed border-gray-200
                                                        bg-gray-50 flex items-center justify-center overflow-hidden">
                                                @if ($photo_agent_nopermanent)
                                                    <img src="{{ $photo_agent_nopermanent->temporaryUrl() }}" class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Photo de l'agent</p>
                                            <label class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-xs font-medium text-gray-600 cursor-pointer hover:bg-gray-100 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                                                </svg>
                                                Choisir une photo
                                                <input type="file" wire:model="photo_agent_nopermanent" accept="image/*" class="hidden">
                                            </label>
                                            <p class="text-[11px] text-gray-400 mt-1.5">JPG, PNG — Max 2 Mo</p>
                                            @error('photo_agent_nopermanent')
                                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                            <div wire:loading wire:target="photo_agent_nopermanent" class="mt-1 text-xs text-navy/60 flex items-center gap-1">
                                                <svg class="animate-spin w-3 h-3" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                </svg>
                                                Chargement…
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Nom & Prénom --}}
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Nom & Prénom <span class="text-red-400">*</span>
                                        </label>
                                        <input type="text" wire:model="nom_prenom_nopermanent"
                                               placeholder="ex : KONÉ Amadou Ibrahim"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                      text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                      transition-all @error('nom_prenom_nopermanent') border-red-300 bg-red-50/30 @enderror">
                                        @error('nom_prenom_nopermanent')
                                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Sexe + Situation maritale --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                        {{-- Sexe --}}
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Sexe <span class="text-red-400">*</span>
                                            </label>
                                            <div class="flex gap-3">
                                                <label class="flex-1 flex items-center justify-center gap-2 py-2.5 border rounded-xl cursor-pointer transition-all
                                                             {{ $sexe_nopermanent === 'M' ? 'bg-navy text-white border-navy' : 'bg-gray-50 text-gray-600 border-gray-200 hover:border-navy/30' }}">
                                                    <input type="radio" wire:model.live="sexe_nopermanent" value="M" class="sr-only">
                                                    <span class="text-sm font-medium">Masculin</span>
                                                </label>
                                                <label class="flex-1 flex items-center justify-center gap-2 py-2.5 border rounded-xl cursor-pointer transition-all
                                                             {{ $sexe_nopermanent === 'F' ? 'bg-navy text-white border-navy' : 'bg-gray-50 text-gray-600 border-gray-200 hover:border-navy/30' }}">
                                                    <input type="radio" wire:model.live="sexe_nopermanent" value="F" class="sr-only">
                                                    <span class="text-sm font-medium">Féminin</span>
                                                </label>
                                            </div>
                                            @error('sexe_nopermanent')
                                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Situation maritale --}}
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Situation maritale
                                            </label>
                                            <select wire:model="situa_marial_nopermanent"
                                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                           text-sm text-navy appearance-none
                                                           focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                                <option value="">— Sélectionner —</option>
                                                <option value="Célibataire">Célibataire</option>
                                                <option value="Marié(e)">Marié(e)</option>
                                                <option value="Divorcé(e)">Divorcé(e)</option>
                                                <option value="Veuf(ve)">Veuf(ve)</option>
                                            </select>
                                        </div>

                                    </div>

                                </div>
                                @endif

                                {{-- ════════ ÉTAPE 2 — Contacts ════════ --}}
                                @if ($step === 2)
                                <div class="p-6 space-y-5">

                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Téléphone de l'agent
                                        </label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-4 flex items-center text-gray-400 text-sm font-medium select-none">+225</span>
                                            <input type="tel" wire:model="contact_agent_nopermanent"
                                                   placeholder="07 00 00 00 00"
                                                   class="w-full pl-16 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                    </div>

                                    <div class="p-4 bg-orange/5 border border-orange/15 rounded-xl">
                                        <p class="text-xs font-semibold text-orange/80 uppercase tracking-wide mb-4 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
                                            </svg>
                                            Contacts d'urgence
                                        </p>
                                        <div class="space-y-4">
                                            @foreach (['contact_urgence_1_nopermanent' => 'Contact urgence 1', 'contact_urgence_2_nopermanent' => 'Contact urgence 2'] as $field => $label)
                                            <div>
                                                <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">{{ $label }}</label>
                                                <div class="relative">
                                                    <span class="absolute inset-y-0 left-4 flex items-center text-gray-400 text-sm font-medium select-none">+225</span>
                                                    <input type="tel" wire:model="{{ $field }}"
                                                           placeholder="07 00 00 00 00"
                                                           class="w-full pl-16 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl
                                                                  text-sm text-navy placeholder-gray-400
                                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                                @endif

                                {{-- ════════ ÉTAPE 3 — Recrutement ════════ --}}
                                @if ($step === 3)
                                <div class="p-6 space-y-5">

                                    {{-- Commune --}}
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Commune de rattachement <span class="text-red-400">*</span>
                                        </label>
                                        <div class="relative">
                                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                                            </svg>
                                            <select wire:model="commune_id"
                                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                           text-sm text-navy appearance-none
                                                           focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                           transition-all @error('commune_id') border-red-300 bg-red-50/30 @enderror">
                                                <option value="">— Sélectionner une commune —</option>
                                                @forelse ($communes as $commune)
                                                    <option value="{{ $commune->id }}">{{ $commune->nom_commune }}</option>
                                                @empty
                                                    <option value="" disabled>Aucune commune disponible</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        @error('commune_id')
                                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Acte + N° acte --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Acte de recrutement
                                            </label>
                                            <input type="text" wire:model="act_recrutement_nopermanent"
                                                   placeholder="ex : Décision N°…"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                N° de l'acte
                                            </label>
                                            <input type="text" wire:model="numero_act_recrutement_nopermanent"
                                                   placeholder="ex : ACT-2025-001"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                    </div>

                                    {{-- Date recrutement --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Date de recrutement
                                            </label>
                                            <input type="date" wire:model="date_recrutement_nopermanent"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Statut
                                            </label>
                                            <select wire:model="statut_nopermanent"
                                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                           text-sm text-navy appearance-none
                                                           focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                                <option value="">— Sélectionner —</option>
                                                <option value="Actif">Actif</option>
                                                <option value="Suspendu">Suspendu</option>
                                                <option value="En congé">En congé</option>
                                                <option value="Contrat terminé">Contrat terminé</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Fonction + Service + Indemnité --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Fonction</label>
                                            <input type="text" wire:model="fonction_nopermanent"
                                                   placeholder="ex : Agent de sécurité"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Service</label>
                                            <input type="text" wire:model="service_nopermanent"
                                                   placeholder="ex : Voirie"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                                Indemnité (FCFA)
                                            </label>
                                            <input type="number" wire:model="indemnite" min="0" step="500"
                                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                          text-sm text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                            @error('indemnite') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    {{-- Récapitulatif --}}
                                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl">
                                        <p class="text-xs font-semibold text-navy/70 uppercase tracking-wide mb-3">Récapitulatif</p>
                                        <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-xs">
                                            @foreach ([
                                                'Nom & Prénom'  => $nom_prenom_nopermanent,
                                                'Sexe'          => $sexe_nopermanent === 'M' ? 'Masculin' : ($sexe_nopermanent === 'F' ? 'Féminin' : ''),
                                                'Sit. maritale' => $situa_marial_nopermanent,
                                                'Fonction'      => $fonction_nopermanent,
                                                'Service'       => $service_nopermanent,
                                                'Statut'        => $statut_nopermanent,
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
                                                       hover:bg-[#0f2d56] transition-colors shadow-sm shadow-navy/20
                                                       disabled:opacity-60 disabled:cursor-not-allowed">
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
                                                       hover:bg-green/90 transition-colors shadow-sm shadow-green/20
                                                       disabled:opacity-60 disabled:cursor-not-allowed">
                                            <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>
                                                Enregistrer l'agent
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
                {{-- fin scrollable --}}

            </div>
        </div>
    </div>
    @endif

</div>
{{-- fin root Livewire --}}
