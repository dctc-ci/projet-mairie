<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autres Déclarations - Mairie de Cocody</title>

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
    @livewireStyles

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
    </style>
</head>

<body
    x-data="{ sidebar: window.innerWidth >= 1024 }"
    @resize.window="sidebar = window.innerWidth >= 1024"
    class="font-sans bg-light text-navy flex h-screen overflow-hidden antialiased">

    {{-- ── Mobile overlay ── --}}
    <div x-show="sidebar" @click="sidebar = false"
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
                <div class="w-8 h-8 rounded-lg bg-green/20 flex items-center justify-center
                            group-hover:bg-green/30 transition-colors shrink-0">
                    <svg class="w-4 h-4 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                </div>
                <span class="font-serif font-bold text-base text-white group-hover:text-green transition-colors truncate">
                    Accueil
                </span>
            </a>
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
            <p class="text-[0.6rem] font-bold text-white/35 uppercase tracking-[.18em] mb-0.5">Module 02</p>
            <p class="font-serif text-xl font-bold text-green leading-tight">État Civil</p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto scrollbar-thin px-3 pb-4 space-y-0.5">

            {{-- Vue d'ensemble (actif) --}}
            <a href="{{ route('etatcivils.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                      text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-5 h-5 text-gre shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>
                </svg>
                <span class="text-sm">Vue d'ensemble</span>
            </a>

            {{-- Administration --}}
            <a href="/etatcivils/administrations"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                      text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
                <span class="text-sm">Administration</span>
            </a>

            {{-- Séparateur --}}
            <p class="px-3 pt-4 pb-1 text-[0.6rem] font-bold text-white/30 uppercase tracking-[.15em]">Actes</p>

            {{-- Actes de naissance --}}
            <a href="/etatcivils/naissances"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                      text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z"/>
                </svg>
                <span class="text-sm">Actes de naissance</span>
                
            </a>

            {{-- Actes de mariage --}}
            <a href="/etatcivils/mariages"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                      text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                </svg>
                <span class="text-sm">Actes de mariage</span>
                
            </a>

            {{-- Actes de décès --}}
            <a href="/etatcivils/deces"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                      text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12 11.204 3.045c.209-.222.499-.345.8-.345s.591.123.8.345L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
                <span class="text-sm">Actes de décès</span>
                
            </a>

            {{-- Autres déclarations --}}
            <a href="/etatcivils/autre-declarations"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                      bg-white/10 text-white font-medium
                      border border-white/8">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V8.25z"/>
                </svg>
                <span class="text-sm">Autres déclarations</span>
                
            </a>

        </nav>

        {{-- Profil utilisateur --}}
        <div class="px-4 py-4 border-t border-white/10 shrink-0">
            <div class="flex items-center gap-3">
                @if(Auth::user()?->profile_photo_path)
                    <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}"
                         class="w-9 h-9 rounded-full object-cover ring-2 ring-white/10 shrink-0">
                @else
                    <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white/60" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-[0.8rem] font-medium text-white truncate">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                    <p class="text-[0.65rem] text-white/40 truncate">{{ Auth::user()->email ?? '' }}</p>
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
                <div class="flex items-center gap-2 text-sm min-w-0">
                    <span class="text-gray-400 hidden sm:block">État Civil</span>
                    <span class="text-gray-300 hidden sm:block">/</span>
                    <span class="font-semibold text-navy truncate">Autres Déclarations</span>
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

                @livewire('etat-civils.create-autre-declaration')
    
            </div>
        </div>
    </main>

    @livewireScripts
</body>
</html>
