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
                    <h1 class="font-serif text-2xl font-bold leading-tight">Bulletins de salaire</h1>
                    <p class="text-white/60 text-sm mt-1">Générez et gérez les bulletins mensuels des agents.</p>
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
                        Nouveau bulletin
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

        {{-- ── Filtres ── --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
                <input type="text"
                       wire:model.live.debounce.300ms="search_table"
                       placeholder="Rechercher par nom ou matricule…"
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl
                              text-sm text-navy placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
            </div>
            <div class="sm:w-48">
                <input type="month"
                       wire:model.live="filtre_mois"
                       class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl
                              text-sm text-navy
                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
            </div>
        </div>

        {{-- ── Table ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fadeInUp">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Agent</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Mois</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">Salaire brut</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Retenues</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Net à payer</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($bulletins as $b)
                        @php $calc = \App\Livewire\Personnels\CreateBulletinSalaire::calculer($b); @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    @if($b->agent?->photo_agent)
                                        <img src="{{ Storage::url($b->agent->photo_agent) }}"
                                             class="w-8 h-8 rounded-full object-cover shadow-sm shrink-0">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-navy/10 flex items-center justify-center text-navy font-bold text-xs shrink-0">
                                            {{ Str::upper(substr($b->agent?->nom_prenom_agent ?? '?', 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <span class="block font-semibold text-navy text-xs">{{ $b->agent?->nom_prenom_agent ?? '—' }}</span>
                                        <span class="block text-[10px] text-gray-400 font-mono mt-0.5">{{ $b->agent?->matricule ?? '—' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex px-2.5 py-1 bg-navy/8 text-navy text-xs font-bold rounded-lg capitalize">
                                    {{ $this->formatMois($b->mois_paie) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <span class="text-xs font-semibold text-navy">{{ number_format($calc['salaire_brut'], 0, ',', ' ') }}</span>
                                <span class="text-[10px] text-gray-400 ml-1">FCFA</span>
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                <span class="text-xs font-semibold text-red-500">- {{ number_format($calc['total_retenues'], 0, ',', ' ') }}</span>
                                <span class="text-[10px] text-gray-400 ml-1">FCFA</span>
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                <span class="text-xs font-bold text-green">{{ number_format($calc['salaire_net_a_payer'], 0, ',', ' ') }}</span>
                                <span class="text-[10px] text-gray-400 ml-1">FCFA</span>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                </svg>
                                <p class="text-gray-400 text-sm">Aucun bulletin enregistré.</p>
                                @if($this->canManagePersonnel)
                                <button wire:click="openModal"
                                        class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-navy hover:text-gold transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                    </svg>
                                    Créer le premier bulletin
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($bulletins->hasPages())
                <div class="px-5 py-3 border-t border-gray-100">{{ $bulletins->links() }}</div>
            @endif
        </div>

        <p class="text-center text-xs text-gray-400 pb-4">
            &copy; {{ date('Y') }} Mairie de Cocody — Système de Gestion Municipale
        </p>
    </div>


    {{-- ═══════════════════════════════════════════════════════
         MODAL FICHE BULLETIN (consultation + modification + impression)
    ═══════════════════════════════════════════════════════ --}}
    @if($showFicheModal && $this->selectedBulletin)
    @php
        $b    = $this->selectedBulletin;
        $calc = \App\Livewire\Personnels\CreateBulletinSalaire::calculer($b);
        $agent  = $b->agent;
        $bareme = $agent?->baremeSalarial;
        $commune = $agent?->commune;
    @endphp
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeFicheModal"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative z-10 w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden">

                {{-- En-tête --}}
                <div class="bg-gradient-to-r from-navy via-[#0f2d56] to-[#1a3a6b] px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            @if($agent?->photo_agent)
                                <img src="{{ Storage::url($agent->photo_agent) }}"
                                     class="w-14 h-14 rounded-2xl object-cover ring-2 ring-white/20 shrink-0">
                            @else
                                <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-gold font-bold text-xl shrink-0">
                                    {{ Str::upper(substr($agent?->nom_prenom_agent ?? '?', 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h2 class="font-serif text-lg font-bold">{{ $agent?->nom_prenom_agent ?? '—' }}</h2>
                                <p class="text-white/60 text-sm mt-0.5 font-mono">{{ $agent?->matricule ?? '—' }}</p>
                                <span class="inline-flex mt-1.5 px-2.5 py-0.5 bg-gold/20 text-gold text-[10px] font-bold rounded-full capitalize">
                                    {{ $this->formatMois($b->mois_paie) }}
                                </span>
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

                        {{-- Mois de paie (éditable) --}}
                        <div class="flex items-center gap-3 p-3 bg-navy/4 border border-navy/10 rounded-xl">
                            <svg class="w-4 h-4 text-navy/50 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                            </svg>
                            <div class="flex-1">
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Période de paie</p>
                                @if($editMode)
                                    <input type="month" wire:model="edit_mois_paie"
                                           class="mt-1 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-sm text-navy
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    @error('edit_mois_paie') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                @else
                                    <p class="text-sm font-bold text-navy capitalize">{{ $this->formatMois($b->mois_paie) }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Bloc Salaires (depuis barème — lecture seule) --}}
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-4">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                Éléments de salaire <span class="bg-gray-200 text-gray-500 px-1.5 py-0.5 rounded text-[9px]">Barème — lecture seule</span>
                            </p>
                            <div class="space-y-1.5">
                                @foreach([
                                    'Salaire de base'      => $calc['salaire_base'],
                                    'Indemnité résidence'  => $calc['indem_residence'],
                                ] as $label => $val)
                                <div class="flex items-center justify-between py-1 border-b border-gray-100 last:border-0">
                                    <span class="text-xs text-gray-500">{{ $label }}</span>
                                    <span class="text-xs font-semibold text-navy">{{ number_format($val, 0, ',', ' ') }} FCFA</span>
                                </div>
                                @endforeach
                                <div class="flex items-center justify-between py-1.5 bg-navy/5 rounded-lg px-2 mt-1">
                                    <span class="text-xs font-bold text-navy uppercase tracking-wide">Salaire brut</span>
                                    <span class="text-sm font-bold text-navy">{{ number_format($calc['salaire_brut'], 0, ',', ' ') }} FCFA</span>
                                </div>
                            </div>
                        </div>

                        {{-- Retenues (éditables) --}}
                        <div class="bg-red-50/50 rounded-2xl border border-red-100 p-4">
                            <p class="text-[10px] font-bold text-red-400 uppercase tracking-wide mb-3">Retenues</p>
                            <div class="space-y-2">
                                @php
                                    $retenues = [
                                        'IGR'                       => ['field' => 'edit_igr',                   'val' => $calc['igr']],
                                        'Contribution Nationale'    => ['field' => 'edit_contrib_nation',        'val' => $calc['contrib_nation']],
                                        "Impôt sur salaire"         => ['field' => 'edit_impot_salaire',         'val' => $calc['impot_salaire']],
                                        'Caisse de retraite (CNPS)' => ['field' => 'edit_indem_transp_cotation', 'val' => $calc['cnps']],
                                    ];
                                @endphp
                                @foreach($retenues as $label => $data)
                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-xs text-gray-600 flex-1">{{ $label }}</span>
                                    @if($editMode)
                                        <div class="relative w-36">
                                            <input type="number" wire:model="{{ $data['field'] }}" min="0" step="10"
                                                   class="w-full px-3 py-1.5 pr-10 bg-white border border-red-200 rounded-lg text-xs text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-300">
                                            <span class="absolute right-2 top-1/2 -translate-y-1/2 text-[9px] text-gray-400">FCFA</span>
                                        </div>
                                    @else
                                        <span class="text-xs font-semibold text-red-600">- {{ number_format($data['val'], 0, ',', ' ') }} FCFA</span>
                                    @endif
                                </div>
                                @endforeach

                                <div class="flex items-center justify-between py-1.5 bg-red-100 rounded-lg px-2 mt-1">
                                    <span class="text-xs font-bold text-red-700 uppercase tracking-wide">Total retenues</span>
                                    <span class="text-sm font-bold text-red-700">- {{ number_format($calc['total_retenues'], 0, ',', ' ') }} FCFA</span>
                                </div>
                            </div>
                        </div>

                        {{-- Salaire net + Indemnités + Net à payer --}}
                        <div class="bg-green/5 rounded-2xl border border-green/15 p-4">
                            <div class="flex items-center justify-between py-1.5 bg-green/10 rounded-lg px-2 mb-3">
                                <span class="text-xs font-bold text-green uppercase tracking-wide">Salaire net</span>
                                <span class="text-sm font-bold text-green">{{ number_format($calc['salaire_net'], 0, ',', ' ') }} FCFA</span>
                            </div>
                            <p class="text-[10px] font-bold text-green/70 uppercase tracking-wide mb-2">+ Indemnités <span class="text-gray-400 font-normal normal-case">(issues du dossier agent)</span></p>
                            <div class="space-y-1.5">
                                @foreach([
                                    'Indemnité de Transport'  => $calc['indem_transp'],
                                    'Indemnité de Fonction'   => $calc['indem_fonction'],
                                    'Indemnité de Technicité' => $calc['indem_techn'],
                                ] as $label => $val)
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-600">{{ $label }}</span>
                                    <span class="text-xs font-semibold text-green">+ {{ number_format($val, 0, ',', ' ') }} FCFA</span>
                                </div>
                                @endforeach
                            </div>
                            <div class="flex items-center justify-between py-2 bg-green text-white rounded-xl px-3 mt-3">
                                <span class="text-sm font-bold uppercase tracking-wide">Salaire net à payer</span>
                                <span class="text-lg font-bold">{{ number_format($calc['salaire_net_a_payer'], 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-white flex items-center justify-between gap-3">

                    @if($this->canManagePersonnel)
                    <button wire:click="confirmDelete"
                            wire:confirm="Supprimer ce bulletin ?"
                            class="flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 text-sm font-semibold
                                   rounded-xl hover:bg-red-100 transition-colors border border-red-100">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                        </svg>
                        Supprimer
                    </button>
                    @endif

                    <div class="flex items-center gap-2">

                        {{--  Bouton Imprimer — ouvre la vue PDF dans un nouvel onglet --}}
                        @if(! $editMode)
                        <a href="{{ route('bulletins.print', $b->id) }}"
                           target="_blank"
                           class="flex items-center gap-2 px-4 py-2.5 bg-gray-50 text-gray-700 text-sm font-medium
                                  rounded-xl hover:bg-gray-100 transition-colors border border-gray-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"/>
                            </svg>
                            Imprimer
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
                            <button wire:click="update" wire:loading.attr="disabled" wire:target="update"
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

                        @if ($errors->any())
                            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">
                                <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5">
                                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                            {{-- Titre --}}
                            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-navy/8 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="font-semibold text-navy text-sm">Nouveau bulletin de salaire</h2>
                                    <p class="text-xs text-gray-400 mt-0.5">Rechercher l'agent puis saisir les retenues</p>
                                </div>
                            </div>

                            <div class="p-6 space-y-5">

                                {{-- Recherche agent --}}
                                <div class="p-4 bg-navy/4 border border-navy/10 rounded-xl">
                                    <p class="text-xs font-semibold text-navy/70 uppercase tracking-wide mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                        </svg>
                                        Rechercher l'agent par matricule
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

                                    @if($search_error)
                                        <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H4.645c-1.73 0-2.813-1.874-1.948-3.374l7.52-13.02c.866-1.5 3.032-1.5 3.898 0l4.942 8.567ZM12 15.75h.007v.008H12v-.008Z"/>
                                            </svg>
                                            {{ $search_error }}
                                        </p>
                                    @endif

                                    @if($agent_found)
                                        <div class="mt-3 p-3 bg-green/8 border border-green/20 rounded-xl">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-green/15 flex items-center justify-center shrink-0">
                                                    <svg class="w-4 h-4 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-navy">{{ $agent_nom_prenom }}</p>
                                                    <p class="text-[10px] text-gray-500 mt-0.5">
                                                        {{ $agent_fonction ?: 'Fonction non définie' }}
                                                        @if($agent_categorie) · Catégorie {{ $agent_categorie }} @endif
                                                    </p>
                                                </div>
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

                                {{-- Mois de paie --}}
                                <div>
                                    <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                        Mois de paie <span class="text-red-400">*</span>
                                    </label>
                                    <input type="month" wire:model="mois_paie"
                                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy
                                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all
                                                  @error('mois_paie') border-red-300 bg-red-50/30 @enderror">
                                    @error('mois_paie') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Retenues --}}
                                <div class="p-4 bg-red-50/40 border border-red-100 rounded-xl">
                                    <p class="text-xs font-semibold text-red-600/80 uppercase tracking-wide mb-4">Retenues (FCFA)</p>
                                    <div class="space-y-3">
                                        @foreach([
                                            'igr'                   => 'IGR',
                                            'contrib_nation'        => 'Contribution Nationale',
                                            'impot_salaire'         => 'Impôt sur salaire',
                                            'indem_transp_cotation' => 'Caisse de retraite (CNPS)',
                                        ] as $field => $label)
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wide mb-1">
                                                {{ $label }} <span class="text-red-400">*</span>
                                            </label>
                                            <div class="relative">
                                                <input type="number" wire:model="{{ $field }}" min="0" step="10"
                                                       placeholder="0"
                                                       class="w-full px-4 py-2 pr-14 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-200 transition-all
                                                              @error($field) border-red-300 @enderror">
                                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 font-medium">FCFA</span>
                                            </div>
                                            @error($field) <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                            {{-- Footer --}}
                            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-3">
                                <button wire:click="closeModal"
                                        class="px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
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
                                        Créer le bulletin
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
            </div>
        </div>
    </div>
    @endif

</div>
