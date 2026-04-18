<div>

    {{-- ═══════════════════════════════════════════════════════
         ZONE PRINCIPALE
    ═══════════════════════════════════════════════════════ --}}
    <div class="p-4 sm:p-6 lg:p-8 max-w-6xl mx-auto space-y-6">

        {{-- ── Bannière ── --}}
        <div class="animate-fadeInUp relative overflow-hidden
                    bg-gradient-to-r from-[#1A6B3A] via-[#1d7a41] to-[#2d9b5a]
                    rounded-2xl px-6 py-7 text-white shadow-lg">
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-xs font-medium text-white/50 uppercase tracking-widest mb-1">État Civil</p>
                    <h1 class="font-serif text-2xl font-bold leading-tight">Actes de décès</h1>
                    <p class="text-white/60 text-sm mt-1">Enregistrement et consultation des actes de décès.</p>
                </div>
                <div class="shrink-0">
                    <button wire:click="openModal"
                            class="inline-flex items-center gap-2 px-5 py-2.5
                                   bg-white text-[#8a6d00] text-sm font-semibold rounded-xl
                                   hover:bg-yellow-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Nouvel acte
                    </button>
                </div>
            </div>
            <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full border-[28px] border-white/5 pointer-events-none"></div>
            <div class="absolute right-16 -bottom-8 w-28 h-28 rounded-full border-[14px] border-white/5 pointer-events-none"></div>
            <div class="absolute right-6 top-6 w-10 h-10 rounded-full bg-white/10 pointer-events-none"></div>
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
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
                       placeholder="Nom, prénom du défunt ou N° acte…"
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl
                              text-sm text-navy placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-orange/20 focus:border-orange/30 transition-all">
            </div>
        
            <div class="sm:w-32">
                <input type="number" wire:model.live="filtre_annee" placeholder="Année"
                       class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-navy
                              focus:outline-none focus:ring-2 focus:ring-orange/20 focus:border-orange/30 transition-all">
            </div>
        </div>

        {{-- ── Table ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fadeInUp">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Défunt</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">N° Acte</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Date décès</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Commune</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Sexe</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($deces as $d)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-orange/10 flex items-center justify-center text-orange text-xs font-bold shrink-0">
                                        {{ Str::upper(substr($d->nom_defunt ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="block font-semibold text-navy text-xs">
                                            {{ strtoupper($d->nom_defunt ?? '—') }} {{ $d->prenom_defunt }}
                                        </span>
                                        <span class="block text-[10px] text-gray-400 mt-0.5">
                                            {{ $d->lieu_deces ?? '—' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <span class="font-mono text-xs font-medium text-navy">{{ $d->numero_act_deces ?? '—' }}</span>
                                @if($d->annee_registre_deces)
                                    <span class="block text-[10px] text-gray-400">{{ $d->annee_registre_deces }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                @if($d->date_deces)
                                    <span class="text-xs text-navy font-medium">
                                        {{ \Carbon\Carbon::parse($d->date_deces)->locale('fr')->isoFormat('DD MMM YYYY') }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                <span class="text-xs text-gray-600">{{ $d->commune?->nom_commune ?? '—' }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                @if($d->sexe_deces)
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold
                                        {{ $d->sexe_deces === 'M' ? 'bg-blue-50 text-blue-600' : 'bg-pink-50 text-pink-600' }}">
                                        {{ $d->sexe_deces === 'M' ? '♂ M' : '♀ F' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <button wire:click="viewFiche({{ $d->id }})"
                                        class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center
                                               text-gray-400 hover:text-orange hover:bg-orange/10 transition-colors ml-auto">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12 11.204 3.045c.209-.222.499-.345.8-.345s.591.123.8.345L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                                </svg>
                                <p class="text-gray-400 text-sm">Aucun acte de décès enregistré.</p>
                                <button wire:click="openModal"
                                        class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-orange hover:text-orange/80 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                    </svg>
                                    Créer le premier acte
                                </button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($deces->hasPages())
                <div class="px-5 py-3 border-t border-gray-100">{{ $deces->links() }}</div>
            @endif
        </div>

        <p class="text-center text-xs text-gray-400 pb-4">
            &copy; {{ date('Y') }} Mairie de Cocody — Système de Gestion Municipale
        </p>
    </div>


    {{-- ═══════════════════════════════════════════════════════
         MODAL FICHE
    ═══════════════════════════════════════════════════════ --}}
    @if($showFicheModal && $selectedDeces)
    @php
        $d = $selectedDeces;
        $fd = fn($v) => $v ? \Carbon\Carbon::parse($v)->locale('fr')->isoFormat('DD MMMM YYYY') : '—';
        $ic = 'w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs text-navy focus:outline-none focus:ring-2 focus:ring-orange/20';
    @endphp
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeFicheModal"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative z-10 w-full max-w-3xl bg-white rounded-2xl shadow-2xl overflow-hidden">

                {{-- En-tête --}}
                <div class="bg-gradient-to-r from-[#7c3100] via-[#a34200] to-[#E05C1A] px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-white/15 flex items-center justify-center text-2xl font-bold shrink-0">
                                {{ Str::upper(substr($d->nom_defunt ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                @if($editMode)
                                    <div class="flex gap-2">
                                        <input type="text" wire:model="edit_nom_defunt" placeholder="NOM" style="text-transform:uppercase"
                                               class="bg-white/10 border border-white/20 rounded-xl px-3 py-1.5 text-white font-bold text-lg w-40
                                                      focus:outline-none focus:ring-2 focus:ring-white/30">
                                        <input type="text" wire:model="edit_prenom_defunt" placeholder="Prénom"
                                               class="bg-white/10 border border-white/20 rounded-xl px-3 py-1.5 text-white text-sm w-36
                                                      focus:outline-none focus:ring-2 focus:ring-white/30">
                                    </div>
                                @else
                                    <h2 class="font-serif text-xl font-bold">
                                        {{ strtoupper($d->nom_defunt ?? '—') }} {{ $d->prenom_defunt }}
                                    </h2>
                                @endif
                                <div class="flex items-center gap-3 mt-1.5">
                                    <span class="text-white/60 text-xs font-mono">N° {{ $d->numero_act_deces ?? '—' }}</span>
                                    @if($d->date_deces)
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-white/15">
                                            Décédé le {{ \Carbon\Carbon::parse($d->date_deces)->locale('fr')->isoFormat('DD MMM YYYY') }}
                                        </span>
                                    @endif
                                    @if($d->sexe_deces)
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-white/15">
                                            {{ $d->sexe_deces === 'M' ? '♂' : '♀' }}
                                        </span>
                                    @endif
                                </div>
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

                <div class="max-h-[65vh] overflow-y-auto">
                    <div class="p-6 space-y-4">

                        @if(! $editMode)
                        {{-- ── CONSULTATION ── --}}

                        {{-- Registre --}}
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach([
                                'Commune'         => $d->commune?->nom_commune ?? '—',
                                'N° Acte'         => $d->numero_act_deces ?? '—',
                                'Année'           => $d->annee_registre_deces ?? '—',
                                'Nature décl.'    => $d->nature_declarat_deces ?? '—',
                                'Date dressage'   => $fd($d->date_dessage_deces),
                                'Officier'        => $d->officier_etat_civil_deces ?? '—',
                            ] as $label => $val)
                            <div class="bg-gray-50 rounded-xl border border-gray-100 p-3">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">{{ $label }}</p>
                                <p class="text-xs font-semibold text-navy">{{ $val }}</p>
                            </div>
                            @endforeach
                        </div>

                        {{-- Le décès --}}
                        <div class="bg-orange/5 rounded-2xl border border-orange/15 p-4">
                            <p class="text-[10px] font-bold text-orange/80 uppercase tracking-wide mb-3">Le décès</p>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                                <div class="sm:col-span-2"><span class="text-gray-400">Date :</span> <span class="font-bold text-navy">{{ $fd($d->date_deces) }}</span></div>
                                <div><span class="text-gray-400">Heure :</span> <span class="font-medium text-navy">{{ $d->heure_min_deces ?? '—' }}</span></div>
                                <div class="sm:col-span-3"><span class="text-gray-400">Lieu :</span> <span class="font-semibold text-navy">{{ $d->lieu_deces ?? '—' }}</span></div>
                            </div>
                        </div>

                        {{-- Le défunt --}}
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-4">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">Le défunt</p>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-4 gap-y-2 text-xs">
                                <div><span class="text-gray-400">Sexe :</span> <span class="font-medium text-navy">{{ $d->sexe_deces === 'M' ? 'Masculin' : ($d->sexe_deces === 'F' ? 'Féminin' : '—') }}</span></div>
                                <div><span class="text-gray-400">Né(e) le :</span> <span class="font-medium text-navy">{{ $fd($d->date_naissance_defunt) }}</span></div>
                                <div><span class="text-gray-400">Lieu :</span> <span class="font-medium text-navy">{{ $d->lieu_naissance_defunt ?? '—' }}</span></div>
                                <div><span class="text-gray-400">Profession :</span> <span class="font-medium text-navy">{{ $d->profession_defunt ?? '—' }}</span></div>
                                <div><span class="text-gray-400">Situation familiale :</span> <span class="font-medium text-navy">{{ $d->situa_familial_defunt ?? '—' }}</span></div>
                                @if($d->nom_prenom_epoux_defunt)
                                    <div><span class="text-gray-400">Époux(se) :</span> <span class="font-medium text-navy">{{ $d->nom_prenom_epoux_defunt }}</span></div>
                                @endif
                                @if($d->nom_prenom_pere_defunt)
                                    <div class="sm:col-span-2"><span class="text-gray-400">Père :</span> <span class="font-medium text-navy">{{ $d->nom_prenom_pere_defunt }}</span></div>
                                @endif
                                @if($d->nom_prenom_mere_defunt)
                                    <div class="sm:col-span-2"><span class="text-gray-400">Mère :</span> <span class="font-medium text-navy">{{ $d->nom_prenom_mere_defunt }}</span></div>
                                @endif
                            </div>
                        </div>

                        {{-- Déclarant --}}
                        @if($d->info_declarant || $d->langue_declarant || $d->nom_prenom_interprete)
                        <div class="bg-gray-50 rounded-xl border border-gray-100 p-4">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-2">Déclarant & Interprète</p>
                            <div class="space-y-1 text-xs">
                                @if($d->info_declarant)  <div><span class="text-gray-400">Déclarant :</span> <span class="font-medium text-navy">{{ $d->info_declarant }}</span></div> @endif
                                @if($d->langue_declarant) <div><span class="text-gray-400">Langue :</span> <span class="font-medium text-navy">{{ $d->langue_declarant }}</span></div> @endif
                                @if($d->nom_prenom_interprete) <div><span class="text-gray-400">Interprète :</span> <span class="font-medium text-navy">{{ $d->nom_prenom_interprete }}</span></div> @endif
                            </div>
                        </div>
                        @endif

                        @else
                        {{-- ── FORMULAIRE ÉDITION ── --}}
                        <div class="space-y-4">

                            {{-- Registre --}}
                            <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">Registre & Officier</p>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Commune <span class="text-red-400">*</span></label>
                                        <select wire:model="edit_commune_id" class="{{ $ic }} appearance-none @error('edit_commune_id') border-red-300 @enderror">
                                            <option value="">— Sélectionner —</option>
                                            @foreach($communes as $c)
                                                <option value="{{ $c->id }}">{{ $c->nom_commune }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">N° Acte <span class="text-red-400">*</span></label>
                                        <input type="text" wire:model="edit_numero_act_deces" class="{{ $ic }} @error('edit_numero_act_deces') border-red-300 @enderror">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Année</label>
                                        <input type="number" wire:model="edit_annee_registre_deces" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Nature décl.</label>
                                        <input type="text" wire:model="edit_nature_declarat_deces" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date dressage</label>
                                        <input type="date" wire:model="edit_date_dessage_deces" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Officier</label>
                                        <input type="text" wire:model="edit_officier_etat_civil_deces" class="{{ $ic }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Décès --}}
                            <div class="p-4 bg-orange/5 border border-orange/15 rounded-xl">
                                <p class="text-[10px] font-bold text-orange/80 uppercase tracking-wide mb-3">Le décès</p>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date <span class="text-red-400">*</span></label>
                                        <input type="date" wire:model="edit_date_deces" class="{{ $ic }} @error('edit_date_deces') border-red-300 @enderror">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Heure</label>
                                        <input type="text" wire:model="edit_heure_min_deces" placeholder="ex : 14h30" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Lieu <span class="text-red-400">*</span></label>
                                        <input type="text" wire:model="edit_lieu_deces" class="{{ $ic }} @error('edit_lieu_deces') border-red-300 @enderror">
                                    </div>
                                </div>
                            </div>

                            {{-- Défunt --}}
                            <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">Le défunt</p>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Nom <span class="text-red-400">*</span></label>
                                        <input type="text" wire:model="edit_nom_defunt" style="text-transform:uppercase" class="{{ $ic }} @error('edit_nom_defunt') border-red-300 @enderror">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Prénom</label>
                                        <input type="text" wire:model="edit_prenom_defunt" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Sexe <span class="text-red-400">*</span></label>
                                        <div class="flex gap-1.5">
                                            @foreach(['M' => '♂ M', 'F' => '♀ F'] as $val => $label)
                                            <label class="flex-1 flex items-center justify-center py-2 border rounded-xl cursor-pointer text-xs font-medium transition-all
                                                         {{ $edit_sexe_deces === $val
                                                            ? ($val === 'M' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-pink-50 text-pink-600 border-pink-200')
                                                            : 'bg-white text-gray-500 border-gray-200' }}">
                                                <input type="radio" wire:model.live="edit_sexe_deces" value="{{ $val }}" class="sr-only">
                                                {{ $label }}
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date naissance</label>
                                        <input type="date" wire:model="edit_date_naissance_defunt" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Lieu naissance</label>
                                        <input type="text" wire:model="edit_lieu_naissance_defunt" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Profession</label>
                                        <input type="text" wire:model="edit_profession_defunt" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Situation familiale</label>
                                        <select wire:model="edit_situa_familial_defunt" class="{{ $ic }} appearance-none">
                                            <option value="">—</option>
                                            <option value="Célibataire">Célibataire</option>
                                            <option value="Marié(e)">Marié(e)</option>
                                            <option value="Veuf(ve)">Veuf(ve)</option>
                                            <option value="Divorcé(e)">Divorcé(e)</option>
                                        </select>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Époux(se)</label>
                                        <input type="text" wire:model="edit_nom_prenom_epoux_defunt" class="{{ $ic }}">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Père</label>
                                        <input type="text" wire:model="edit_nom_prenom_pere_defunt" style="text-transform:uppercase" class="{{ $ic }}">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Mère</label>
                                        <input type="text" wire:model="edit_nom_prenom_mere_defunt" style="text-transform:uppercase" class="{{ $ic }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endif

                    </div>
                </div>

                {{-- Footer --}}
                <div class="border-t border-gray-100 bg-white">
                    @if(! $editMode)
                    <div class="px-6 py-3 border-b border-gray-50 flex items-center gap-2 flex-wrap bg-gray-50/50">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mr-1">Imprimer :</span>
                        <a href="#" target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-orange/8 text-orange text-xs font-semibold
                                  rounded-xl border border-orange/20 hover:bg-orange/15 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"/>
                            </svg>
                            Acte de décès
                        </a>
                    </div>
                    @endif
                    <div class="px-6 py-3.5 flex items-center justify-between gap-3">
                        <button wire:click="confirmDelete"
                                wire:confirm="Supprimer cet acte de décès ? Action irréversible."
                                class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 text-sm font-semibold
                                       rounded-xl hover:bg-red-100 transition-colors border border-red-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                            Supprimer
                        </button>
                        <div class="flex items-center gap-2">
                            @if($editMode)
                                <button wire:click="cancelEdit"
                                        class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
                                    Annuler
                                </button>
                                <button wire:click="update" wire:loading.attr="disabled" wire:target="update"
                                        class="flex items-center gap-2 px-5 py-2 bg-orange text-white text-sm font-semibold
                                               rounded-xl hover:bg-orange/90 transition-colors shadow-sm disabled:opacity-60">
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
    </div>
    @endif


    {{-- ═══════════════════════════════════════════════════════
         MODAL CRÉATION — 4 ÉTAPES
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

                <div class="max-h-[88vh] overflow-y-auto">
                    <div class="p-4 sm:p-6">

                        {{-- Stepper --}}
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-5">
                            <div class="flex items-center">
                                @for ($i = 1; $i <= $maxSteps; $i++)
                                    <div class="flex flex-col items-center flex-1">
                                        <button type="button" wire:click="goToStep({{ $i }})"
                                                @class([
                                                    'w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-bold transition-all duration-300',
                                                    'bg-orange text-white shadow-md' => $i === $step,
                                                    'bg-orange/20 text-orange cursor-pointer hover:bg-orange/30' => $i < $step,
                                                    'bg-gray-100 text-gray-400 cursor-default' => $i > $step,
                                                ])>
                                            @if($i < $step)
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>
                                            @else
                                                {{ $i }}
                                            @endif
                                        </button>
                                        <span @class([
                                            'text-[9px] mt-1 font-medium text-center leading-tight hidden sm:block',
                                            'text-orange'  => $i <= $step,
                                            'text-gray-400'=> $i > $step,
                                        ])>{{ $this->stepLabel($i) }}</span>
                                    </div>
                                    @if($i < $maxSteps)
                                        <div @class(['h-0.5 flex-1 mx-0.5 transition-all duration-500', 'bg-orange/40' => $i < $step, 'bg-gray-200' => $i >= $step])></div>
                                    @endif
                                @endfor
                            </div>
                        </div>

                        {{-- Erreurs --}}
                        @if($errors->any())
                            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl">
                                <ul class="text-xs text-red-600 space-y-0.5 list-disc list-inside">
                                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Card --}}
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-orange/10 flex items-center justify-center text-orange font-bold text-sm shrink-0">
                                    {{ $step }}
                                </div>
                                <div>
                                    <h2 class="font-semibold text-navy text-sm">{{ $this->stepLabel($step) }}</h2>
                                    <p class="text-xs text-gray-400 mt-0.5">Étape {{ $step }} sur {{ $maxSteps }}</p>
                                </div>
                            </div>

                            @php
                                $ic = 'w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                       focus:outline-none focus:ring-2 focus:ring-orange/20 focus:border-orange/30 transition-all';
                            @endphp

                            {{-- ══ ÉTAPE 1 — Registre ══ --}}
                            @if($step === 1)
                            <div class="p-6 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Commune <span class="text-red-400">*</span></label>
                                        <select wire:model="commune_id" class="{{ $ic }} appearance-none @error('commune_id') border-red-300 @enderror">
                                            <option value="">— Sélectionner la commune —</option>
                                            @foreach($communes as $c)
                                                <option value="{{ $c->id }}">{{ $c->nom_commune }}</option>
                                            @endforeach
                                        </select>
                                        @error('commune_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">N° Acte <span class="text-red-400">*</span></label>
                                        <input type="text" wire:model="numero_act_deces" placeholder="ex : 008" class="{{ $ic }} @error('numero_act_deces') border-red-300 @enderror">
                                        @error('numero_act_deces') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Année registre <span class="text-red-400">*</span></label>
                                        <input type="number" wire:model="annee_registre_deces" class="{{ $ic }} @error('annee_registre_deces') border-red-300 @enderror">
                                        @error('annee_registre_deces') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">N° Registre</label>
                                        <input type="text" wire:model="numero_registre_deces" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Nature de la déclaration</label>
                                        <select wire:model="nature_declarat_deces" class="{{ $ic }} appearance-none">
                                            <option value="">— Sélectionner —</option>
                                            <option value="Déclaration de décès">Déclaration de décès</option>
                                            <option value="Transcription de décès">Transcription de décès</option>
                                            <option value="Jugement déclaratif">Jugement déclaratif</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Date de dressage</label>
                                        <input type="date" wire:model="date_dessage_deces" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Heure de dressage</label>
                                        <input type="text" wire:model="heure_dressage_deces" placeholder="ex : 09h00" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Date copie intégrale</label>
                                        <input type="date" wire:model="date_dessage_copi_integral_deces" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Officier d'État Civil</label>
                                        <input type="text" wire:model="officier_etat_civil_deces" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Qualité</label>
                                        <input type="text" wire:model="qualite_etat_civil_deces" placeholder="ex : Maire…" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Nous avons signé</label>
                                        <input type="text" wire:model="nous_avons_signe_deces" class="{{ $ic }}">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Mention jugement supplétif</label>
                                        <textarea wire:model="ment_jugem_supplet" rows="2" placeholder="Si applicable…" class="{{ $ic }} resize-none"></textarea>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- ══ ÉTAPE 2 — Le décès ══ --}}
                            @if($step === 2)
                            <div class="p-6 space-y-4">
                                <div class="p-3 bg-orange/5 border border-orange/15 rounded-xl mb-2">
                                    <p class="text-xs text-orange font-medium">Informations sur le décès</p>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Date du décès <span class="text-red-400">*</span></label>
                                        <input type="date" wire:model="date_deces" class="{{ $ic }} @error('date_deces') border-red-300 @enderror">
                                        @error('date_deces') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Heure du décès</label>
                                        <input type="text" wire:model="heure_min_deces" placeholder="ex : 23h45" class="{{ $ic }}">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Lieu du décès <span class="text-red-400">*</span></label>
                                        <input type="text" wire:model="lieu_deces" placeholder="ex : CHU de Bouaké, domicile…" class="{{ $ic }} @error('lieu_deces') border-red-300 @enderror">
                                        @error('lieu_deces') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- ══ ÉTAPE 3 — Le défunt ══ --}}
                            @if($step === 3)
                            <div class="p-6 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Nom <span class="text-red-400">*</span></label>
                                        <input type="text" wire:model="nom_defunt" style="text-transform:uppercase" placeholder="NOM" class="{{ $ic }} @error('nom_defunt') border-red-300 @enderror">
                                        @error('nom_defunt') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Prénom(s)</label>
                                        <input type="text" wire:model="prenom_defunt" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Sexe <span class="text-red-400">*</span></label>
                                        <div class="flex gap-3">
                                            @foreach(['M' => '♂ Masculin', 'F' => '♀ Féminin'] as $val => $label)
                                            <label class="flex-1 flex items-center justify-center py-2.5 border rounded-xl cursor-pointer text-sm font-medium transition-all
                                                         {{ $sexe_deces === $val
                                                            ? ($val === 'M' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-pink-50 text-pink-600 border-pink-200')
                                                            : 'bg-gray-50 text-gray-500 border-gray-200 hover:border-orange/30' }}">
                                                <input type="radio" wire:model.live="sexe_deces" value="{{ $val }}" class="sr-only">
                                                {{ $label }}
                                            </label>
                                            @endforeach
                                        </div>
                                        @error('sexe_deces') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Date de naissance</label>
                                        <input type="date" wire:model="date_naissance_defunt" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Lieu de naissance</label>
                                        <input type="text" wire:model="lieu_naissance_defunt" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Profession</label>
                                        <input type="text" wire:model="profession_defunt" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Situation familiale</label>
                                        <select wire:model="situa_familial_defunt" class="{{ $ic }} appearance-none">
                                            <option value="">— Sélectionner —</option>
                                            <option value="Célibataire">Célibataire</option>
                                            <option value="Marié(e)">Marié(e)</option>
                                            <option value="Veuf(ve)">Veuf(ve)</option>
                                            <option value="Divorcé(e)">Divorcé(e)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Fils / Fille de</label>
                                        <input type="text" wire:model="fils_fille_deces" placeholder="fils / fille" class="{{ $ic }}">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Époux(se) survivant(e)</label>
                                        <input type="text" wire:model="nom_prenom_epoux_defunt" placeholder="Si marié(e)" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Nom et Prénoms du père</label>
                                        <input type="text" wire:model="nom_prenom_pere_defunt" style="text-transform:uppercase" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Domicile du père</label>
                                        <input type="text" wire:model="domicile_pere_defunt" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Nom et Prénoms de la mère</label>
                                        <input type="text" wire:model="nom_prenom_mere_defunt" style="text-transform:uppercase" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Domicile de la mère</label>
                                        <input type="text" wire:model="domicile_mere_defunt" class="{{ $ic }}">
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- ══ ÉTAPE 4 — Déclarant & Officier d'origine ══ --}}
                            @if($step === 4)
                            <div class="p-6 space-y-5">
                                {{-- Déclarant & Interprète --}}
                                <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Déclarant & Interprète</p>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Informations du déclarant</label>
                                            <textarea wire:model="info_declarant" rows="3"
                                                      placeholder="Nom, prénom, âge, profession, domicile du déclarant…"
                                                      class="{{ $ic }} resize-none"></textarea>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Langue du déclarant</label>
                                                <input type="text" wire:model="langue_declarant" placeholder="ex : Dioula, Baoulé…" class="{{ $ic }}">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Nom et Prénoms de l'interprète</label>
                                                <input type="text" wire:model="nom_prenom_interprete" class="{{ $ic }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Officier d'origine --}}
                                <div class="p-4 bg-orange/5 border border-orange/15 rounded-xl">
                                    <p class="text-xs font-bold text-orange/80 uppercase tracking-wide mb-4">Officier d'État Civil d'origine</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Officier</label>
                                            <input type="text" wire:model="officier_etat_civil_origin_defunt" class="{{ $ic }}">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Centre d'État Civil</label>
                                            <input type="text" wire:model="centre_etat_civil_origin_defunt" class="{{ $ic }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- Récapitulatif --}}
                                <div class="p-4 bg-orange/5 border border-orange/15 rounded-2xl">
                                    <p class="text-xs font-bold text-orange/80 uppercase tracking-wide mb-3">Récapitulatif avant enregistrement</p>
                                    <div class="grid grid-cols-2 gap-2 text-xs">
                                        <div><span class="text-gray-400">Acte N° :</span> <span class="font-semibold text-navy">{{ $numero_act_deces ?: '—' }}</span></div>
                                        <div><span class="text-gray-400">Décès le :</span> <span class="font-semibold text-navy">{{ $date_deces ?: '—' }}</span></div>
                                        <div><span class="text-gray-400">Défunt :</span> <span class="font-semibold text-navy uppercase">{{ $nom_defunt ?: '—' }} {{ $prenom_defunt }}</span></div>
                                        <div><span class="text-gray-400">Lieu :</span> <span class="font-medium text-navy">{{ $lieu_deces ?: '—' }}</span></div>
                                        <div><span class="text-gray-400">Sexe :</span> <span class="font-medium text-navy">{{ $sexe_deces === 'M' ? 'Masculin' : ($sexe_deces === 'F' ? 'Féminin' : '—') }}</span></div>
                                        <div><span class="text-gray-400">Situation :</span> <span class="font-medium text-navy">{{ $situa_familial_defunt ?: '—' }}</span></div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Navigation --}}
                            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-3">
                                @if($step > 1)
                                    <button type="button" wire:click="prevStep"
                                            class="flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                                        </svg>
                                        Précédent
                                    </button>
                                @else
                                    <div></div>
                                @endif
                                <span class="text-xs text-gray-400 hidden sm:block">{{ $step }} / {{ $maxSteps }}</span>
                                @if($step < $maxSteps)
                                    <button type="button" wire:click="nextStep"
                                            wire:loading.attr="disabled" wire:target="nextStep"
                                            class="flex items-center gap-2 px-6 py-2.5 bg-orange text-white text-sm font-semibold rounded-xl
                                                   hover:bg-orange/90 transition-colors shadow-sm disabled:opacity-60">
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
                                            class="flex items-center gap-2 px-6 py-2.5 bg-orange text-white text-sm font-semibold rounded-xl
                                                   hover:bg-orange/90 transition-colors shadow-sm disabled:opacity-60">
                                        <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                            </svg>
                                            Enregistrer l'acte
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
