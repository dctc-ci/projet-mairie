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
                    <h1 class="font-serif text-2xl font-bold leading-tight">Autres déclarations</h1>
                    <p class="text-white/60 text-sm mt-1">Reconnaissances, légalisations et actes divers.</p>
                </div>
                <div class="shrink-0">
                    <button wire:click="openModal"
                            class="inline-flex items-center gap-2 px-5 py-2.5
                                   bg-white text-[#8a6d00] text-sm font-semibold rounded-xl
                                   hover:bg-yellow-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Nouvelle déclaration
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
                       placeholder="Nom déclarant, N° acte ou type d'acte…"
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl
                              text-sm text-navy placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-navy/15 focus:border-navy/30 transition-all">
            </div>
            
            <div class="sm:w-32">
                <input type="number" wire:model.live="filtre_annee" placeholder="Année"
                       class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-navy
                              focus:outline-none focus:ring-2 focus:ring-navy/15 focus:border-navy/30 transition-all">
            </div>
        </div>

        {{-- ── Table ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fadeInUp">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Déclarant</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">N° Acte</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Type d'acte</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Date</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden lg:table-cell">Commune</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($declarations as $a)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-navy/10 flex items-center justify-center text-navy text-xs font-bold shrink-0">
                                        {{ Str::upper(substr($a->nom_prenom_autre ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="block font-semibold text-navy text-xs">
                                            {{ $a->civilite ? $a->civilite . ' ' : '' }}{{ strtoupper($a->nom_prenom_autre ?? '—') }}
                                        </span>
                                        @if($a->profession_autre)
                                            <span class="block text-[10px] text-gray-400 mt-0.5">{{ $a->profession_autre }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <span class="font-mono text-xs font-medium text-navy">{{ $a->numero_act_autre ?? '—' }}</span>
                                @if($a->annee_registre_autre)
                                    <span class="block text-[10px] text-gray-400">{{ $a->annee_registre_autre }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                @if($a->act_autre)
                                    <span class="inline-flex px-2.5 py-1 bg-navy/8 text-navy text-[10px] font-semibold rounded-full">
                                        {{ Str::limit($a->act_autre, 25) }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                @if($a->date_dressage_autre)
                                    <span class="text-xs text-navy font-medium">
                                        {{ \Carbon\Carbon::parse($a->date_dressage_autre)->locale('fr')->isoFormat('DD MMM YYYY') }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 hidden lg:table-cell">
                                <span class="text-xs text-gray-600">{{ $a->commune?->nom_commune ?? '—' }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <button wire:click="viewFiche({{ $a->id }})"
                                        class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center
                                               text-gray-400 hover:text-navy hover:bg-navy/10 transition-colors ml-auto">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V8.25z"/>
                                </svg>
                                <p class="text-gray-400 text-sm">Aucune déclaration enregistrée.</p>
                                <button wire:click="openModal"
                                        class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-navy hover:text-navy/70 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                    </svg>
                                    Créer la première déclaration
                                </button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($declarations->hasPages())
                <div class="px-5 py-3 border-t border-gray-100">{{ $declarations->links() }}</div>
            @endif
        </div>

        <p class="text-center text-xs text-gray-400 pb-4">
            &copy; {{ date('Y') }} Mairie de Cocody — Système de Gestion Municipale
        </p>
    </div>


    {{-- ═══════════════════════════════════════════════════════
         MODAL FICHE
    ═══════════════════════════════════════════════════════ --}}
    @if($showFicheModal && $selectedDeclaration)
    @php
        $a  = $selectedDeclaration;
        $fd = fn($v) => $v ? \Carbon\Carbon::parse($v)->locale('fr')->isoFormat('DD MMMM YYYY') : '—';
        $ic = 'w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs text-navy focus:outline-none focus:ring-2 focus:ring-navy/15';
    @endphp
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeFicheModal"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative z-10 w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden">

                {{-- En-tête --}}
                <div class="bg-gradient-to-r from-navy via-[#0f2d56] to-[#1a3a6b] px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-13 h-13 rounded-2xl bg-white/15 flex items-center justify-center text-2xl font-bold shrink-0 w-14 h-14">
                                {{ Str::upper(substr($a->nom_prenom_autre ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                @if($editMode)
                                    <div class="flex gap-2 items-center">
                                        <select wire:model="edit_civilite"
                                                class="bg-white/10 border border-white/20 rounded-xl px-2 py-1.5 text-white text-xs w-20
                                                       focus:outline-none focus:ring-2 focus:ring-white/30 appearance-none">
                                            <option value="">Civilité</option>
                                            @foreach(['M.','Mme','Dr','Pr','Me'] as $civ)
                                                <option value="{{ $civ }}">{{ $civ }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" wire:model="edit_nom_prenom_autre" style="text-transform:uppercase"
                                               class="bg-white/10 border border-white/20 rounded-xl px-3 py-1.5 text-white font-bold text-sm w-52
                                                      focus:outline-none focus:ring-2 focus:ring-white/30">
                                    </div>
                                @else
                                    <h2 class="font-serif text-xl font-bold">
                                        {{ $a->civilite ? $a->civilite . ' ' : '' }}{{ strtoupper($a->nom_prenom_autre ?? '—') }}
                                    </h2>
                                @endif
                                <div class="flex items-center gap-3 mt-1.5">
                                    <span class="text-white/60 text-xs font-mono">N° {{ $a->numero_act_autre ?? '—' }}</span>
                                    @if($a->act_autre)
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-white/15">{{ $a->act_autre }}</span>
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

                        {{-- Infos registre --}}
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach([
                                'Commune'      => $a->commune?->nom_commune ?? '—',
                                'N° Acte'      => $a->numero_act_autre ?? '—',
                                'Année'        => $a->annee_registre_autre ?? '—',
                                'Date dressage'=> $fd($a->date_dressage_autre),
                                'Heure'        => $a->heure_autre ?? '—',
                                'Officier'     => $a->officier_etat_civil_autre ?? '—',
                            ] as $lbl => $val)
                            <div class="bg-gray-50 rounded-xl border border-gray-100 p-3">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">{{ $lbl }}</p>
                                <p class="text-xs font-semibold text-navy">{{ $val }}</p>
                            </div>
                            @endforeach
                        </div>

                        {{-- Déclarant --}}
                        <div class="bg-navy/4 border border-navy/12 rounded-2xl p-4">
                            <p class="text-[10px] font-bold text-navy/60 uppercase tracking-wide mb-3">Déclarant</p>
                            <div class="grid grid-cols-2 gap-3 text-xs">
                                <div class="col-span-2">
                                    <span class="text-gray-400">Nom :</span>
                                    <span class="font-bold text-navy ml-1">
                                        {{ $a->civilite ? $a->civilite . ' ' : '' }}{{ strtoupper($a->nom_prenom_autre ?? '—') }}
                                    </span>
                                </div>
                                @if($a->profession_autre)
                                    <div><span class="text-gray-400">Profession :</span> <span class="font-medium text-navy">{{ $a->profession_autre }}</span></div>
                                @endif
                                @if($a->domicile_autre)
                                    <div class="col-span-2"><span class="text-gray-400">Domicile :</span> <span class="font-medium text-navy">{{ $a->domicile_autre }}</span></div>
                                @endif
                            </div>
                        </div>

                        {{-- Acte --}}
                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">L'acte</p>
                            <div class="space-y-2 text-xs">
                                @if($a->act_autre)
                                    <div>
                                        <span class="text-gray-400">Type d'acte :</span>
                                        <span class="font-bold text-navy bg-navy/8 px-2 py-0.5 rounded-full ml-1">{{ $a->act_autre }}</span>
                                    </div>
                                @endif
                                @if($a->concernant_autre)
                                    <div><span class="text-gray-400">Concernant :</span> <span class="font-medium text-navy">{{ $a->concernant_autre }}</span></div>
                                @endif
                                @if($a->date_lettre_autre)
                                    <div><span class="text-gray-400">Date en lettres :</span> <span class="font-medium text-navy italic">{{ $a->date_lettre_autre }}</span></div>
                                @endif
                                @if($a->info_complet_rapport_act)
                                    <div class="mt-2 pt-2 border-t border-gray-200">
                                        <p class="text-gray-400 mb-1 font-semibold uppercase text-[10px]">Rapport complet :</p>
                                        <p class="text-navy leading-relaxed whitespace-pre-line">{{ $a->info_complet_rapport_act }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @else
                        {{-- ── FORMULAIRE ÉDITION ── --}}
                        <div class="space-y-4">
                            {{-- Registre --}}
                            <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">Registre</p>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Commune <span class="text-red-400">*</span></label>
                                        <select wire:model="edit_commune_id" class="{{ $ic }} appearance-none @error('edit_commune_id') border-red-300 @enderror">
                                            <option value="">—</option>
                                            @foreach($communes as $c)
                                                <option value="{{ $c->id }}">{{ $c->nom_commune }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">N° Acte <span class="text-red-400">*</span></label>
                                        <input type="text" wire:model="edit_numero_act_autre" class="{{ $ic }} @error('edit_numero_act_autre') border-red-300 @enderror">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Année</label>
                                        <input type="number" wire:model="edit_annee_registre_autre" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date dressage</label>
                                        <input type="date" wire:model="edit_date_dressage_autre" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Officier</label>
                                        <input type="text" wire:model="edit_officier_etat_civil_autre" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Qualité</label>
                                        <input type="text" wire:model="edit_qualite_etat_civil_autre" class="{{ $ic }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Déclarant --}}
                            <div class="p-4 bg-navy/4 border border-navy/12 rounded-xl">
                                <p class="text-[10px] font-bold text-navy/60 uppercase tracking-wide mb-3">Déclarant</p>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Civilité</label>
                                        <select wire:model="edit_civilite" class="{{ $ic }} appearance-none">
                                            <option value="">—</option>
                                            @foreach(['M.','Mme','Dr','Pr','Me'] as $civ)
                                                <option value="{{ $civ }}">{{ $civ }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Nom <span class="text-red-400">*</span></label>
                                        <input type="text" wire:model="edit_nom_prenom_autre" style="text-transform:uppercase"
                                               class="{{ $ic }} @error('edit_nom_prenom_autre') border-red-300 @enderror">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Profession</label>
                                        <input type="text" wire:model="edit_profession_autre" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Domicile</label>
                                        <input type="text" wire:model="edit_domicile_autre" class="{{ $ic }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Acte --}}
                            <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">L'acte</p>
                                <div class="space-y-2">
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Type d'acte</label>
                                        <input type="text" wire:model="edit_act_autre" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Concernant</label>
                                        <input type="text" wire:model="edit_concernant_autre" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Rapport complet</label>
                                        <textarea wire:model="edit_info_complet_rapport_act" rows="5"
                                                  class="{{ $ic }} resize-none"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-6 py-3.5 border-t border-gray-100 bg-white flex items-center justify-between gap-3">
                    <button wire:click="confirmDelete"
                            wire:confirm="Supprimer cette déclaration ? Action irréversible."
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
                                    class="flex items-center gap-2 px-5 py-2 bg-navy text-white text-sm font-semibold
                                           rounded-xl hover:bg-[#0f2d56] transition-colors shadow-sm disabled:opacity-60">
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
         MODAL CRÉATION — 3 ÉTAPES
    ═══════════════════════════════════════════════════════ --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeModal"></div>
        <div class="flex min-h-full items-end justify-center p-4 sm:items-center sm:p-0">
            <div class="relative z-10 transform overflow-hidden rounded-2xl bg-gray-50 text-left
                        shadow-2xl sm:my-8 sm:w-full sm:max-w-2xl border border-white/20">

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
                                                    'bg-navy text-white shadow-md' => $i === $step,
                                                    'bg-navy/20 text-navy cursor-pointer hover:bg-navy/30' => $i < $step,
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
                                            'text-navy'    => $i <= $step,
                                            'text-gray-400'=> $i > $step,
                                        ])>{{ $this->stepLabel($i) }}</span>
                                    </div>
                                    @if($i < $maxSteps)
                                        <div @class(['h-0.5 flex-1 mx-0.5 transition-all duration-500', 'bg-navy/30' => $i < $step, 'bg-gray-200' => $i >= $step])></div>
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
                                <div class="w-9 h-9 rounded-xl bg-navy/8 flex items-center justify-center text-navy font-bold text-sm shrink-0">
                                    {{ $step }}
                                </div>
                                <div>
                                    <h2 class="font-semibold text-navy text-sm">{{ $this->stepLabel($step) }}</h2>
                                    <p class="text-xs text-gray-400 mt-0.5">Étape {{ $step }} sur {{ $maxSteps }}</p>
                                </div>
                            </div>

                            @php
                                $ic = 'w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                       focus:outline-none focus:ring-2 focus:ring-navy/15 focus:border-navy/30 transition-all';
                            @endphp

                            {{-- ══ ÉTAPE 1 — Registre ══ --}}
                            @if($step === 1)
                            <div class="p-6 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Commune <span class="text-red-400">*</span>
                                        </label>
                                        <select wire:model="commune_id" class="{{ $ic }} appearance-none @error('commune_id') border-red-300 @enderror">
                                            <option value="">— Sélectionner la commune —</option>
                                            @foreach($communes as $c)
                                                <option value="{{ $c->id }}">{{ $c->nom_commune }}</option>
                                            @endforeach
                                        </select>
                                        @error('commune_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            N° Acte <span class="text-red-400">*</span>
                                        </label>
                                        <input type="text" wire:model="numero_act_autre" placeholder="ex : 003"
                                               class="{{ $ic }} @error('numero_act_autre') border-red-300 @enderror">
                                        @error('numero_act_autre') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Année <span class="text-red-400">*</span>
                                        </label>
                                        <input type="number" wire:model="annee_registre_autre"
                                               class="{{ $ic }} @error('annee_registre_autre') border-red-300 @enderror">
                                        @error('annee_registre_autre') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">N° Registre</label>
                                        <input type="text" wire:model="numero_registe_autre" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Date de dressage</label>
                                        <input type="date" wire:model="date_dressage_autre" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Heure</label>
                                        <input type="text" wire:model="heure_autre" placeholder="ex : 10h00" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Officier d'État Civil</label>
                                        <input type="text" wire:model="officier_etat_civil_autre" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Qualité</label>
                                        <input type="text" wire:model="qualite_etat_civil_autre" placeholder="ex : Maire…" class="{{ $ic }}">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Date en toutes lettres</label>
                                        <input type="text" wire:model="date_lettre_autre"
                                               placeholder="ex : le vingt mars deux mille vingt-six" class="{{ $ic }}">
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- ══ ÉTAPE 2 — Déclarant ══ --}}
                            @if($step === 2)
                            <div class="p-6 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Civilité</label>
                                        <select wire:model="civilite" class="{{ $ic }} appearance-none">
                                            <option value="">— Sélectionner —</option>
                                            @foreach(['M.','Mme','Dr','Pr','Me'] as $civ)
                                                <option value="{{ $civ }}">{{ $civ }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Nom et Prénoms <span class="text-red-400">*</span>
                                        </label>
                                        <input type="text" wire:model="nom_prenom_autre" style="text-transform:uppercase"
                                               placeholder="NOM Prénom(s)"
                                               class="{{ $ic }} @error('nom_prenom_autre') border-red-300 @enderror">
                                        @error('nom_prenom_autre') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Profession</label>
                                        <input type="text" wire:model="profession_autre" placeholder="ex : Commerçant" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Domicile</label>
                                        <input type="text" wire:model="domicile_autre" placeholder="Adresse" class="{{ $ic }}">
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- ══ ÉTAPE 3 — Acte ══ --}}
                            @if($step === 3)
                            <div class="p-6 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Type d'acte</label>
                                        <input type="text" wire:model="act_autre"
                                               placeholder="ex : Reconnaissance, Légalisation…" class="{{ $ic }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Concernant</label>
                                        <input type="text" wire:model="concernant_autre"
                                               placeholder="Objet de la déclaration" class="{{ $ic }}">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Rapport complet / Corps de l'acte</label>
                                        <textarea wire:model="info_complet_rapport_act" rows="7"
                                                  placeholder="Saisissez ici le corps complet de l'acte…"
                                                  class="{{ $ic }} resize-none"></textarea>
                                    </div>
                                </div>

                                {{-- Récapitulatif --}}
                                <div class="p-4 bg-navy/5 border border-navy/12 rounded-2xl">
                                    <p class="text-xs font-bold text-navy/70 uppercase tracking-wide mb-3">Récapitulatif</p>
                                    <div class="grid grid-cols-2 gap-2 text-xs">
                                        <div><span class="text-gray-400">Acte N° :</span> <span class="font-semibold text-navy">{{ $numero_act_autre ?: '—' }}</span></div>
                                        <div><span class="text-gray-400">Année :</span> <span class="font-semibold text-navy">{{ $annee_registre_autre ?: '—' }}</span></div>
                                        <div class="col-span-2">
                                            <span class="text-gray-400">Déclarant :</span>
                                            <span class="font-semibold text-navy uppercase ml-1">
                                                {{ $civilite ? $civilite . ' ' : '' }}{{ $nom_prenom_autre ?: '—' }}
                                            </span>
                                        </div>
                                        <div><span class="text-gray-400">Type acte :</span> <span class="font-medium text-navy">{{ $act_autre ?: '—' }}</span></div>
                                        <div><span class="text-gray-400">Date :</span> <span class="font-medium text-navy">{{ $date_dressage_autre ?: '—' }}</span></div>
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
                                            class="flex items-center gap-2 px-6 py-2.5 bg-navy text-white text-sm font-semibold rounded-xl
                                                   hover:bg-[#0f2d56] transition-colors shadow-sm disabled:opacity-60">
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
                                            class="flex items-center gap-2 px-6 py-2.5 bg-navy text-white text-sm font-semibold rounded-xl
                                                   hover:bg-[#0f2d56] transition-colors shadow-sm disabled:opacity-60">
                                        <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                            </svg>
                                            Enregistrer
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
