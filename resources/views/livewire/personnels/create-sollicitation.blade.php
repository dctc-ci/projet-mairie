@php
function etatBadge(string $etat): string {
return match($etat) {
'approuvee' => 'bg-green/10 text-green',
'rejetee' => 'bg-red-50 text-red-500',
'annulee' => 'bg-gray-100 text-gray-500',
default => 'bg-gold/10 text-gold',
};
}
function etatLabel(string $etat): string {
return match($etat) {
'en_attente' => 'En attente',
'approuvee' => 'Approuvée',
'rejetee' => 'Rejetée',
'annulee' => 'Annulée',
default => $etat,
};
}
@endphp

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
                    <h1 class="font-serif text-2xl font-bold leading-tight">Sollicitations</h1>
                    <p class="text-white/60 text-sm mt-1">Gérez les congés, absences, accidents et demandes du
                        personnel.</p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    {{-- Bouton consulter fiche agent --}}
                    <button wire:click="openFicheModal" class="inline-flex items-center gap-2 px-4 py-2.5
                                   bg-white/10 text-white text-sm font-medium rounded-xl
                                   hover:bg-white/20 transition-colors border border-white/20">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Fiche agent
                    </button>
                    <button wire:click="openModal" class="inline-flex items-center gap-2 px-5 py-2.5
                                   bg-gold text-navy text-sm font-semibold rounded-xl
                                   hover:bg-yellow-400 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Nouvelle sollicitation
                    </button>
                </div>
            </div>
            <div
                class="absolute -right-12 -top-12 w-48 h-48 rounded-full border-[28px] border-white/5 pointer-events-none">
            </div>
            <div
                class="absolute right-16 -bottom-8 w-28 h-28 rounded-full border-[14px] border-white/5 pointer-events-none">
            </div>
            <div class="absolute right-6 top-6 w-10 h-10 rounded-full bg-gold/20 pointer-events-none"></div>
        </div>

        {{-- ── Messages flash ── --}}
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
        @if (session()->has('error'))
        <div
            class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 font-medium text-sm flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
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
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                Agent / Personnel</th>
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">
                                Type</th>
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">
                                Période</th>
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                État</th>
                            <th
                                class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                Justification</th>
                            <th class="px-5 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($sollicitations as $s)
                        @php
                        $nom = $s->agent?->nom_prenom_agent
                        ?? $s->agentNonPermanent?->nom_prenom_nopermanent
                        ?? $s->stagiaire?->nom_prenom_stagiaire
                        ?? '—';
                        $initial = Str::upper(substr($nom, 0, 1));
                        $couleur = $s->agent ? 'bg-navy/10 text-navy' : ($s->agentNonPermanent ? 'bg-orange/10
                        text-orange' : 'bg-indigo-100 text-indigo-600');
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full {{ $couleur }} flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ $initial }}
                                    </div>
                                    <div>
                                        <span class="block font-semibold text-navy text-xs">{{ $nom }}</span>
                                        <span class="block text-[10px] text-gray-400 mt-0.5">
                                            {{ $s->motif_sollicitation ? Str::limit($s->motif_sollicitation, 35) : '—' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 hidden sm:table-cell">
                                <span
                                    class="text-xs text-navy font-medium">{{ $s->typeSollicitation?->libelle ?? '—' }}</span>
                                @if($s->jours_sollicite > 0)
                                <span class="block text-[10px] text-gray-400 mt-0.5">
                                    {{ $s->jours_sollicite }}j /
                                    {{ $s->typeSollicitation?->jours_disponible ?? '?' }}j dispo.
                                </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                @if($s->date_sollicitation)
                                <span class="block text-xs text-navy font-medium">
                                    {{ \Carbon\Carbon::parse($s->date_sollicitation)->locale('fr')->isoFormat('DD MMM YYYY') }}
                                </span>
                                @endif
                                @if($s->date_retour)
                                <span class="block text-[10px] text-gray-400 mt-0.5">
                                    →
                                    {{ \Carbon\Carbon::parse($s->date_retour)->locale('fr')->isoFormat('DD MMM YYYY') }}
                                </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <span
                                    class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold {{ etatBadge($s->etat_sollicitation) }}">
                                    {{ etatLabel($s->etat_sollicitation) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                @if($s->justificatif)
                                @php
                                $ext = strtolower(pathinfo($s->justificatif, PATHINFO_EXTENSION));
                                $isPdf = $ext === 'pdf';
                                $url = Storage::url($s->justificatif);
                                @endphp
                                <a href="{{ $url }}" target="_blank" title="Voir le justificatif" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl border transition-colors group
                        {{ $isPdf
                      ? 'bg-red-50 border-red-100 hover:bg-red-100 text-red-600'
                      : 'bg-blue-50 border-blue-100 hover:bg-blue-100 text-blue-600' }}">
                                    @if($isPdf)
                                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <span class="text-[10px] font-bold">PDF</span>
                                    @else
                                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                    <span class="text-[10px] font-bold">{{ strtoupper($ext) }}</span>
                                    @endif
                                    {{-- Icône lien externe --}}
                                    <svg class="w-2.5 h-2.5 opacity-50 group-hover:opacity-100 transition-opacity"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </a>
                                @else
                                <span class="text-[10px] text-gray-300 italic">Aucun</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                {{--  FIX : un seul wire:click, appel à openFicheFromTable --}}
                                <button wire:click="openFicheFromTable({{ $s->id }})"
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
                            <td colspan="5" class="px-5 py-8 text-center text-gray-400 text-sm">
                                Aucune sollicitation enregistrée.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($sollicitations->hasPages())
            <div class="px-5 py-3 border-t border-gray-100">{{ $sollicitations->links() }}</div>
            @endif
        </div>

        <p class="text-center text-xs text-gray-400 pb-4">
            &copy; {{ date('Y') }} Mairie de Cocody — Système de Gestion Municipale
        </p>
    </div>


    {{-- ═══════════════════════════════════════════════════════
         MODAL FICHE AGENT — liste de toutes ses sollicitations
    ═══════════════════════════════════════════════════════ --}}
    @if($showFicheModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="fixed inset-0 bg-navy/60 backdrop-blur-sm" wire:click="closeFicheModal"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative z-10 w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden">

                {{-- En-tête --}}
                <div class="bg-gradient-to-r from-navy via-[#0f2d56] to-[#1a3a6b] px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            @if($fiche_found)
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-xl font-bold text-gold shrink-0">
                                    {{ Str::upper(substr($fiche_personnel_nom, 0, 1)) }}
                                </div>
                                <div>
                                    <h2 class="font-serif text-xl font-bold">{{ $fiche_personnel_nom }}</h2>
                                    <p class="text-white/60 text-sm mt-0.5">
                                        {{ $sollicitationsAgent->count() }}
                                        sollicitation{{ $sollicitationsAgent->count() > 1 ? 's' : '' }}
                                        enregistrée{{ $sollicitationsAgent->count() > 1 ? 's' : '' }}
                                    </p>
                                </div>
                            </div>
                            @else
                            <div>
                                <h2 class="font-serif text-xl font-bold">Fiche de sollicitations</h2>
                                <p class="text-white/60 text-sm mt-0.5">Recherchez un agent par matricule</p>
                            </div>
                            @endif
                        </div>
                        <button wire:click="closeFicheModal"
                            class="w-8 h-8 flex items-center justify-center rounded-xl bg-white/10 text-white/60 hover:bg-red-500 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Erreurs édition --}}
                @if($editMode && $errors->any())
                <div class="mx-6 mt-4 p-3 bg-red-50 border border-red-200 rounded-xl">
                    <ul class="text-xs text-red-600 space-y-0.5 list-disc list-inside">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
                @endif

                {{-- Flash dans la fiche --}}
                @if(session()->has('success_fiche'))
                <div
                    class="mx-6 mt-4 p-3 bg-green/10 border border-green/20 text-green text-xs font-medium rounded-xl flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    {{ session('success_fiche') }}
                </div>
                @endif

                <div class="max-h-[70vh] overflow-y-auto">
                    <div class="p-6 space-y-4">

                        {{-- ── Recherche matricule ── --}}
                        @if(! $fiche_found || ! $editMode)
<div class="p-4 bg-navy/4 border border-navy/10 rounded-xl space-y-4">

    {{-- Sélecteur type de personnel --}}
    <div>
        <p class="text-xs font-semibold text-navy/70 uppercase tracking-wide mb-2">
            Type de personnel
        </p>
        <div class="flex gap-2">
            @foreach([
                'agent'         => 'Agent permanent',
                'non_permanent' => 'Non permanent',
                'stagiaire'     => 'Stagiaire',
            ] as $val => $label)
            <button type="button"
                    wire:click="$set('fiche_type_personnel', '{{ $val }}')"
                    class="flex-1 py-2 text-xs font-semibold rounded-xl border transition-all
                           {{ $fiche_type_personnel === $val
                               ? 'bg-navy text-white border-navy'
                               : 'bg-white text-gray-600 border-gray-200 hover:border-navy/30' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>
    </div>

    {{-- Champ de recherche dynamique --}}
    <div>
        <p class="text-xs font-semibold text-navy/70 uppercase tracking-wide mb-2 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
            </svg>
            @if($fiche_type_personnel === 'agent')
                Rechercher par matricule
            @else
                Rechercher par nom et prénom
            @endif
        </p>

        <div class="flex gap-2">
            <input type="text"
                   wire:model="fiche_matricule_search"
                   wire:keydown.enter="searchFicheAgent"
                   placeholder="{{ $fiche_type_personnel === 'agent' ? 'ex : MAT-2025-001' : 'ex : KONÉ Amadou' }}"
                   class="flex-1 px-4 py-2.5 bg-white border border-gray-200 rounded-xl
                          text-sm text-navy placeholder-gray-400
                          {{ $fiche_type_personnel === 'agent' ? 'font-mono' : '' }}
                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">

            <button wire:click="searchFicheAgent"
                    wire:loading.attr="disabled"
                    wire:target="searchFicheAgent"
                    class="flex items-center gap-2 px-4 py-2.5 bg-navy text-white text-sm font-semibold rounded-xl
                           hover:bg-[#0f2d56] transition-colors disabled:opacity-60">
                <span wire:loading.remove wire:target="searchFicheAgent">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                    </svg>
                </span>
                <span wire:loading wire:target="searchFicheAgent">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                </span>
            </button>
        </div>

        {{-- Erreur --}}
        @if($fiche_search_error)
        <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H4.645c-1.73 0-2.813-1.874-1.948-3.374l7.52-13.02c.866-1.5 3.032-1.5 3.898 0l4.942 8.567ZM12 15.75h.007v.008H12v-.008Z"/>
            </svg>
            {{ $fiche_search_error }}
        </p>
        @endif

        {{-- Résultat trouvé --}}
        @if($fiche_found)
        <div class="mt-3 flex items-center gap-3 p-3 bg-green/8 border border-green/20 rounded-xl">
            <div class="w-8 h-8 rounded-full bg-green/15 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[10px] text-green font-semibold uppercase tracking-wide">Trouvé</p>
                <p class="text-sm font-semibold text-navy truncate">{{ $fiche_personnel_nom }}</p>
                <p class="text-[10px] text-gray-400 mt-0.5">
                    @if($fiche_type_personnel === 'agent') Agent permanent
                    @elseif($fiche_type_personnel === 'non_permanent') Agent non permanent
                    @else Stagiaire
                    @endif
                </p>
            </div>
            {{-- Bouton imprimer direct --}}
            <button wire:click="imprimerFiche"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5
                           bg-navy text-white text-[11px] font-semibold rounded-xl
                           hover:bg-[#0f2d56] transition-colors shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"/>
                </svg>
                Imprimer la fiche
            </button>
        </div>
        @endif
    </div>

</div>
@endif

                        {{-- ── Liste des sollicitations ── --}}
                        @if($fiche_found && ! $editMode)
                        @if($sollicitationsAgent->isEmpty())
                        <div class="text-center py-8 text-gray-400 text-sm">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-200" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            Aucune sollicitation pour cet agent.
                        </div>
                        @else
                        <div class="space-y-3">
                            @foreach($sollicitationsAgent as $s)
                            <div class="bg-gray-50 border border-gray-100 rounded-2xl overflow-hidden">
                                {{-- Ligne principale --}}
                                <div class="flex items-center gap-4 px-5 py-4">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="text-sm font-semibold text-navy">
                                                {{ $s->typeSollicitation?->libelle ?? 'Type non défini' }}
                                            </span>
                                            <span
                                                class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ etatBadge($s->etat_sollicitation) }}">
                                                {{ etatLabel($s->etat_sollicitation) }}
                                            </span>
                                        </div>
                                        @if($s->motif_sollicitation)
                                        <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $s->motif_sollicitation }}
                                        </p>
                                        @endif
                                        <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                                            @if($s->date_sollicitation)
                                            <span class="text-[10px] text-gray-400 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($s->date_sollicitation)->locale('fr')->isoFormat('DD MMM YYYY') }}
                                            </span>
                                            @endif
                                            @if($s->date_depart && $s->date_retour)
                                            <span class="text-[10px] text-gray-400">
                                                {{ \Carbon\Carbon::parse($s->date_depart)->locale('fr')->isoFormat('DD MMM') }}
                                                →
                                                {{ \Carbon\Carbon::parse($s->date_retour)->locale('fr')->isoFormat('DD MMM YYYY') }}
                                            </span>
                                            @endif
                                            @if($s->destination)
                                            <span class="text-[10px] text-gray-400">📍 {{ $s->destination }}</span>
                                            @endif
                                            @if($s->signataire)
                                            <span class="text-[10px] text-gray-400">Signé : {{ $s->signataire }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="shrink-0">
                                        <button wire:click="imprimerSollicitation({{ $s->id }})"
                                            title="Imprimer le document PDF" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-navy/8 text-navy text-[11px] font-semibold rounded-xl hover:bg-navy/15 transition-colors">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                            </svg>
                                            Imprimer
                                        </button>
                                    </div>
                                </div>

                                {{-- Détails accidents si présents --}}
                                @if($s->lieu_accident || $s->gravite_accident)
                                <div class="px-5 pb-3 flex items-center gap-3 border-t border-gray-100 pt-3">
                                    <span class="text-[10px] font-bold text-orange uppercase tracking-wide">Accident
                                        :</span>
                                    @if($s->lieu_accident)<span
                                        class="text-[10px] text-gray-500">{{ $s->lieu_accident }}</span>@endif
                                    @if($s->gravite_accident)<span
                                        class="text-[10px] bg-orange/10 text-orange px-2 py-0.5 rounded-full font-medium">{{ $s->gravite_accident }}</span>@endif
                                    @if($s->declare_cnps)<span
                                        class="text-[10px] bg-green/10 text-green px-2 py-0.5 rounded-full font-medium">Déclaré
                                        CNPS</span>@endif
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @endif
                        @endif

                        {{-- ── Formulaire d'édition inline ── --}}
                        @if($editMode && $selectedSollicitation)
                        <div class="bg-navy/3 border border-navy/10 rounded-2xl overflow-hidden">
                            <div
                                class="px-5 py-3.5 border-b border-navy/10 flex items-center justify-between bg-navy/5">
                                <p class="text-sm font-semibold text-navy flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                    </svg>
                                    Modifier la sollicitation
                                </p>
                                <button wire:click="cancelEdit"
                                    class="text-xs text-gray-500 hover:text-navy flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                    Annuler
                                </button>
                            </div>
                            <div class="p-5 space-y-4">

                                {{-- Type + Motif + Destination + État --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Type
                                            <span class="text-red-400">*</span></label>
                                        <select wire:model="edit_type_sollicitation_id" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                       focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                       @error('edit_type_sollicitation_id') border-red-300 @enderror">
                                            <option value="">— Sélectionner —</option>
                                            @foreach($types as $t)
                                            <option value="{{ $t->id }}">{{ $t->libelle }}</option>
                                            @endforeach
                                        </select>
                                        @error('edit_type_sollicitation_id') <p class="text-xs text-red-500 mt-1">
                                            {{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">État</label>
                                        <select wire:model="edit_etat_sollicitation"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                       focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                            <option value="en_attente">En attente</option>
                                            <option value="approuvee">Approuvée</option>
                                            <option value="rejetee">Rejetée</option>
                                            <option value="annulee">Annulée</option>
                                        </select>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Motif</label>
                                        <input type="text" wire:model="edit_motif_sollicitation"
                                            placeholder="Motif de la sollicitation"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Destination</label>
                                        <input type="text" wire:model="edit_destination" placeholder="ex : Yamoussoukro"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date
                                            sollicitation <span class="text-red-400">*</span></label>
                                        <input type="date" wire:model="edit_date_sollicitation" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                                      @error('edit_date_sollicitation') border-red-300 @enderror">
                                    </div>
                                </div>

                                {{-- Dates --}}
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    @foreach([
                                    'edit_date_cessation' => 'Cessation',
                                    'edit_date_depart' => 'Départ',
                                    'edit_date_retour' => 'Retour',
                                    'edit_date_reprise' => 'Reprise',
                                    ] as $field => $label)
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ $label }}</label>
                                        <input type="date" wire:model.live="{{ $field }}"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    </div>
                                    @endforeach
                                </div>

                                {{--  Compteur jours édition --}}
                                @if($edit_date_cessation && $edit_date_reprise)
                                <div class="flex items-center gap-3 p-3 rounded-xl border
                                    {{ $edit_jours_disponible_type > 0 && $edit_jours_sollicite > $edit_jours_disponible_type
                                        ? 'bg-red-50 border-red-200'
                                        : 'bg-navy/4 border-navy/10' }}">
                                    <div class="flex-1">
                                        <p class="text-xs font-semibold text-navy">
                                            Jours sollicités :
                                            <span
                                                class="text-base font-bold {{ $edit_jours_disponible_type > 0 && $edit_jours_sollicite > $edit_jours_disponible_type ? 'text-red-600' : 'text-navy' }}">
                                                {{ $edit_jours_sollicite }}j
                                            </span>
                                            @if($edit_jours_disponible_type > 0)
                                            <span class="text-gray-400 text-xs font-normal">/
                                                {{ $edit_jours_disponible_type }}j disponibles</span>
                                            @endif
                                        </p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">
                                            Du
                                            {{ \Carbon\Carbon::parse($edit_date_cessation)->locale('fr')->isoFormat('DD MMM') }}
                                            au
                                            {{ \Carbon\Carbon::parse($edit_date_reprise)->locale('fr')->isoFormat('DD MMM YYYY') }}
                                        </p>
                                    </div>
                                    @if($edit_jours_disponible_type > 0 && $edit_jours_sollicite >
                                    $edit_jours_disponible_type)
                                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                    @else
                                    <div
                                        class="w-7 h-7 rounded-full bg-green/15 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5 text-green" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                @error('edit_jours_sollicite')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                                @enderror
                                @endif

                                {{-- Signataire + Congé --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Signataire</label>
                                        <input type="text" wire:model="edit_signataire" placeholder="Nom du signataire"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Fonction
                                            signataire</label>
                                        <input type="text" wire:model="edit_fonction_signataire"
                                            placeholder="ex : Directeur"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Tranche
                                            congé</label>
                                        <input type="text" wire:model="edit_tranche_conge"
                                            placeholder="ex : 1ère tranche"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Observation
                                            congé</label>
                                        <input type="text" wire:model="edit_observation_conge" placeholder="Remarque"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    </div>
                                </div>

                                {{-- Accident --}}
                                <div class="p-3 bg-orange/5 border border-orange/15 rounded-xl">
                                    <p class="text-[10px] font-bold text-orange/80 uppercase tracking-wide mb-3">
                                        Accident de travail (si applicable)</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                        <div>
                                            <label
                                                class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date
                                                accident</label>
                                            <input type="date" wire:model="edit_date_accident"
                                                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                        </div>
                                        <div>
                                            <label
                                                class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Lieu</label>
                                            <input type="text" wire:model="edit_lieu_accident"
                                                placeholder="ex : Chantier Nord"
                                                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                        </div>
                                        <div>
                                            <label
                                                class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Gravité</label>
                                            <select wire:model="edit_gravite_accident"
                                                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                           focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                                <option value="">— Sélectionner —</option>
                                                <option value="Léger">Léger</option>
                                                <option value="Modéré">Modéré</option>
                                                <option value="Grave">Grave</option>
                                                <option value="Très grave">Très grave</option>
                                            </select>
                                        </div>
                                        <div class="sm:col-span-2 flex items-center gap-3 pt-1">
                                            <label class="flex items-center gap-3 cursor-pointer">
                                                <div class="relative">
                                                    <input type="checkbox" wire:model.live="edit_declare_cnps"
                                                        class="sr-only peer">
                                                    <div
                                                        class="w-10 h-5 bg-gray-200 rounded-full peer peer-checked:bg-navy transition-colors duration-200">
                                                    </div>
                                                    <div
                                                        class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow peer-checked:translate-x-5 transition-transform duration-200">
                                                    </div>
                                                </div>
                                                <span class="text-sm text-gray-600 font-medium">Déclaré CNPS</span>
                                            </label>
                                        </div>
                                        @if($edit_declare_cnps)
                                        <div>
                                            <label
                                                class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date
                                                déclaration CNPS</label>
                                            <input type="date" wire:model="edit_date_declare_cnps"
                                                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Bouton enregistrer --}}
                                <div class="flex justify-end">
                                    <button wire:click="updateSollicitation" wire:loading.attr="disabled"
                                        wire:target="updateSollicitation" class="flex items-center gap-2 px-6 py-2.5 bg-green text-white text-sm font-semibold rounded-xl
                                                   hover:bg-green/90 transition-colors shadow-sm disabled:opacity-60">
                                        <span wire:loading.remove wire:target="updateSollicitation"
                                            class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                            Enregistrer les modifications
                                        </span>
                                        <span wire:loading wire:target="updateSollicitation"
                                            class="flex items-center gap-2">
                                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                            Enregistrement…
                                        </span>
                                    </button>
                                </div>

                            </div>
                        </div>
                        @endif

                    </div>
                </div>

                {{-- Footer modal fiche --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-white flex justify-end">
                    <button wire:click="closeFicheModal"
                        class="flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
                        Fermer
                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif


    {{-- ═══════════════════════════════════════════════════════
         MODAL CRÉATION — 2 ÉTAPES
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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="max-h-[85vh] overflow-y-auto">
                    <div class="p-4 sm:p-6">
                        <div class="max-w-2xl mx-auto">

                            {{-- Stepper --}}
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= $maxSteps; $i++) <div class="flex flex-col items-center flex-1">
                                        <div @class([ 'w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300'
                                            , 'bg-navy text-white shadow-md shadow-navy/25'=> $i === $step,
                                            'bg-green/90 text-white' => $i < $step, 'bg-gray-100 text-gray-400'=> $i >
                                                $step,
                                                ])>
                                                @if($i < $step) <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
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
                                                ])>{{ $this->stepLabel($i) }}</span>
                                </div>
                                @if($i < $maxSteps) <div @class(['h-0.5 flex-1 mx-1 transition-all
                                    duration-500', 'bg-green/80'=> $i < $step, 'bg-gray-200'=> $i >= $step])>
                            </div>
                            @endif
                            @endfor
                        </div>
                    </div>

                    {{-- Erreurs --}}
                    @if ($errors->any())
                    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <p class="text-sm font-medium text-red-700 mb-2">Veuillez corriger les erreurs :</p>
                        <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Card formulaire --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                        {{-- Titre --}}
                        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-navy/8 flex items-center justify-center shrink-0">
                                @if($step === 1)
                                <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                @else
                                <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V8.25z" />
                                </svg>
                                @endif
                            </div>
                            <div>
                                <h2 class="font-semibold text-navy text-sm">{{ $this->stepLabel($step) }}</h2>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    @if($step === 1) Sélectionner le personnel et renseigner la sollicitation
                                    @else Signataire, justificatif, congé et accident de travail
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- ════════ ÉTAPE 1 — Personnel + Sollicitation ════════ --}}
                        @if($step === 1)
                        <div class="p-6 space-y-5">

                            {{-- Type de personnel --}}
                            <div>
                                <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-2">
                                    Type de personnel
                                </label>
                                <div class="flex gap-2">
                                    @foreach(['agent' => 'Agent permanent', 'non_permanent' => 'Non permanent',
                                    'stagiaire' => 'Stagiaire'] as $val => $label)
                                    <label
                                        class="flex-1 flex items-center justify-center py-2 border rounded-xl cursor-pointer text-xs font-medium transition-all
                                                         {{ $type_personnel === $val ? 'bg-navy text-white border-navy' : 'bg-gray-50 text-gray-600 border-gray-200 hover:border-navy/30' }}">
                                        <input type="radio" wire:model.live="type_personnel" value="{{ $val }}"
                                            class="sr-only">
                                        {{ $label }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Recherche personnel --}}
                            <div class="p-4 bg-navy/4 border border-navy/10 rounded-xl">
                                <p
                                    class="text-xs font-semibold text-navy/70 uppercase tracking-wide mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                    {{ $type_personnel === 'agent' ? 'Rechercher par matricule' : 'Rechercher par nom' }}
                                </p>
                                <div class="flex gap-2">
                                    <input type="text" wire:model="matricule_search"
                                        wire:keydown.enter="searchPersonnel"
                                        placeholder="{{ $type_personnel === 'agent' ? 'ex : MAT-2025-001' : 'ex : KONÉ Amadou' }}"
                                        class="flex-1 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                    <button wire:click="searchPersonnel" wire:loading.attr="disabled"
                                        wire:target="searchPersonnel" class="flex items-center gap-2 px-4 py-2.5 bg-navy text-white text-sm font-semibold rounded-xl
                                                           hover:bg-[#0f2d56] transition-colors disabled:opacity-60">
                                        <span wire:loading.remove wire:target="searchPersonnel">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                        </span>
                                        <span wire:loading wire:target="searchPersonnel">
                                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                                @if($search_error)
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H4.645c-1.73 0-2.813-1.874-1.948-3.374l7.52-13.02c.866-1.5 3.032-1.5 3.898 0l4.942 8.567ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                    {{ $search_error }}
                                </p>
                                @endif
                                @if($personnel_found)
                                <div
                                    class="mt-3 flex items-center gap-3 p-3 bg-green/8 border border-green/20 rounded-xl">
                                    <div
                                        class="w-8 h-8 rounded-full bg-green/15 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-green" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-green">Trouvé</p>
                                        <p class="text-sm font-semibold text-navy">{{ $personnel_nom }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>

                            @error('personnel')
                            <p class="text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H4.645c-1.73 0-2.813-1.874-1.948-3.374l7.52-13.02c.866-1.5 3.032-1.5 3.898 0l4.942 8.567ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror

                            {{-- Type + Motif + Destination --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                        Type de sollicitation <span class="text-red-400">*</span>
                                    </label>
                                    <select wire:model="type_sollicitation_id"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                           focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all
                                                           @error('type_sollicitation_id') border-red-300 bg-red-50/30 @enderror">
                                        <option value="">— Sélectionner —</option>
                                        @foreach($types as $t)
                                        <option value="{{ $t->id }}">{{ $t->libelle }} ({{ $t->jours_disponible }}j
                                            dispo.)</option>
                                        @endforeach
                                    </select>
                                    @error('type_sollicitation_id') <p class="text-xs text-red-500 mt-1">{{ $message }}
                                    </p> @enderror
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">État</label>
                                    <select wire:model="etat_sollicitation"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                           focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                        <option value="en_attente">En attente</option>
                                        <option value="approuvee">Approuvée</option>
                                        <option value="rejetee">Rejetée</option>
                                        <option value="annulee">Annulée</option>
                                    </select>
                                </div>
                                <div class="sm:col-span-2">
                                    <label
                                        class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Motif</label>
                                    <input type="text" wire:model="motif_sollicitation"
                                        placeholder="ex : Congé annuel, Mission officielle…"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Destination</label>
                                    <input type="text" wire:model="destination" placeholder="ex : Yamoussoukro"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                        Date de sollicitation <span class="text-red-400">*</span>
                                    </label>
                                    <input type="date" wire:model="date_sollicitation"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all
                                                          @error('date_sollicitation') border-red-300 bg-red-50/30 @enderror">
                                    @error('date_sollicitation') <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Dates --}}
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                @foreach([
                                'date_cessation' => 'Cessation',
                                'date_depart' => 'Départ',
                                'date_retour' => 'Retour',
                                'date_reprise' => 'Reprise',
                                ] as $field => $label)
                                <div>
                                    <label
                                        class="block text-[10px] font-semibold text-navy/60 uppercase tracking-wide mb-1.5">{{ $label }}</label>
                                    <input type="date" wire:model.live="{{ $field }}"
                                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                </div>
                                @endforeach
                            </div>

                            {{-- ✅ Compteur jours (calculé auto depuis cessation→reprise) --}}
                            @if($date_cessation && $date_reprise)
                            <div class="flex items-center gap-3 p-3 rounded-xl border
                                        {{ $jours_disponible_type > 0 && $jours_sollicite > $jours_disponible_type
                                            ? 'bg-red-50 border-red-200'
                                            : 'bg-navy/4 border-navy/10' }}">
                                <div class="flex-1">
                                    <p class="text-xs font-semibold text-navy">
                                        Jours sollicités :
                                        <span
                                            class="text-lg font-bold {{ $jours_disponible_type > 0 && $jours_sollicite > $jours_disponible_type ? 'text-red-600' : 'text-navy' }}">
                                            {{ $jours_sollicite }}j
                                        </span>
                                        @if($jours_disponible_type > 0)
                                        <span class="text-gray-400 text-xs font-normal">/ {{ $jours_disponible_type }}j
                                            disponibles</span>
                                        @endif
                                    </p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">
                                        Calculé automatiquement du
                                        {{ \Carbon\Carbon::parse($date_cessation)->locale('fr')->isoFormat('DD MMM') }}
                                        au
                                        {{ \Carbon\Carbon::parse($date_reprise)->locale('fr')->isoFormat('DD MMM YYYY') }}
                                    </p>
                                </div>
                                @if($jours_disponible_type > 0 && $jours_sollicite > $jours_disponible_type)
                                <div class="shrink-0">
                                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                </div>
                                @else
                                <div class="shrink-0 w-8 h-8 rounded-full bg-green/15 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                                @endif
                            </div>
                            @error('jours_sollicite')
                            <p class="text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H4.645c-1.73 0-2.813-1.874-1.948-3.374l7.52-13.02c.866-1.5 3.032-1.5 3.898 0l4.942 8.567ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                            @endif

                        </div>
                        @endif

                        {{-- ════════ ÉTAPE 2 — Détails ════════ --}}
                        @if($step === 2)
                        <div class="p-6 space-y-5">

                            {{-- Rappel agent --}}
                            <div class="flex items-center gap-3 p-3 bg-navy/4 border border-navy/10 rounded-xl">
                                <div
                                    class="w-8 h-8 rounded-full bg-navy/10 flex items-center justify-center text-navy font-bold text-xs shrink-0">
                                    {{ Str::upper(substr($personnel_nom, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-medium">Personnel concerné</p>
                                    <p class="text-sm font-semibold text-navy">{{ $personnel_nom }}</p>
                                </div>
                            </div>

                            {{-- Signataire --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Signataire</label>
                                    <input type="text" wire:model="signataire" placeholder="ex : M. BAMBA Souleymane"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">Fonction
                                        du signataire</label>
                                    <input type="text" wire:model="fonction_signataire"
                                        placeholder="ex : Directeur des Ressources Humaines"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40 transition-all">
                                </div>
                            </div>

                            {{-- Justificatif --}}
                            <div>
                                <label class="block text-xs font-semibold text-navy/70 uppercase tracking-wide mb-1.5">
                                    Justificatif (PDF ou image)
                                </label>
                                <label
                                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                                                      text-xs font-medium text-gray-600 cursor-pointer hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                    </svg>
                                    {{ $justificatif ? $justificatif->getClientOriginalName() : 'Choisir un fichier' }}
                                    <input type="file" wire:model="justificatif" accept=".pdf,.jpg,.jpeg,.png"
                                        class="hidden">
                                </label>
                                <p class="text-[11px] text-gray-400 mt-1">PDF, JPG, PNG — Max 5 Mo</p>
                                @error('justificatif') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                <div wire:loading wire:target="justificatif"
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

                            {{-- Congé --}}
                            <div class="p-4 bg-navy/4 border border-navy/10 rounded-xl">
                                <p class="text-[10px] font-bold text-navy/60 uppercase tracking-wide mb-3">Informations
                                    de congé</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Tranche
                                            de congé</label>
                                        <input type="text" wire:model="tranche_conge" placeholder="ex : 1ère tranche"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Observation</label>
                                        <input type="text" wire:model="observation_conge"
                                            placeholder="Remarque sur le congé"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    </div>
                                </div>
                            </div>

                            {{-- Accident de travail --}}
                            <div class="p-4 bg-orange/5 border border-orange/15 rounded-xl">
                                <p class="text-[10px] font-bold text-orange/80 uppercase tracking-wide mb-3">Accident de
                                    travail (si applicable)</p>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date
                                            de l'accident</label>
                                        <input type="date" wire:model="date_accident"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Lieu
                                            de l'accident</label>
                                        <input type="text" wire:model="lieu_accident" placeholder="ex : Chantier Nord"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy placeholder-gray-400
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Gravité</label>
                                        <select wire:model="gravite_accident"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy appearance-none
                                                               focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                            <option value="">— Sélectionner —</option>
                                            <option value="Léger">Léger</option>
                                            <option value="Modéré">Modéré</option>
                                            <option value="Grave">Grave</option>
                                            <option value="Très grave">Très grave</option>
                                        </select>
                                    </div>
                                    <div class="flex items-center gap-3 pt-1">
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <div class="relative">
                                                <input type="checkbox" wire:model.live="declare_cnps"
                                                    class="sr-only peer">
                                                <div
                                                    class="w-10 h-5 bg-gray-200 rounded-full peer peer-checked:bg-navy transition-colors duration-200">
                                                </div>
                                                <div
                                                    class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow peer-checked:translate-x-5 transition-transform duration-200">
                                                </div>
                                            </div>
                                            <span class="text-sm text-gray-600 font-medium">Déclaré CNPS</span>
                                        </label>
                                    </div>
                                    @if($declare_cnps)
                                    <div>
                                        <label
                                            class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Date
                                            déclaration CNPS</label>
                                        <input type="date" wire:model="date_declare_cnps"
                                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-navy
                                                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40">
                                    </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                        @endif

                        {{-- Navigation --}}
                        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-3">
                            @if($step > 1)
                            <button type="button" wire:click="prevStep" wire:loading.attr="disabled"
                                wire:target="prevStep" class="flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl
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

                            @if($step < $maxSteps) <button type="button" wire:click="nextStep"
                                wire:loading.attr="disabled" wire:target="nextStep"
                                class="flex items-center gap-2 px-6 py-2.5 bg-navy text-white text-sm font-semibold rounded-xl
                                                       hover:bg-[#0f2d56] transition-colors shadow-sm shadow-navy/20 disabled:opacity-60 disabled:cursor-not-allowed">
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
                                <button type="button" wire:click="save" wire:loading.attr="disabled" wire:target="save"
                                    class="flex items-center gap-2 px-6 py-2.5 bg-green text-white text-sm font-semibold rounded-xl
                                                       hover:bg-green/90 transition-colors shadow-sm shadow-green/20 disabled:opacity-60 disabled:cursor-not-allowed">
                                    <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        Enregistrer
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
            </div>
        </div>
    </div>
</div>
</div>
@endif

</div>