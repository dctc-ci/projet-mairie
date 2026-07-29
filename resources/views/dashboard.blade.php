<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Mairie de Cocody</title>
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#0B1F3A',
                        gold: '#C8960C',
                        orange: '#E05C1A',
                        green: '#1A6B3A',
                        light: '#F5F3EE',
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'Georgia', 'serif'],
                    },
                    animation: {
                        'card-in': 'cardIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) both',
                    },
                    keyframes: {
                        cardIn: {
                            '0%': { opacity: '0', transform: 'translateY(28px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <style type="text/tailwindcss">
        @layer utilities {
            .hero-bg {
                background-image:
                    radial-gradient(ellipse at 20% 50%, rgba(200,150,12,0.08) 0%, transparent 60%),
                    radial-gradient(ellipse at 80% 30%, rgba(26,107,58,0.07) 0%, transparent 55%),
                    url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            }
        }
    </style>
</head>

<body class="font-sans bg-light min-h-screen">

    <div class="flex flex-col min-h-screen">

        {{-- ══ HERO BANNER ══ --}}
        <div class="bg-navy hero-bg relative overflow-hidden px-5 sm:px-8 py-12 lg:pt-14 lg:pb-16 text-center sm:text-left">
            {{-- Ligne colorée en bas --}}
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-orange via-gold to-green"></div>
            
            <div class="max-w-[1100px] mx-auto">

                {{-- Logo + Titre --}}
                <div class="flex flex-col sm:flex-row items-center gap-5 mb-8">

                    {{-- ▼ LOGO MAIRIE --}}
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full flex items-center justify-center shrink-0 relative overflow-hidden bg-white p-1.5 shadow-md">
                        <img src="{{ asset('storage/img/logo-mairie.png') }}" alt="Logo Mairie de Cocody" class="w-full h-full object-contain">
                    </div>
                    {{-- ▲ FIN LOGO --}}

                    <div class="text-center sm:text-left">
                        <h1 class="font-serif text-[clamp(1.5rem,3vw,2.1rem)] font-bold text-white leading-tight tracking-tight mt-0">Mairie de Cocody</h1>
                        <p class="text-xs font-light text-white/50 mt-1 tracking-[0.12em] uppercase">Système de Gestion Municipale</p>
                    </div>
                </div>

                {{-- Tagline centré --}}
                <div class="text-center mt-4">
                    <h2 class="font-serif text-[clamp(1rem,2vw,1.3rem)] text-white/75 font-semibold mb-1">Bienvenue sur votre espace de gestion</h2>
                    <p class="text-[0.82rem] text-white/40 tracking-[0.08em] uppercase m-0">Sélectionnez un module pour continuer</p>
                    
                    <div class="flex items-center justify-center gap-3 mt-3">
                        <div class="w-10 h-px bg-gradient-to-r from-transparent to-gold/50"></div>
                        <div class="w-1.5 h-1.5 bg-gold rotate-45"></div>
                        <div class="w-10 h-px bg-gradient-to-r from-gold/50 to-transparent"></div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ══ CARDS ══ --}}
        <div class="max-w-[1100px] w-full mx-auto -mt-6 px-4 md:px-6 pb-16 relative z-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- ── Card Personnel ── --}}
                <a href="{{ route('personnels.dashboard') }}" @class(['hidden' => ! $modules['personnels'], 'group bg-white rounded-2xl overflow-hidden flex flex-col no-underline relative transition-all duration-300 shadow-[0_2px_8px_rgba(11,31,58,0.07),0_0_0_1px_rgba(11,31,58,0.06)] cursor-pointer animate-card-in [animation-delay:50ms]'])>
                    <div class="h-[5px] w-full bg-gradient-to-r from-navy to-[#1a3a6b]"></div>
                    <div class="p-7 flex-1 flex flex-col">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-5 bg-[rgba(11,31,58,0.07)] text-navy">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                            </svg>
                        </div>
                        <div class="text-[0.65rem] font-medium tracking-[0.14em] uppercase mb-1.5 text-navy">Module 01</div>
                        <h3 class="font-serif text-2xl font-bold text-navy mb-2.5 leading-tight">Personnel</h3>
                        <p class="text-sm text-gray-500 leading-relaxed flex-1 m-0 mb-6">
                            Gestion des agents permanents, non permanents et stagiaires.
                            Suivi des salaires, sollicitations et situations familiales.
                        </p>
                    </div>
                    <div class="flex items-center justify-between px-7 py-4 border-t border-navy/5">
                        <span class="text-sm font-medium tracking-wide text-navy">Accéder au module</span>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center transition-transform duration-250 bg-[rgba(11,31,58,0.07)] text-navy group-hover:translate-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- ── Card État Civil ── --}}
                <a href="{{ route('etatcivils.dashboard') }}" @class(['hidden' => ! $modules['etat-civil'], 'group bg-white rounded-2xl overflow-hidden flex flex-col no-underline relative transition-all duration-300 shadow-[0_2px_8px_rgba(11,31,58,0.07),0_0_0_1px_rgba(11,31,58,0.06)] cursor-pointer animate-card-in [animation-delay:50ms]'])>
                    <div class="h-[5px] w-full bg-gradient-to-r from-green to-[#2d9b5a]"></div>
                    <div class="p-7 flex-1 flex flex-col">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-5 bg-[rgba(11,31,58,0.07)] text-navy">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                            </svg>
                        </div>
                        <div class="text-[0.65rem] font-medium tracking-[0.14em] uppercase mb-1.5 text-green">Module 02</div>
                        <h3 class="font-serif text-2xl font-bold text-navy mb-2.5 leading-tight">État Civil</h3>
                        <p class="text-sm text-gray-500 leading-relaxed flex-1 m-0 mb-6">
                            Enregistrement des naissances, mariages et décès.
                            Délivrance des actes et certificats d'état civil officiels.
                        </p>
                    </div>
                    <div class="flex items-center justify-between px-7 py-4 border-t border-navy/5">
                        <span class="text-sm font-medium tracking-wide text-navy">Accéder au module</span>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center transition-transform duration-250 bg-[rgba(11,31,58,0.07)] text-navy group-hover:translate-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- ── Card Prestations ── --}}
                <div @class(['hidden' => ! $modules['prestations'], 'bg-white rounded-2xl overflow-hidden flex flex-col relative shadow-[0_2px_8px_rgba(11,31,58,0.07),0_0_0_1px_rgba(11,31,58,0.05)] cursor-default animate-card-in [animation-delay:250ms]'])>
                    <div class="h-[5px] w-full bg-gradient-to-r from-orange to-gold"></div>
                    <span class="absolute top-4 right-4 bg-gray-100 text-gray-400 text-[0.65rem] font-medium tracking-widest uppercase py-1 px-2.5 rounded-full">Bientôt disponible</span>
                    <div class="p-7 flex-1 flex flex-col">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-5 bg-[rgba(224,92,26,0.08)] text-orange">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>
                            </svg>
                        </div>
                        <div class="text-[0.65rem] font-medium tracking-[0.14em] uppercase mb-1.5 text-orange">Module 03</div>
                        <h3 class="font-serif text-2xl font-bold text-navy mb-2.5 leading-tight">Prestations</h3>
                        <p class="text-sm text-gray-500 leading-relaxed flex-1 m-0 mb-6">
                            Suivi des services rendus aux citoyens. Gestion des demandes,
                            permis et autorisations délivrés par la mairie.
                        </p>
                    </div>
                    <div class="flex items-center justify-between px-7 py-4 border-t border-navy/5">
                        <span class="text-sm font-medium tracking-wide text-gray-400">En développement</span>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-100 text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ══ FOOTER ══ --}}
        @if(Auth::user()?->role === 'superadmin')
            <div class="max-w-[1100px] w-full mx-auto px-4 md:px-6 pb-10">
                <form method="POST" action="{{ route('modules.update') }}" class="bg-white rounded-2xl p-6 shadow-[0_2px_8px_rgba(11,31,58,0.07)]">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="font-serif text-xl font-bold text-navy">Modules affichés</h2>
                            <p class="text-sm text-gray-500 mt-1">Désactiver un module masque sa carte et bloque toutes ses routes.</p>
                        </div>
                        <button type="submit" class="bg-navy text-white px-5 py-2.5 rounded-lg text-sm font-medium">Enregistrer</button>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-5">
                        @foreach(['personnels' => 'Personnel', 'etat-civil' => 'État civil', 'prestations' => 'Prestations'] as $key => $label)
                            <label class="flex items-center justify-between border border-gray-200 rounded-lg px-4 py-3 cursor-pointer">
                                <span class="font-medium text-navy">{{ $label }}</span>
                                <input type="checkbox" name="modules[]" value="{{ $key }}" @checked($modules[$key]) class="rounded border-gray-300 text-navy focus:ring-navy">
                            </label>
                        @endforeach
                    </div>
                    @if(session('success'))
                        <p class="text-sm text-green mt-4">{{ session('success') }}</p>
                    @endif
                </form>
            </div>
        @endif

        <div class="text-center py-4 px-6 text-xs text-gray-400 tracking-wide pb-8 mt-auto">
            &copy; {{ date('Y') }} Mairie de Cocody &mdash; Tous droits réservés &mdash; République de Côte d'Ivoire
        </div>

    </div>

</body>
</html>
