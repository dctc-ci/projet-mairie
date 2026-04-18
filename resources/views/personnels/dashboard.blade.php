<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personnel - Mairie de Cocody</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy:   '#0B1F3A',
                        gold:   '#C8960C',
                        orange: '#E05C1A',
                        green:  '#1A6B3A',
                        light:  '#F5F3EE',
                    },
                    fontFamily: {
                        sans:  ['DM Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'Georgia', 'serif'],
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%':   { opacity: '0', transform: 'translateY(16px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%':   { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                    },
                    animation: {
                        fadeInUp: 'fadeInUp 0.45s ease-out both',
                        fadeIn:   'fadeIn 0.3s ease-out both',
                    },
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .scrollbar-thin::-webkit-scrollbar { width: 3px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.12); border-radius: 4px; }
        .scrollbar-thin:hover::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.22); }
        .delay-100 { animation-delay: 100ms; }
        .delay-150 { animation-delay: 150ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-250 { animation-delay: 250ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-350 { animation-delay: 350ms; }
    </style>
</head>

{{-- ════════════════════════════════════════════
     ROOT — Alpine state
════════════════════════════════════════════ --}}
<body
    x-data="{ sidebar: window.innerWidth >= 1024 }"
    @resize.window="sidebar = window.innerWidth >= 1024"
    class="font-sans bg-light text-navy flex h-screen overflow-hidden antialiased">

    {{-- ── Mobile overlay ── --}}
    <div
        x-show="sidebar"
        @click="sidebar = false"
        x-transition.opacity
        class="fixed inset-0 z-20 bg-navy/60 backdrop-blur-sm lg:hidden"
        x-cloak>
    </div>

    {{-- ════════════════════════════════════════════
         SIDEBAR
    ════════════════════════════════════════════ --}}
    <aside
        :class="sidebar ? 'translate-x-0' : '-translate-x-full'"
        class="fixed lg:relative inset-y-0 left-0 z-30
               w-64 shrink-0 flex flex-col
               bg-navy text-white
               shadow-2xl
               transition-transform duration-300 ease-in-out">

        {{-- Logo / Retour --}}
        <div class="h-16 px-4 flex items-center border-b border-white/10 shrink-0">
            <a href="{{ route('bienvenu') }}"
               class="flex items-center gap-3 group flex-1 min-w-0">
                <div class="w-8 h-8 rounded-lg bg-gold/20 flex items-center justify-center
                            group-hover:bg-gold/30 transition-colors shrink-0">
                    <svg class="w-4 h-4 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                </div>
                <span class="font-serif font-bold text-base text-white group-hover:text-gold transition-colors truncate">
                    Accueil
                </span>
            </a>
            {{-- Fermer sidebar (mobile) --}}
            <button @click="sidebar = false"
                    class="lg:hidden w-8 h-8 rounded-full bg-white/5 flex items-center justify-center
                           text-white/60 hover:bg-white/10 hover:text-white transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Titre module --}}
        <div class="px-6 pt-5 pb-3 shrink-0">
            <p class="text-[0.6rem] font-bold text-white/35 uppercase tracking-[.18em] mb-0.5">Module 01</p>
            <p class="font-serif text-xl font-bold text-gold leading-tight">Personnel</p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto scrollbar-thin px-3 pb-4 space-y-0.5">

            {{-- Vue d'ensemble --}}
            <a href="{{ route('personnels.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                      bg-white/10 text-white font-medium
                      border border-white/8">
                <svg class="w-5 h-5 text-gold shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>
                </svg>
                <span class="text-sm">Vue d'ensemble</span>
            </a>

            {{-- Administration --}}
            <a href="/personnels/administrations" class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                               text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
                <span class="text-sm">Administration</span>
            </a>

            {{-- Groupe : Gestion du Personnel --}}
            <div x-data="{ open: true }" class="pt-2">
                <p class="px-3 mb-1 text-[0.6rem] font-bold text-white/30 uppercase tracking-[.15em]">Gestion</p>

                <button @click="open = !open"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl
                               text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                        </svg>
                        <span class="text-sm font-medium">Personnel</span>
                    </div>
                    <svg class="w-4 h-4 shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                         fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                    </svg>
                </button>

                <div x-show="open" x-collapse x-cloak class="mt-0.5 pl-11 space-y-0.5">
                    <a href="{{ route('personnels.agents-permanents') }}"
                       class="block px-3 py-2 text-[0.82rem] text-white/50 hover:text-gold hover:bg-white/5 rounded-lg transition-colors">
                        Agents permanents
                    </a>
                    <a href="{{ route('personnels.agents-non-permanents') }}"
                       class="block px-3 py-2 text-[0.82rem] text-white/50 hover:text-gold hover:bg-white/5 rounded-lg transition-colors">
                        Agents non permanents
                    </a>
                    <a href="/personnels/stagiaires"
                       class="block px-3 py-2 text-[0.82rem] text-white/50 hover:text-gold hover:bg-white/5 rounded-lg transition-colors">
                        Stagiaires
                    </a>
                </div>
            </div>

            {{-- Autres liens --}}
            <p class="px-3 pt-3 mb-1 text-[0.6rem] font-bold text-white/30 uppercase tracking-[.15em]">Carrière</p>

            <a href="/personnels/situations-familiales"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                      text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                </svg>
                <span class="text-sm">Situations familiales</span>
            </a>

            <a href="/personnels/sollicitations"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                      text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 2.012l-7.5 4.5a2.25 2.25 0 0 1-2.36 0l-7.5-4.5A2.25 2.25 0 0 1 2.25 6.993V6.75"/>
                </svg>
                <span class="text-sm">Sollicitations</span>
            </a>

            <p class="px-3 pt-3 mb-1 text-[0.6rem] font-bold text-white/30 uppercase tracking-[.15em]">Paie</p>

            <a href="/personnels/bareme-salarials"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                      text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <span class="text-sm">Barème salarial</span>
            </a>

            <a href="/personnels/bulletin-salaires"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                      text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V8.25z"/>
                </svg>
                <span class="text-sm">Bulletins de salaire</span>
            </a>

        </nav>

        {{-- Profil utilisateur --}}
        <div class="px-4 py-4 border-t border-white/10 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white/60" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[0.8rem] font-medium text-white truncate">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                    <p class="text-[0.65rem] text-white/40 truncate">{{ Auth::user()->email ?? '<a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="ccada8a1a5a28ca1ada5bea5a9e1afa3afa3a8b5e2afa5">[email&#160;protected]</a>' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" x-data class="shrink-0">
                    @csrf
                    <button type="submit"
                            class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center
                                   text-white/40 hover:bg-red-500/20 hover:text-red-400 transition-colors"
                            title="Déconnexion">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ════════════════════════════════════════════
         MAIN CONTENT
    ════════════════════════════════════════════ --}}
    <main class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">

        {{-- ── Topbar ── --}}
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between
                       px-4 sm:px-6 shrink-0 shadow-sm z-10">
            <div class="flex items-center gap-3 min-w-0">
                <button @click="sidebar = !sidebar"
                        class="w-9 h-9 rounded-xl bg-gray-50 border border-gray-100
                               flex items-center justify-center text-gray-500
                               hover:text-navy hover:bg-gray-100 transition-colors shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>

                {{-- Breadcrumb --}}
                <div class="flex items-center gap-2 text-sm min-w-0">
                    <span class="text-gray-400 hidden sm:block">Personnel</span>
                    <span class="text-gray-300 hidden sm:block">/</span>
                    <span class="font-semibold text-navy truncate">Vue d'ensemble</span>
                </div>
            </div>

            <div class="flex items-center gap-2">

                {{-- Date --}}
                <div class="hidden sm:flex items-center gap-1.5 px-3 py-1.5
                            bg-gray-50 border border-gray-100 rounded-xl text-xs text-gray-500">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                    </svg>
                    {{ now()->locale('fr')->isoFormat('DD MMM YYYY') }}
                </div>
            </div>
        </header>

        {{-- ── Scrollable Content ── --}}
        <div class="flex-1 overflow-y-auto">
            <div class="p-4 sm:p-6 lg:p-8 max-w-6xl mx-auto space-y-6">

                {{-- ── Bannière bienvenue ── --}}
                <div class="animate-fadeInUp delay-100 relative overflow-hidden
                            bg-gradient-to-r from-navy via-[#0f2d56] to-[#1a3a6b]
                            rounded-2xl p-6 sm:p-8 text-white shadow-lg">

                    <div class="relative z-10">
                        <p class="text-xs font-medium text-white/50 uppercase tracking-widest mb-1">
                            Mairie de Cocody — Module Personnel
                        </p>
                        <h2 class="font-serif text-2xl sm:text-3xl font-bold mb-2 leading-tight">
                            Vue d'ensemble
                        </h2>
                        <p class="text-white/60 text-sm leading-relaxed max-w-xl">
                            Tableau de bord centralisé pour la gestion de l'effectif, le suivi des carrières
                            et l'administration des ressources humaines de la mairie.
                        </p>
                    </div>

                    {{-- Déco --}}
                    <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full border-[28px] border-white/5"></div>
                    <div class="absolute right-16 -bottom-8 w-28 h-28 rounded-full border-[14px] border-white/5"></div>
                    <div class="absolute right-6 top-6 w-10 h-10 rounded-full bg-gold/20"></div>
                </div>

                {{-- ── Statistiques (4 cards) ── --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 animate-fadeInUp delay-150">

                    {{-- Agents permanents --}}
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm
                                flex flex-col gap-3 hover:-translate-y-1 hover:shadow-md transition-all">
                        <div class="flex items-center justify-between">
                            <div class="w-10 h-10 rounded-xl bg-navy/8 flex items-center justify-center">
                                <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                                </svg>
                            </div>
                            @if($newAgentsMois > 0)
                                <span class="text-[10px] font-semibold text-green bg-green/10 px-2 py-0.5 rounded-full">+{{ $newAgentsMois }} ce mois</span>
                            @else
                                <span class="text-[10px] font-semibold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">Aucun ce mois</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-2xl font-bold font-serif text-navy">{{ $nbAgentsPermanents }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Agents permanents</p>
                        </div>
                        <div class="h-1 bg-gray-100 rounded-full">
                            <div class="h-1 bg-navy rounded-full" style="width:{{ $progressPermanents }}%"></div>
                        </div>
                    </div>

                    {{-- Agents non permanents --}}
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm
                                flex flex-col gap-3 hover:-translate-y-1 hover:shadow-md transition-all">
                        <div class="flex items-center justify-between">
                            <div class="w-10 h-10 rounded-xl bg-orange/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                                </svg>
                            </div>
                            @if($newNonPermMois > 0)
                                <span class="text-[10px] font-semibold text-orange bg-orange/10 px-2 py-0.5 rounded-full">+{{ $newNonPermMois }} ce mois</span>
                            @else
                                <span class="text-[10px] font-semibold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">Aucun ce mois</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-2xl font-bold font-serif text-navy">{{ $nbAgentsNonPerm }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Agents non permanents</p>
                        </div>
                        <div class="h-1 bg-gray-100 rounded-full">
                            <div class="h-1 bg-orange rounded-full" style="width:{{ $progressNonPerm }}%"></div>
                        </div>
                    </div>

                    {{-- Stagiaires --}}
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm
                                flex flex-col gap-3 hover:-translate-y-1 hover:shadow-md transition-all">
                        <div class="flex items-center justify-between">
                            <div class="w-10 h-10 rounded-xl bg-gold/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/>
                                </svg>
                            </div>
                            <span class="text-[10px] font-semibold text-gold bg-gold/10 px-2 py-0.5 rounded-full">En cours</span>
                        </div>
                        <div>
                            <p class="text-2xl font-bold font-serif text-navy">{{ $nbStagiaires }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Stagiaires actifs</p>
                        </div>
                        <div class="h-1 bg-gray-100 rounded-full">
                            <div class="h-1 bg-gold rounded-full" style="width:{{ $progressStagiaires }}%"></div>
                        </div>
                    </div>

                    {{-- Sollicitations en attente --}}
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm
                                flex flex-col gap-3 hover:-translate-y-1 hover:shadow-md transition-all">
                        <div class="flex items-center justify-between">
                            <div class="w-10 h-10 rounded-xl bg-green/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 2.012l-7.5 4.5a2.25 2.25 0 0 1-2.36 0l-7.5-4.5A2.25 2.25 0 0 1 2.25 6.993V6.75"/>
                                </svg>
                            </div>
                            @if($nbSollicitationsEnAttente > 0)
                                <span class="text-[10px] font-semibold text-red-500 bg-red-50 px-2 py-0.5 rounded-full">À traiter</span>
                            @else
                                <span class="text-[10px] font-semibold text-green bg-green/10 px-2 py-0.5 rounded-full">À jour</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-2xl font-bold font-serif text-navy">{{ $nbSollicitationsEnAttente }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Sollicitations en attente</p>
                        </div>
                        <div class="h-1 bg-gray-100 rounded-full">
                            <div class="h-1 bg-green rounded-full" style="width:{{ $progressSollicit }}%"></div>
                        </div>
                    </div>

                </div>

                {{-- ── Ligne du bas : Accès rapides + Activité récente ── --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fadeInUp delay-200">

                    {{-- Accès rapides (1/3) --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-navy">Accès rapides</h3>
                        </div>
                        <div class="p-3 space-y-1">

                            <a href="/personnels/agents-permanents"
                               class="flex items-center gap-3 px-3 py-3 rounded-xl
                                      hover:bg-gray-50 transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-navy/8 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700 group-hover:text-navy font-medium">Ajouter un agent</span>
                                <svg class="w-4 h-4 text-gray-300 ml-auto group-hover:text-navy transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                </svg>
                            </a>

                            <a href="/personnels/bulletin-salaires"
                               class="flex items-center gap-3 px-3 py-3 rounded-xl
                                      hover:bg-gray-50 transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-green/10 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700 group-hover:text-navy font-medium">Nouveau bulletin</span>
                                <svg class="w-4 h-4 text-gray-300 ml-auto group-hover:text-navy transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                </svg>
                            </a>

                            <a href="/personnels/sollicitations"
                               class="flex items-center gap-3 px-3 py-3 rounded-xl
                                      hover:bg-gray-50 transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-orange/10 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V8.25z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700 group-hover:text-navy font-medium">Voir sollicitations</span>
                                <span class="ml-auto bg-red-50 text-red-500 text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $nbSollicitationsEnAttente }}</span>
                            </a>

                            <a href="/personnels/stagiaires"
                               class="flex items-center gap-3 px-3 py-3 rounded-xl
                                      hover:bg-gray-50 transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-gold/10 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700 group-hover:text-navy font-medium">Ajouter un stagiaire</span>
                                <svg class="w-4 h-4 text-gray-300 ml-auto group-hover:text-navy transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                </svg>
                            </a>

                        </div>
                    </div>

                    {{-- Activité récente (2/3) --}}
                    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-navy">Activité récente</h3>
                            <a href="#" class="text-xs text-navy/60 hover:text-navy font-medium transition-colors">
                                Voir tout →
                            </a>
                        </div>
                        <div class="divide-y divide-gray-50">

                            @forelse($activites as $act)
                            @php
                                $couleurs = [
                                    'green'  => ['bg' => 'bg-green/10',   'text' => 'text-green'],
                                    'orange' => ['bg' => 'bg-orange/10',  'text' => 'text-orange'],
                                    'gold'   => ['bg' => 'bg-gold/10',    'text' => 'text-gold'],
                                    'navy'   => ['bg' => 'bg-navy/8',     'text' => 'text-navy'],
                                ];
                                $c = $couleurs[$act['couleur']] ?? $couleurs['navy'];

                                // Temps relatif
                                $diff = $act['created_at'] ? $act['created_at']->diffForHumans() : '—';
                            @endphp
                            <div class="flex items-start gap-4 px-5 py-4 hover:bg-gray-50/50 transition-colors">
                                <div class="w-8 h-8 rounded-full {{ $c['bg'] }} flex items-center justify-center shrink-0 mt-0.5">
                                    @if($act['icone'] === 'user-add')
                                        <svg class="w-4 h-4 {{ $c['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"/>
                                        </svg>
                                    @elseif($act['icone'] === 'user')
                                        <svg class="w-4 h-4 {{ $c['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                        </svg>
                                    @elseif($act['icone'] === 'academic')
                                        <svg class="w-4 h-4 {{ $c['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/>
                                        </svg>
                                    @elseif($act['icone'] === 'mail')
                                        <svg class="w-4 h-4 {{ $c['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 2.012l-7.5 4.5a2.25 2.25 0 0 1-2.36 0l-7.5-4.5A2.25 2.25 0 0 1 2.25 6.993V6.75"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 {{ $c['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V8.25z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-navy">{{ $act['titre'] }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $act['detail'] }}</p>
                                </div>
                                <span class="text-[10px] text-gray-400 shrink-0 mt-0.5">{{ $diff }}</span>
                            </div>
                            @empty
                            <div class="px-5 py-8 text-center text-gray-400 text-sm">
                                Aucune activité récente.
                            </div>
                            @endforelse

                        </div>
                    </div>

                </div>

                {{-- ── Sollicitations en attente (table) ── --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fadeInUp delay-300">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-navy">Sollicitations en attente</h3>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $nbSollicitationsEnAttente }} demande{{ $nbSollicitationsEnAttente !== 1 ? 's' : '' }}
                                {{ $nbSollicitationsEnAttente > 0 ? 'nécessite'.($nbSollicitationsEnAttente > 1 ? 'nt' : '').' votre attention' : 'en attente' }}
                            </p>
                        </div>
                        <a href=""
                           class="text-xs font-semibold text-navy/60 hover:text-navy transition-colors">
                            Voir tout →
                        </a>
                    </div>

                    {{-- Table responsive --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Agent</th>
                                    <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">Type</th>
                                    <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Date</th>
                                    <th class="text-left px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Statut</th>
                                    <th class="px-5 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($sollicitationsEnAttente as $s)
                                @php
                                    $nom = $s->agent?->nom_prenom_agent
                                        ?? $s->agentNonPermanent?->nom_prenom_nopermanent
                                        ?? $s->stagiaire?->nom_prenom_stagiaire
                                        ?? '—';
                                    $initiale = Str::upper(substr($nom, 0, 1));
                                    $couleurs = ['A','E','I','O','U'];
                                    $couleurMap = in_array($initiale, $couleurs)
                                        ? 'bg-orange/10 text-orange'
                                        : (in_array(ord($initiale) % 3, [0])
                                            ? 'bg-green/10 text-green'
                                            : 'bg-navy/10 text-navy');
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-7 h-7 rounded-full {{ $couleurMap }} flex items-center justify-center text-xs font-bold shrink-0">
                                                {{ $initiale }}
                                            </div>
                                            <span class="font-medium text-navy text-xs truncate max-w-[120px]">{{ $nom }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 hidden sm:table-cell text-xs text-gray-500">
                                        {{ $s->typeSollicitation?->libelle ?? $s->motif_sollicitation ?? '—' }}
                                    </td>
                                    <td class="px-5 py-3.5 hidden md:table-cell text-xs text-gray-500">
                                        {{ $s->date_sollicitation ? \Carbon\Carbon::parse($s->date_sollicitation)->locale('fr')->isoFormat('DD MMM YYYY') : '—' }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="bg-yellow-50 text-yellow-700 text-[10px] font-semibold px-2 py-0.5 rounded-full">En attente</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <a href="/personnels/sollicitations" class="text-xs text-navy font-medium hover:underline">Traiter</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-6 text-center text-gray-400 text-sm">
                                        Aucune sollicitation en attente. ✓
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ── Footer ── --}}
                <p class="text-center text-xs text-gray-400 pb-4">
                    &copy; {{ date('Y') }} Mairie de Cocody. Tous droits réservés.
                </p>          </div>    