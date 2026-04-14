<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - Mairie de Cocody</title>

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
                    },
                    fontFamily: {
                        sans:  ['DM Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'Georgia', 'serif'],
                    },
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans bg-navy min-h-screen flex">

    {{-- ════════════════════════════════════════
         PANNEAU GAUCHE — Identité visuelle
    ════════════════════════════════════════ --}}
    <div class="hidden lg:flex lg:w-1/2 xl:w-3/5
                relative flex-col justify-between overflow-hidden
                bg-gradient-to-br from-navy via-[#0f2d56] to-[#071628]
                p-12">

        {{-- Bande tricolore gauche --}}
        <div class="absolute left-0 top-0 bottom-0 w-1
                    bg-gradient-to-b from-[#E05C1A] via-[#C8960C] to-[#1A6B3A]">
        </div>

        {{-- Cercles décoratifs --}}
        <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full
                    border-[40px] border-white/3"></div>
        <div class="absolute top-1/3 -right-20 w-64 h-64 rounded-full
                    border-[25px] border-white/3"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 rounded-full
                    border-[30px] border-white/3"></div>
        <div class="absolute bottom-32 right-16 w-10 h-10 rounded-full bg-gold/20"></div>
        <div class="absolute top-48 right-32 w-5 h-5 rounded-full bg-orange/30"></div>

        {{-- Haut : Logo --}}
        <div class="relative z-10">

             
                {{-- ▲  EMPLACEMENT LOGO --}}
                 <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full flex items-center justify-center shrink-0 relative overflow-hidden bg-white p-1.5 shadow-md">
                        <img src="{{ asset('storage/img/logo-mairie.png') }}" alt="Logo Mairie de Cocody" class="w-full h-full object-contain">
                    </div>
            {{-- ▲ FIN EMPLACEMENT LOGO --}}

            <p class="text-xs font-medium text-white/40 uppercase tracking-[.2em] mb-1">
                République de Côte d'Ivoire
            </p>
            <h1 class="font-serif text-3xl xl:text-4xl font-bold text-white leading-tight">
                Mairie de Cocody
            </h1>
            <p class="text-sm text-white/40 mt-1 tracking-wide">
                Système de Gestion Municipale
            </p>
        </div>

        {{-- Milieu : Citation --}}
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-px bg-gold/50"></div>
                <div class="w-1.5 h-1.5 bg-gold rotate-45"></div>
                <div class="w-8 h-px bg-gold/50"></div>
            </div>
            <blockquote class="font-serif text-xl xl:text-2xl font-semibold text-white/80 leading-snug">
                "Au service des citoyens,<br>pour un Cocody plus fort."
            </blockquote>
            <p class="text-sm text-white/35 mt-3">
                Plateforme de digitalisation des ressources humaines
            </p>

            {{-- Modules disponibles --}}
            <div class="mt-8 flex flex-col gap-2">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-navy ring-2 ring-white/20 shrink-0"></div>
                    <span class="text-xs text-white/40 font-medium">Module Personnel</span>
                    <span class="ml-auto text-[10px] text-green bg-green/15 px-2 py-0.5 rounded-full font-semibold">Actif</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-white/20 shrink-0"></div>
                    <span class="text-xs text-white/25 font-medium">Module État Civil</span>
                    <span class="ml-auto text-[10px] text-white/30 bg-white/5 px-2 py-0.5 rounded-full font-semibold">Bientôt</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-white/20 shrink-0"></div>
                    <span class="text-xs text-white/25 font-medium">Module Prestations</span>
                    <span class="ml-auto text-[10px] text-white/30 bg-white/5 px-2 py-0.5 rounded-full font-semibold">Bientôt</span>
                </div>
            </div>
        </div>

        {{-- Bas : footer --}}
        <div class="relative z-10">
            <p class="text-[11px] text-white/25 tracking-wide">
                &copy; {{ date('Y') }} Mairie de Cocody — Tous droits réservés
            </p>
        </div>
    </div>

    {{-- ════════════════════════════════════════
         PANNEAU DROIT — Formulaire login
    ════════════════════════════════════════ --}}
    <div class="w-full lg:w-1/2 xl:w-2/5
                flex flex-col items-center justify-center
                bg-[#F5F3EE] min-h-screen
                px-6 py-12 sm:px-10">

        {{-- Logo mobile uniquement --}}
        <div class="flex flex-col items-center mb-8 lg:hidden">
            <div class="w-14 h-14 rounded-full
                        border-2 border-dashed border-gold/40
                        bg-gold/5
                        flex flex-col items-center justify-center mb-3">
                <svg class="w-6 h-6 text-gold/50" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21
                             M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75
                             m-.75 3h.75m-.75 3h.75M6.75 21v-3.375
                             c0-.621.504-1.125 1.125-1.125h2.25
                             c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21"/>
                </svg>
                <span class="text-[8px] text-gold/40 mt-0.5 tracking-widest uppercase">Logo</span>
            </div>
            <h2 class="font-serif text-xl font-bold text-navy">Mairie de Cocody</h2>
            <p class="text-xs text-gray-400 mt-0.5">Système de Gestion Municipale</p>
        </div>

        {{-- Card formulaire --}}
        <div class="w-full max-w-sm">

            {{-- En-tête --}}
            <div class="mb-8">
                <h2 class="font-serif text-2xl font-bold text-navy">Connexion</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Entrez vos identifiants pour accéder à l'espace de gestion.
                </p>
            </div>

            {{-- Erreurs de validation --}}
            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-100 rounded-xl">
                    <div class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                        </svg>
                        <ul class="text-xs text-red-600 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Message session --}}
            @session('status')
                <div class="mb-5 p-4 bg-green/10 border border-green/20 rounded-xl">
                    <p class="text-xs text-green font-medium">{{ $value }}</p>
                </div>
            @endsession

            {{-- Formulaire --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div x-data="{ focused: false }">
                    <label for="email"
                           class="block text-xs font-semibold text-navy/70 mb-1.5 uppercase tracking-wide">
                        Adresse e-mail
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15
                                         a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0
                                         19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243
                                         a2.25 2.25 0 0 1-1.07 2.012l-7.5 4.5a2.25 2.25 0 0 1-2.36 0
                                         l-7.5-4.5A2.25 2.25 0 0 1 2.25 6.993V6.75"/>
                            </svg>
                        </div>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="prenom.nom@mairie-cocody.ci"
                            @focus="focused = true" @blur="focused = false"
                            class="w-full pl-10 pr-4 py-3
                                   bg-white border border-gray-200 rounded-xl
                                   text-sm text-navy placeholder-gray-400
                                   focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                   transition-all
                                   @error('email') border-red-300 bg-red-50/30 @enderror">
                    </div>
                </div>

                {{-- Mot de passe --}}
                <div x-data="{ show: false }">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password"
                               class="text-xs font-semibold text-navy/70 uppercase tracking-wide">
                            Mot de passe
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-xs text-navy/50 hover:text-navy transition-colors font-medium">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75
                                         m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25
                                         v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75
                                         a2.25 2.25 0 0 0-2.25 2.25v6.75
                                         a2.25 2.25 0 0 0 2.25 2.25Z"/>
                            </svg>
                        </div>
                        <input
                            id="password"
                            name="password"
                            :type="show ? 'text' : 'password'"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full pl-10 pr-11 py-3
                                   bg-white border border-gray-200 rounded-xl
                                   text-sm text-navy placeholder-gray-400
                                   focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/40
                                   transition-all
                                   @error('password') border-red-300 bg-red-50/30 @enderror">

                        {{-- Toggle visibilité --}}
                        <button type="button"
                                @click="show = !show"
                                class="absolute inset-y-0 right-3.5 flex items-center text-gray-400
                                       hover:text-navy transition-colors">
                            <svg x-show="!show" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.639
                                         C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007
                                         9.963 7.178.07.207.07.431 0 .639
                                         C20.577 16.49 16.64 19.5 12 19.5
                                         c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                            <svg x-show="show" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338
                                         7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395
                                         M6.228 6.228A10.451 10.451 0 0 1 12 4.5
                                         c4.756 0 8.773 3.162 10.065 7.498
                                         a10.522 10.522 0 0 1-4.293 5.774
                                         M6.228 6.228 3 3m3.228 3.228 3.65 3.65
                                         m7.894 7.894L21 21m-3.228-3.228-3.65-3.65
                                         m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Se souvenir de moi --}}
                <div class="flex items-center gap-2.5">
                    <input id="remember_me" name="remember" type="checkbox"
                           class="w-4 h-4 rounded border-gray-300 text-navy
                                  focus:ring-navy/30 focus:ring-2 cursor-pointer">
                    <label for="remember_me" class="text-sm text-gray-500 cursor-pointer select-none">
                        Se souvenir de moi
                    </label>
                </div>

                {{-- Bouton connexion --}}
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2.5
                               bg-navy text-white
                               py-3.5 rounded-xl
                               text-sm font-semibold tracking-wide
                               hover:bg-[#0f2d56]
                               focus:outline-none focus:ring-2 focus:ring-navy/30 focus:ring-offset-2
                               active:scale-[0.99]
                               transition-all duration-200
                               shadow-lg shadow-navy/20">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6
                                 a2.25 2.25 0 0 0-2.25 2.25v13.5
                                 A2.25 2.25 0 0 0 7.5 21h6
                                 a2.25 2.25 0 0 0 2.25-2.25V15
                                 m3 0 3-3m0 0-3-3m3 3H9"/>
                    </svg>
                    Se connecter
                </button>

            </form>

            {{-- Séparateur --}}
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-[10px] text-gray-400 uppercase tracking-wider">Sécurisé</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            {{-- Info sécurité --}}
            <div class="flex items-start gap-3 p-4 bg-white rounded-xl border border-gray-100">
                <svg class="w-4 h-4 text-green shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6
                             9.749 9.749 0 0 0 3 11.75c0 5.592 3.824 10.29 9 11.623
                             5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751
                             h-.152c-3.196 0-6.1-1.25-8.25-3.286Z"/>
                </svg>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Accès réservé au personnel autorisé de la Mairie de Cocody.
                    Toutes les connexions sont enregistrées et surveillées.
                </p>
            </div>

        </div>

        {{-- Footer mobile --}}
        <p class="mt-8 text-[11px] text-gray-400 text-center lg:hidden">
            &copy; {{ date('Y') }} Mairie de Cocody — Tous droits réservés
        </p>
    </div>

</body>
</html>