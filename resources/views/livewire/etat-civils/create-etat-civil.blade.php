@php
    // Garde function_exists : la vue peut être rendue plusieurs fois dans la même requête.
    if (! function_exists('sexeBadge')) {
        function sexeBadge(string $s): string
        {
            return $s === 'M'
                ? 'bg-blue-50 text-blue-600 border border-blue-100'
                : 'bg-pink-50 text-pink-600 border border-pink-100';
        }
    }
@endphp

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
                    <h1 class="font-serif text-2xl font-bold leading-tight">Actes de naissance</h1>
                    <p class="text-white/60 text-sm mt-1">Enregistrement et consultation des extraits de naissance.</p>
                </div>
                <div class="shrink-0">
                    <button type="button" wire:click="openModal"
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
                       placeholder="Nom, prénom ou numéro d'acte…"
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl
                              text-sm text-navy placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
            </div>
            
            <div class="sm:w-32">
                <input type="number" wire:model.live="filtre_annee"
                       placeholder="Année"
                       class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-navy
                              focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
            </div>
        </div>

        {{-- ── Table ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fadeInUp">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Enfant</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">N° Acte</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Date naissance</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Commune</th>
                            <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Sexe</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($extraits as $e)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full {{ $e->sexe === 'M' ? 'bg-blue-50 text-blue-600' : 'bg-pink-50 text-pink-600' }}
                                                flex items-center justify-center text-xs font-bold shrink-0">
                                        {{ Str::upper(substr($e->nom_enfant ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="block font-semibold text-navy text-xs">
                                            {{ strtoupper($e->nom_enfant ?? '—') }} {{ $e->prenom_enfant }}
                                        </span>
                                        <span class="block text-[10px] text-gray-400 mt-0.5">{{ $e->lieux_naissance ?? '—' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <span class="font-mono text-xs font-medium text-navy">
                                    {{ $e->numero_complet_act_extrai ?? $e->numero_act_extrai ?? '—' }}
                                </span>
                                @if($e->annee_registre_extrai)
                                    <span class="block text-[10px] text-gray-400">{{ $e->annee_registre_extrai }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                @if($e->date_naissance)
                                    <span class="text-xs text-navy font-medium">
                                        {{ \Carbon\Carbon::parse($e->date_naissance)->locale('fr')->isoFormat('DD MMM YYYY') }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                <span class="text-xs text-gray-600">{{ $e->commune?->nom_commune ?? '—' }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                @if($e->sexe)
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold {{ sexeBadge($e->sexe) }}">
                                        {{ $e->sexe === 'M' ? '♂ Masculin' : '♀ Féminin' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <button wire:click="viewFiche({{ $e->id }})"
                                        class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center
                                               text-gray-400 hover:text-green hover:bg-green/10 transition-colors ml-auto">
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
                                <p class="text-gray-400 text-sm">Aucun acte de naissance enregistré.</p>
                                <button wire:click="openModal"
                                        class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-green hover:text-green/80 transition-colors">
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
            @if($extraits->hasPages())
                <div class="px-5 py-3 border-t border-gray-100">{{ $extraits->links() }}</div>
            @endif
        </div>

        <p class="text-center text-xs text-gray-400 pb-4">
            &copy; {{ date('Y') }} Mairie de Cocody — Système de Gestion Municipale
        </p>
    </div>


    {{-- ═══════════════════════════════════════════════════════
         MODAL FICHE EXTRAIT
    ═══════════════════════════════════════════════════════ --}}
    @if($showFicheModal && $selectedExtrait)
    @php $e = $selectedExtrait; @endphp
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeFicheModal"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative z-10 w-full max-w-3xl bg-white rounded-2xl shadow-2xl overflow-hidden">

                {{-- En-tête --}}
                <div class="bg-gradient-to-r from-[#1A6B3A] via-[#1d7a41] to-[#2d9b5a] px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl {{ $e->sexe === 'M' ? 'bg-blue-400/20' : 'bg-pink-400/20' }}
                                        flex items-center justify-center text-2xl font-bold shrink-0">
                                {{ Str::upper(substr($e->nom_enfant ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                @if($editMode)
                                    <div class="flex gap-2">
                                        <input type="text" wire:model="edit_nom_enfant"
                                               placeholder="NOM" style="text-transform:uppercase"
                                               class="bg-white/10 border border-white/20 rounded-xl px-3 py-1.5
                                                      text-white font-serif text-lg font-bold w-36
                                                      focus:outline-none focus:ring-2 focus:ring-white/30">
                                        <input type="text" wire:model="edit_prenom_enfant"
                                               placeholder="Prénom"
                                               class="bg-white/10 border border-white/20 rounded-xl px-3 py-1.5
                                                      text-white text-sm w-36
                                                      focus:outline-none focus:ring-2 focus:ring-white/30">
                                    </div>
                                @else
                                    <h2 class="font-serif text-xl font-bold">
                                        {{ strtoupper($e->nom_enfant ?? '—') }} {{ $e->prenom_enfant }}
                                    </h2>
                                @endif
                                <div class="flex items-center gap-3 mt-1.5">
                                    <span class="text-white/60 text-xs font-mono">
                                        N° {{ $e->numero_complet_act_extrai ?? $e->numero_act_extrai ?? '—' }}
                                    </span>
                                    @if($e->sexe)
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full
                                              {{ $e->sexe === 'M' ? 'bg-blue-400/20 text-blue-200' : 'bg-pink-400/20 text-pink-200' }}">
                                            {{ $e->sexe === 'M' ? '♂' : '♀' }} {{ $e->sexe === 'M' ? 'Masculin' : 'Féminin' }}
                                        </span>
                                    @endif
                                    {{-- Badge nombre de mentions --}}
                                    @php $nbMentions = $mentionsExtrait->count(); @endphp
                                    @if($nbMentions > 0)
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-white/15 text-white">
                                            {{ $nbMentions }} mention{{ $nbMentions > 1 ? 's' : '' }}
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

                {{-- Flash fiche --}}
                @if(session()->has('success_fiche'))
                    <div class="mx-6 mt-4 p-3 bg-green/10 border border-green/20 text-green text-xs font-medium rounded-xl flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                        {{ session('success_fiche') }}
                    </div>
                @endif
                @if($editMode && $errors->any())
                    <div class="mx-6 mt-4 p-3 bg-red-50 border border-red-200 rounded-xl">
                        <ul class="text-xs text-red-600 space-y-0.5 list-disc list-inside">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div class="max-h-[70vh] overflow-y-auto">
                    <div class="p-6 space-y-5">

                        {{-- ═══ VUE CONSULTATION ═══ --}}
                        @if(! $editMode)

                            {{-- Registre --}}
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach([
                                    'Commune'      => $e->commune?->nom_commune ?? '—',
                                    'Centre É.C.'  => $e->centr_etat_civil ?? '—',
                                    'Année'        => $e->annee_registre_extrai ?? '—',
                                    'N° Registre'  => $e->numero_registre_extrai ?? '—',
                                    'Nature décl.' => $e->nature_declarat_extrai ?? '—',
                                    'N° Acte'      => $e->numero_act_extrai ?? '—',
                                ] as $label => $val)
                                <div class="bg-gray-50 rounded-xl border border-gray-100 p-3">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">{{ $label }}</p>
                                    <p class="text-xs font-semibold text-navy">{{ $val }}</p>
                                </div>
                                @endforeach
                            </div>

                            {{-- Officier & Dates --}}
                            <div class="bg-gray-50 rounded-xl border border-gray-100 p-4">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">Officier & Dates</p>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                                    <div><span class="text-gray-400">Officier :</span> <span class="font-medium text-navy">{{ $e->officier_etat_civil ?? '—' }}</span></div>
                                    <div><span class="text-gray-400">Qualité :</span> <span class="font-medium text-navy">{{ $e->qualite ?? '—' }}</span></div>
                                    <div><span class="text-gray-400">Signé par :</span> <span class="font-medium text-navy">{{ $e->nous_avons_signer ?? '—' }}</span></div>
                                    <div><span class="text-gray-400">Date dressage :</span> <span class="font-medium text-navy">{{ $e->date_dressage ? $e->date_dressage->locale('fr')->isoFormat('DD MMM YYYY') : '—' }}</span></div>
                                    <div><span class="text-gray-400">Heure :</span> <span class="font-medium text-navy">{{ $e->heure_dressage ?? '—' }}</span></div>
                                    <div><span class="text-gray-400">Copie intégrale :</span> <span class="font-medium text-navy">{{ $e->date_dressage_copie_integrale ? $e->date_dressage_copie_integrale->locale('fr')->isoFormat('DD MMM YYYY') : '—' }}</span></div>
                                </div>
                            </div>

                            {{-- Enfant --}}
                            <div class="bg-green/5 rounded-xl border border-green/15 p-4">
                                <p class="text-[10px] font-bold text-green/70 uppercase tracking-wide mb-3">Enfant</p>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                                    <div class="sm:col-span-2"><span class="text-gray-400">Date de naissance :</span> <span class="font-semibold text-navy">{{ $e->date_naissance ? $e->date_naissance->locale('fr')->isoFormat('DD MMMM YYYY') : '—' }}</span></div>
                                    <div><span class="text-gray-400">Heure :</span> <span class="font-medium text-navy">{{ $e->heure_min_naissance ?? '—' }}</span></div>
                                    <div class="sm:col-span-2"><span class="text-gray-400">Lieu :</span> <span class="font-medium text-navy">{{ $e->lieux_naissance ?? '—' }}</span></div>
                                    <div><span class="text-gray-400">Fils/Fille de :</span> <span class="font-medium text-navy capitalize">{{ $e->fils_fille ?? '—' }}</span></div>
                                    @if($e->date_naissance_lettre)
                                        <div class="sm:col-span-3"><span class="text-gray-400">En lettres :</span> <span class="font-medium text-navy italic">{{ $e->date_naissance_lettre }}</span></div>
                                    @endif
                                </div>
                            </div>

                            {{-- Père / Mère --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-xl border border-gray-100 p-4">
                                    <p class="text-[10px] font-bold text-navy/60 uppercase tracking-wide mb-3">Père</p>
                                    <div class="space-y-1.5 text-xs">
                                        <div><span class="text-gray-400">Nom :</span> <span class="font-semibold text-navy">{{ $e->nom_prenom_pere ?? '—' }}</span></div>
                                        <div><span class="text-gray-400">Né en :</span> <span class="font-medium text-navy">{{ $e->annee_naissance_pere ?? '—' }}</span></div>
                                        <div><span class="text-gray-400">Profession :</span> <span class="font-medium text-navy">{{ $e->profession_pere ?? '—' }}</span></div>
                                        <div><span class="text-gray-400">Nationalité :</span> <span class="font-medium text-navy">{{ $e->nationnalite_pere ?? '—' }}</span></div>
                                        <div><span class="text-gray-400">Domicile :</span> <span class="font-medium text-navy">{{ $e->domicile_pere ?? '—' }}</span></div>
                                        <div><span class="text-gray-400">Pièce :</span> <span class="font-medium text-navy">{{ $e->nature_piece_pere ?? '—' }}</span></div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-xl border border-gray-100 p-4">
                                    <p class="text-[10px] font-bold text-navy/60 uppercase tracking-wide mb-3">Mère</p>
                                    <div class="space-y-1.5 text-xs">
                                        <div><span class="text-gray-400">Nom :</span> <span class="font-semibold text-navy">{{ $e->nom_prenom_mere ?? '—' }}</span></div>
                                        <div><span class="text-gray-400">Née en :</span> <span class="font-medium text-navy">{{ $e->annee_naissance_mere ?? '—' }}</span></div>
                                        <div><span class="text-gray-400">Profession :</span> <span class="font-medium text-navy">{{ $e->profession_mere ?? '—' }}</span></div>
                                        <div><span class="text-gray-400">Nationalité :</span> <span class="font-medium text-navy">{{ $e->nationalite_mere ?? '—' }}</span></div>
                                        <div><span class="text-gray-400">Domicile :</span> <span class="font-medium text-navy">{{ $e->domicile_mere ?? '—' }}</span></div>
                                        <div><span class="text-gray-400">Pièce :</span> <span class="font-medium text-navy">{{ $e->nature_piece_mere ?? '—' }}</span></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Déclarant & Témoins --}}
                            @if($e->info_declarant || $e->info_temoin_1 || $e->info_temoin_2)
                            <div class="bg-gray-50 rounded-xl border border-gray-100 p-4">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">Déclarant & Témoins</p>
                                <div class="space-y-1.5 text-xs">
                                    @if($e->info_declarant) <div><span class="text-gray-400">Déclarant :</span> <span class="font-medium text-navy">{{ $e->info_declarant }}</span></div> @endif
                                    @if($e->info_temoin_1)  <div><span class="text-gray-400">Témoin 1 :</span>  <span class="font-medium text-navy">{{ $e->info_temoin_1 }}</span></div>  @endif
                                    @if($e->info_temoin_2)  <div><span class="text-gray-400">Témoin 2 :</span>  <span class="font-medium text-navy">{{ $e->info_temoin_2 }}</span></div>  @endif
                                </div>
                            </div>
                            @endif

                            {{-- ═══ SECTION MENTIONS ═══ --}}
                            <div class="pt-2">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-sm font-bold text-navy flex items-center gap-2">
                                        <svg class="w-4 h-4 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
                                        </svg>
                                        Mentions marginales
                                        @if($mentionsExtrait->count() > 0)
                                            <span class="bg-green/10 text-green text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                {{ $mentionsExtrait->count() }}
                                            </span>
                                        @endif
                                    </h3>
                                    <button wire:click="openMentionForm()"
                                            class="flex items-center gap-1.5 px-3 py-1.5 bg-green text-white text-xs font-semibold rounded-xl
                                                   hover:bg-green/90 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                        </svg>
                                        Ajouter une mention
                                    </button>
                                </div>

                                {{-- Liste des mentions --}}
                                @if($mentionsExtrait->isEmpty())
                                    <div class="text-center py-6 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                        <p class="text-xs text-gray-400">Aucune mention enregistrée sur cet acte.</p>
                                    </div>
                                @else
                                    <div class="space-y-3">
                                        @foreach($mentionsExtrait as $m)
                                        <div class="bg-green/4 border border-green/15 rounded-xl overflow-hidden">
                                            <div class="flex items-start gap-3 p-4">
                                                <div class="w-8 h-8 rounded-lg bg-green/10 flex items-center justify-center shrink-0 mt-0.5">
                                                    <svg class="w-4 h-4 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0 text-xs space-y-1">
                                                    @if($m->nom_prenom_conjoint_mention)
                                                        <p><span class="text-gray-400">Conjoint :</span> <span class="font-semibold text-navy">{{ $m->nom_prenom_conjoint_mention }}</span></p>
                                                    @endif
                                                    @if($m->date_mariage_mention)
                                                        <p><span class="text-gray-400">Mariage le :</span> <span class="font-medium text-navy">{{ $m->date_mariage_mention->locale('fr')->isoFormat('DD MMM YYYY') }}</span>
                                                        @if($m->lieu_mariage_mention) <span class="text-gray-400">à</span> <span class="font-medium text-navy">{{ $m->lieu_mariage_mention }}</span> @endif</p>
                                                    @endif
                                                    @if($m->date_mariage_dissous)
                                                        <p><span class="text-gray-400">Dissous le :</span> <span class="font-medium text-navy">{{ $m->date_mariage_dissous->locale('fr')->isoFormat('DD MMM YYYY') }}</span>
                                                        @if($m->ref_act_dissous) — <span class="font-mono text-navy/70 text-[10px]">{{ $m->ref_act_dissous }}</span> @endif</p>
                                                    @endif
                                                    @if($m->date_deces_mention)
                                                        <p><span class="text-gray-400">Décès le :</span> <span class="font-medium text-red-600">{{ $m->date_deces_mention->locale('fr')->isoFormat('DD MMM YYYY') }}</span>
                                                        @if($m->lieu_deces_mention) <span class="text-gray-400">à</span> <span class="font-medium text-navy">{{ $m->lieu_deces_mention }}</span> @endif</p>
                                                    @endif
                                                    @foreach([
                                                        'Reconnaissance' => $m->mention_reconnaissance,
                                                        'Rectification'  => $m->mention_rectification,
                                                        'Adoption'       => $m->mention_adoption,
                                                        'Rétablissement' => $m->mention_retablissement,
                                                    ] as $label => $val)
                                                        @if($val)
                                                            <p><span class="font-bold text-green/80 uppercase text-[10px]">{{ $label }} :</span> <span class="text-navy">{{ $val }}</span></p>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="flex items-center gap-1.5 shrink-0">
                                                    <button wire:click="openMentionForm({{ $m->id }})"
                                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-navy/8 text-navy hover:bg-navy/15 transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                                                        </svg>
                                                    </button>
                                                    <button wire:click="deleteMention({{ $m->id }})"
                                                            wire:confirm="Supprimer cette mention ?"
                                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-600 transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Formulaire ajout/édition mention (inline) --}}
                                @if($showMentionForm)
                                <div class="mt-4 bg-navy/4 border border-navy/15 rounded-2xl overflow-hidden">
                                    <div class="px-5 py-3 border-b border-navy/10 bg-navy/5 flex items-center justify-between">
                                        <p class="text-sm font-semibold text-navy">
                                            {{ $editingMentionId ? 'Modifier la mention' : 'Nouvelle mention' }}
                                        </p>
                                        <button wire:click="closeMentionForm"
                                                class="text-xs text-gray-400 hover:text-navy flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                            </svg>
                                            Annuler
                                        </button>
                                    </div>
                                    <div class="p-5 space-y-4">
                                        {{-- Mariage --}}
                                        <div class="p-3 bg-white rounded-xl border border-gray-100">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">Mariage</p>
                                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                                <div>
                                                    <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Conjoint</label>
                                                    <input type="text" wire:model="m_nom_prenom_conjoint_mention" placeholder="Nom et prénoms"
                                                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-navy placeholder-gray-400
                                                                  focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Date de mariage</label>
                                                    <input type="date" wire:model="m_date_mariage_mention"
                                                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-navy
                                                                  focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Lieu</label>
                                                    <input type="text" wire:model="m_lieu_mariage_mention" placeholder="Lieu du mariage"
                                                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-navy placeholder-gray-400
                                                                  focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Dissolution --}}
                                        <div class="p-3 bg-white rounded-xl border border-gray-100">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">Dissolution du mariage</p>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Date dissolution</label>
                                                    <input type="date" wire:model="m_date_mariage_dissous"
                                                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-navy
                                                                  focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Réf. acte dissous</label>
                                                    <input type="text" wire:model="m_ref_act_dissous" placeholder="Référence de l'acte"
                                                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-navy placeholder-gray-400
                                                                  focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Décès --}}
                                        <div class="p-3 bg-white rounded-xl border border-gray-100">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">Décès</p>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Date de décès</label>
                                                    <input type="date" wire:model="m_date_deces_mention"
                                                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-navy
                                                                  focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Lieu de décès</label>
                                                    <input type="text" wire:model="m_lieu_deces_mention" placeholder="Lieu du décès"
                                                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-navy placeholder-gray-400
                                                                  focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Autres mentions --}}
                                        <div class="p-3 bg-white rounded-xl border border-gray-100">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">Autres mentions</p>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                @foreach([
                                                    'm_mention_reconnaissance' => 'Reconnaissance',
                                                    'm_mention_rectification'  => 'Rectification',
                                                    'm_mention_adoption'       => 'Adoption',
                                                    'm_mention_retablissement' => 'Rétablissement',
                                                ] as $field => $label)
                                                <div>
                                                    <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wide mb-1">{{ $label }}</label>
                                                    <textarea wire:model="{{ $field }}" rows="2" placeholder="Détails…"
                                                              class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-navy placeholder-gray-400
                                                                     focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 resize-none"></textarea>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="flex justify-end">
                                            <button wire:click="saveMention"
                                                    wire:loading.attr="disabled" wire:target="saveMention"
                                                    class="flex items-center gap-2 px-5 py-2.5 bg-green text-white text-sm font-semibold rounded-xl
                                                           hover:bg-green/90 transition-colors shadow-sm disabled:opacity-60">
                                                <span wire:loading.remove wire:target="saveMention" class="flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                    </svg>
                                                    {{ $editingMentionId ? 'Modifier' : 'Ajouter la mention' }}
                                                </span>
                                                <span wire:loading wire:target="saveMention" class="flex items-center gap-2">
                                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                    </svg>
                                                    Enregistrement…
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                        {{-- ═══ VUE ÉDITION ═══ --}}
                        @else
                            {{-- Formulaire d'édition compact --}}
                            <div class="space-y-4">
                                {{-- Commune + Registre --}}
                                <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">Registre</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Commune <span class="text-red-400">*</span></label>
                                            <select wire:model="edit_commune_id"
                                                    class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs text-navy appearance-none
                                                           focus:outline-none focus:ring-2 focus:ring-green/20 @error('edit_commune_id') border-red-300 @enderror">
                                                <option value="">— Sélectionner —</option>
                                                @foreach($communes as $c)
                                                    <option value="{{ $c->id }}">{{ $c->nom_commune }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">N° Acte <span class="text-red-400">*</span></label>
                                            <input type="text" wire:model="edit_numero_act_extrai"
                                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-green/20 @error('edit_numero_act_extrai') border-red-300 @enderror">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Année</label>
                                            <input type="number" wire:model="edit_annee_registre_extrai"
                                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-green/20">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Centre É.C.</label>
                                            <input type="text" wire:model="edit_centr_etat_civil"
                                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-green/20">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">N° complet acte</label>
                                            <input type="text" wire:model="edit_numero_complet_act_extrai"
                                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-green/20">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date dressage <span class="text-red-400">*</span></label>
                                            <input type="date" wire:model="edit_date_dressage"
                                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-green/20 @error('edit_date_dressage') border-red-300 @enderror">
                                        </div>
                                    </div>
                                </div>

                                {{-- Enfant --}}
                                <div class="p-4 bg-green/5 border border-green/15 rounded-xl">
                                    <p class="text-[10px] font-bold text-green/70 uppercase tracking-wide mb-3">Enfant</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Nom <span class="text-red-400">*</span></label>
                                            <input type="text" wire:model="edit_nom_enfant" style="text-transform:uppercase"
                                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-green/20 @error('edit_nom_enfant') border-red-300 @enderror">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Prénom <span class="text-red-400">*</span></label>
                                            <input type="text" wire:model="edit_prenom_enfant"
                                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-green/20 @error('edit_prenom_enfant') border-red-300 @enderror">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date naissance <span class="text-red-400">*</span></label>
                                            <input type="date" wire:model="edit_date_naissance"
                                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-green/20 @error('edit_date_naissance') border-red-300 @enderror">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Sexe <span class="text-red-400">*</span></label>
                                            <div class="flex gap-2">
                                                @foreach(['M' => 'Masculin', 'F' => 'Féminin'] as $val => $label)
                                                <label class="flex-1 flex items-center justify-center py-1.5 border rounded-xl cursor-pointer text-[10px] font-medium transition-all
                                                             {{ $edit_sexe === $val
                                                                ? ($val === 'M' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-pink-50 text-pink-600 border-pink-200')
                                                                : 'bg-white text-gray-500 border-gray-200' }}">
                                                    <input type="radio" wire:model.live="edit_sexe" value="{{ $val }}" class="sr-only">
                                                    {{ $label }}
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Lieu naissance</label>
                                            <input type="text" wire:model="edit_lieux_naissance"
                                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-green/20">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Heure</label>
                                            <input type="text" wire:model="edit_heure_min_naissance" placeholder="ex : 14h30"
                                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-green/20">
                                        </div>
                                    </div>
                                </div>

                                {{-- Père / Mère --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach(['père' => ['nom_prenom_pere','nationnalite_pere','profession_pere','domicile_pere'], 'mère' => ['nom_prenom_mere','nationalite_mere','profession_mere','domicile_mere']] as $parent => $fields)
                                    <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">{{ ucfirst($parent) }}</p>
                                        <div class="space-y-2">
                                            @foreach([
                                                'nom_prenom_'     . ($parent === 'père' ? 'pere' : 'mere') => 'Nom',
                                                ($parent === 'père' ? 'nationnalite_pere' : 'nationalite_mere') => 'Nationalité',
                                                'profession_' . ($parent === 'père' ? 'pere' : 'mere') => 'Profession',
                                                'domicile_' . ($parent === 'père' ? 'pere' : 'mere') => 'Domicile',
                                            ] as $field => $label)
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-0.5">{{ $label }}</label>
                                                <input type="text" wire:model="edit_{{ $field }}"
                                                       {{ str_contains($field, 'nom_prenom') ? 'style=text-transform:uppercase' : '' }}
                                                       class="w-full px-3 py-1.5 bg-white border border-gray-200 rounded-xl text-xs text-navy
                                                              focus:outline-none focus:ring-2 focus:ring-green/20">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- Déclarant --}}
                                <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-3">Déclarant & Témoins</p>
                                    <div class="space-y-2">
                                        @foreach(['edit_info_declarant' => 'Déclarant', 'edit_info_temoin_1' => 'Témoin 1', 'edit_info_temoin_2' => 'Témoin 2'] as $field => $label)
                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-0.5">{{ $label }}</label>
                                            <input type="text" wire:model="{{ $field }}"
                                                   class="w-full px-3 py-1.5 bg-white border border-gray-200 rounded-xl text-xs text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-green/20">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- Footer fiche --}}
                {{-- Footer — 2 lignes : impression + actions --}}
                <div class="border-t border-gray-100 bg-white">

                    {{-- Ligne 1 : boutons impression (visible uniquement en mode consultation) --}}
                    @if(! $editMode)
                    <div class="px-6 py-3 border-b border-gray-50 flex items-center gap-2 flex-wrap bg-gray-50/50">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mr-1">Imprimer :</span>

                        {{-- Extrait de naissance --}}
                        <a href="{{ route('naissances.print.extrait', $selectedExtrait->id) }}"
                           target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#1A6B3A]/8 text-[#1A6B3A] text-xs font-semibold
                                  rounded-xl border border-[#1A6B3A]/20 hover:bg-[#1A6B3A]/15 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                            </svg>
                            Extrait
                        </a>

                        {{-- Copie intégrale --}}
                        <a href="{{ route('naissances.print.copie', $selectedExtrait->id) }}"
                           target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-navy/8 text-navy text-xs font-semibold
                                  rounded-xl border border-navy/15 hover:bg-navy/15 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75"/>
                            </svg>
                            Copie intégrale
                        </a>

                        {{-- Copie intégrale jugement supplétif --}}
                        <a href="{{ route('naissances.print.jugement', $selectedExtrait->id) }}"
                           target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gold/10 text-gold text-xs font-semibold
                                  rounded-xl border border-gold/20 hover:bg-gold/20 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z"/>
                            </svg>
                            C.I. Jugement supplétif
                        </a>

                        {{-- Copie intégrale requisition --}}

                        <a href="{{ route('naissances.print.requisition', $selectedExtrait->id) }}"
                           target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gold/10 text-gold text-xs font-semibold
                                  rounded-xl border border-gold/20 hover:bg-gold/20 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z"/>
                            </svg>
                            C.I. Requisition
                        </a>
                    </div>
                    @endif

                    {{-- Ligne 2 : supprimer + modifier --}}
                    <div class="px-6 py-3.5 flex items-center justify-between gap-3">
                        <button wire:click="confirmDelete"
                                wire:confirm="Supprimer cet acte et toutes ses mentions ? Action irréversible."
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
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                    </svg>
                                    Annuler
                                </button>
                                <button wire:click="update"
                                        wire:loading.attr="disabled" wire:target="update"
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
    </div>
    @endif


    {{-- ═══════════════════════════════════════════════════════
         MODAL CRÉATION — 6 ÉTAPES
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
                                                    'bg-green text-white shadow-md shadow-green/30' => $i === $step,
                                                    'bg-green/20 text-green cursor-pointer hover:bg-green/30' => $i < $step,
                                                    'bg-gray-100 text-gray-400 cursor-default'         => $i > $step,
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
                                            'text-green'     => $i <= $step,
                                            'text-gray-400'  => $i > $step,
                                        ])>{{ $this->stepLabel($i) }}</span>
                                    </div>
                                    @if($i < $maxSteps)
                                        <div @class(['h-0.5 flex-1 mx-0.5 transition-all duration-500', 'bg-green/40' => $i < $step, 'bg-gray-200' => $i >= $step])></div>
                                    @endif
                                @endfor
                            </div>
                        </div>

                        {{-- Message de validation (Succès form) --}}
                        @if(session()->has('form_success'))
                            <div class="mb-4 p-4 bg-green/10 border border-green/20 rounded-xl flex flex-col items-center justify-center text-center animate-fadeInUp">
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mb-2 shadow-sm text-green">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                </div>
                                <h3 class="text-green font-bold text-lg mb-1">Opération réussie !</h3>
                                <p class="text-sm text-green/80">{{ session('form_success') }}</p>
                            </div>
                        @endif

                        {{-- Erreurs --}}
                        @if($errors->any())
                            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl">
                                <ul class="text-xs text-red-600 space-y-0.5 list-disc list-inside">
                                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Card formulaire --}}
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                            {{-- Titre step --}}
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-green/8 flex items-center justify-center shrink-0 text-green font-bold text-sm">
                                    {{ $step }}
                                </div>
                                <div>
                                    <h2 class="font-semibold text-navy text-sm">{{ $this->stepLabel($step) }}</h2>
                                    <p class="text-xs text-gray-400 mt-0.5">Étape {{ $step }} sur {{ $maxSteps }}</p>
                                </div>
                            </div>

                            {{-- ══ ÉTAPE 1 — Commune & Registre ══ --}}
                            @if($step === 1)
                            <div class="p-6 space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                        Commune <span class="text-red-400">*</span>
                                    </label>
                                    <select wire:model="commune_id"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                   focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all
                                                   @error('commune_id') border-red-300 bg-red-50/30 @enderror">
                                        <option value="">— Sélectionner la commune —</option>
                                        @foreach($communes as $c)
                                            <option value="{{ $c->id }}">{{ $c->nom_commune }}</option>
                                        @endforeach
                                    </select>
                                    @error('commune_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Centre d'État Civil</label>
                                        <input type="text" wire:model="centr_etat_civil" placeholder="ex : Centre de Kouassi"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Année du registre <span class="text-red-400">*</span>
                                        </label>
                                        <input type="number" wire:model="annee_registre_extrai" min="1900" :max="{{ date('Y') + 1 }}"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all
                                                      @error('annee_registre_extrai') border-red-300 @enderror">
                                        @error('annee_registre_extrai') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Nature de la déclaration</label>
                                        <select wire:model="nature_declarat_extrai"
                                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                       focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                            <option value="">— Sélectionner —</option>
                                            <option value="Régulier">Régulier</option>
                                            <option value="Hors Délais">Hors Délais</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">N° Registre</label>
                                        <input type="text" wire:model="numero_registre_extrai" placeholder="ex : 001"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            N° Acte <span class="text-red-400">*</span>
                                        </label>
                                        <input type="text" wire:model="numero_act_extrai" placeholder="ex : 042"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all
                                                      @error('numero_act_extrai') border-red-300 bg-red-50/30 @enderror">
                                        @error('numero_act_extrai') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">N° Complet de l'acte</label>
                                        <input type="text" wire:model="numero_complet_act_extrai" placeholder="ex : 042/2026"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- ══ ÉTAPE 2 — Officier & Dates ══ --}}
                            @if($step === 2)
                            <div class="p-6 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Officier d'État Civil</label>
                                        <input type="text" wire:model="officier_etat_civil" placeholder="Nom de l'officier"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Qualité</label>
                                        <input type="text" wire:model="qualite" placeholder="ex : Sous-Préfet, Maire…"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Nous avons signé</label>
                                        <input type="text" wire:model="nous_avons_signer" placeholder="Nom du signataire"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Date de dressage <span class="text-red-400">*</span>
                                        </label>
                                        <input type="date" wire:model="date_dressage"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all
                                                      @error('date_dressage') border-red-300 bg-red-50/30 @enderror">
                                        @error('date_dressage') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Heure de dressage</label>
                                        <input type="text" wire:model="heure_dressage" placeholder="ex : 10h30"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Date copie intégrale</label>
                                        <input type="date" wire:model="date_dressage_copie_integrale"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- ══ ÉTAPE 3 — Enfant ══ --}}
                            @if($step === 3)
                            <div class="p-6 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Nom <span class="text-red-400">*</span>
                                        </label>
                                        <input type="text" wire:model="nom_enfant" placeholder="NOM" style="text-transform:uppercase"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all
                                                      @error('nom_enfant') border-red-300 bg-red-50/30 @enderror">
                                        @error('nom_enfant') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Prénom(s) <span class="text-red-400">*</span>
                                        </label>
                                        <input type="text" wire:model="prenom_enfant" placeholder="Prénom(s)"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all
                                                      @error('prenom_enfant') border-red-300 bg-red-50/30 @enderror">
                                        @error('prenom_enfant') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Sexe <span class="text-red-400">*</span>
                                        </label>
                                        <div class="flex gap-3">
                                            @foreach(['M' => '♂ Masculin', 'F' => '♀ Féminin'] as $val => $label)
                                            <label class="flex-1 flex items-center justify-center py-2.5 border rounded-xl cursor-pointer text-sm font-medium transition-all
                                                         {{ $sexe === $val
                                                            ? ($val === 'M' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-pink-50 text-pink-600 border-pink-200')
                                                            : 'bg-gray-50 text-gray-500 border-gray-200 hover:border-green/30' }}">
                                                <input type="radio" wire:model.live="sexe" value="{{ $val }}" class="sr-only">
                                                {{ $label }}
                                            </label>
                                            @endforeach
                                        </div>
                                        @error('sexe') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Fils / Fille de</label>
                                        <input type="text" wire:model="fils_fille" placeholder="fils / fille"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                            Date de naissance <span class="text-red-400">*</span>
                                        </label>
                                        <input type="date" wire:model="date_naissance"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all
                                                      @error('date_naissance') border-red-300 bg-red-50/30 @enderror">
                                        @error('date_naissance') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Heure de naissance</label>
                                        <input type="text" wire:model="heure_min_naissance" placeholder="ex : 14h30"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Lieu de naissance</label>
                                        <input type="text" wire:model="lieux_naissance" placeholder="Ville, village…"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Date de naissance en toutes lettres</label>
                                        <input type="text" wire:model="date_naissance_lettre"
                                               placeholder="ex : le vingt-deux mars deux mille vingt-six"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- ══ ÉTAPE 4 — Père ══ --}}
                            @if($step === 4)
                            <div class="p-6 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Nom et Prénoms du père</label>
                                        <input type="text" wire:model="nom_prenom_pere" placeholder="NOM Prénom(s)" style="text-transform:uppercase"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Date de naissance</label>
                                        <input type="date" wire:model="date_naissance_pere"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Année de naissance</label>
                                        <input type="number" wire:model="annee_naissance_pere" placeholder="ex : 1975"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Lieu de naissance</label>
                                        <input type="text" wire:model="lieu_naissance_pere" placeholder="Ville ou village"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Profession</label>
                                        <input type="text" wire:model="profession_pere" placeholder="ex : Commerçant"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Nationalité</label>
                                        <input type="text" wire:model="nationnalite_pere" placeholder="ex : Ivoirienne"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Domicile</label>
                                        <input type="text" wire:model="domicile_pere" placeholder="Adresse"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Nature de la pièce</label>
                                        <input type="text" wire:model="nature_piece_pere" placeholder="ex : CNI, Passeport…"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- ══ ÉTAPE 5 — Mère ══ --}}
                            @if($step === 5)
                            <div class="p-6 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Nom et Prénoms de la mère</label>
                                        <input type="text" wire:model="nom_prenom_mere" placeholder="NOM Prénom(s)" style="text-transform:uppercase"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Date de naissance</label>
                                        <input type="date" wire:model="date_naissance_mere"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Année de naissance</label>
                                        <input type="number" wire:model="annee_naissance_mere" placeholder="ex : 1980"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Profession</label>
                                        <input type="text" wire:model="profession_mere" placeholder="ex : Ménagère"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Nationalité</label>
                                        <input type="text" wire:model="nationalite_mere" placeholder="ex : Ivoirienne"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Domicile</label>
                                        <input type="text" wire:model="domicile_mere" placeholder="Adresse"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Nature de la pièce</label>
                                        <input type="text" wire:model="nature_piece_mere" placeholder="ex : CNI, Passeport…"
                                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all">
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- ══ ÉTAPE 6 — Déclarant, Témoins & Mentions ══ --}}
                            @if($step === 6)
                            <div class="p-6 space-y-5">
                                {{-- Déclarant & Témoins --}}
                                <div class="space-y-3">
                                    @foreach(['info_declarant' => 'Informations du déclarant', 'info_temoin_1' => 'Informations du témoin 1', 'info_temoin_2' => 'Informations du témoin 2'] as $field => $label)
                                    <div>
                                        <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">{{ $label }}</label>
                                        <textarea wire:model="{{ $field }}" rows="2"
                                                  placeholder="Nom, prénom, âge, profession, domicile…"
                                                  class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                         focus:outline-none focus:ring-2 focus:ring-green/20 focus:border-green/30 transition-all resize-none"></textarea>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- Mentions --}}
                                <div class="pt-2 border-t border-gray-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-sm font-bold text-navy flex items-center gap-2">
                                            <svg class="w-4 h-4 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
                                            </svg>
                                            Mentions marginales
                                            @if(count($mentions) > 0)
                                                <span class="bg-green/10 text-green text-[10px] font-bold px-2 py-0.5 rounded-full">{{ count($mentions) }}</span>
                                            @endif
                                        </h3>
                                        <button type="button" wire:click="ajouterMentionListe"
                                                class="flex items-center gap-1.5 px-3 py-1.5 bg-green text-white text-xs font-semibold rounded-xl hover:bg-green/90 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                            </svg>
                                            Ajouter une mention
                                        </button>
                                    </div>

                                    @if(count($mentions) === 0)
                                        <div class="text-center py-5 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                            <p class="text-xs text-gray-400">Aucune mention pour le moment. Vous pourrez en ajouter après enregistrement.</p>
                                        </div>
                                    @else
                                        <div class="space-y-4">
                                            @foreach($mentions as $mi => $m)
                                            <div class="bg-green/4 border border-green/15 rounded-xl p-4">
                                                <div class="flex items-center justify-between mb-3">
                                                    <p class="text-xs font-bold text-green">Mention {{ $mi + 1 }}</p>
                                                    <button type="button" wire:click="supprimerMentionListe({{ $mi }})"
                                                            class="w-6 h-6 flex items-center justify-center rounded-lg bg-red-50 text-red-400 hover:bg-red-100 transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                                    @foreach([
                                                        'nom_prenom_conjoint_mention' => 'Conjoint',
                                                        'date_mariage_mention'        => 'Date mariage',
                                                        'lieu_mariage_mention'        => 'Lieu mariage',
                                                        'date_mariage_dissous'        => 'Date dissolution',
                                                        'ref_act_dissous'             => 'Réf. acte dissous',
                                                        'date_deces_mention'          => 'Date décès',
                                                        'lieu_deces_mention'          => 'Lieu décès',
                                                        'mention_reconnaissance'      => 'Reconnaissance',
                                                        'mention_adoption'            => 'Adoption',
                                                    ] as $mField => $mLabel)
                                                    <div>
                                                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-0.5">{{ $mLabel }}</label>
                                                        @if(in_array($mField, ['date_mariage_mention', 'date_mariage_dissous', 'date_deces_mention']))
                                                            <input type="date" wire:model="mentions.{{ $mi }}.{{ $mField }}"
                                                                   class="w-full px-3 py-1.5 bg-white border border-gray-200 rounded-xl text-xs text-navy
                                                                          focus:outline-none focus:ring-2 focus:ring-green/20">
                                                        @else
                                                            <input type="text" wire:model="mentions.{{ $mi }}.{{ $mField }}"
                                                                   class="w-full px-3 py-1.5 bg-white border border-gray-200 rounded-xl text-xs text-navy placeholder-gray-400
                                                                          focus:outline-none focus:ring-2 focus:ring-green/20">
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    @endif
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
                                            class="flex items-center gap-2 px-6 py-2.5 bg-green text-white text-sm font-semibold rounded-xl
                                                   hover:bg-green/90 transition-colors shadow-sm shadow-green/20 disabled:opacity-60">
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
                                                   hover:bg-green/90 transition-colors shadow-sm shadow-green/20 disabled:opacity-60">
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
