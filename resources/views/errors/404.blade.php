<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Module indisponible - Mairie de Cocody</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { navy: '#0B1F3A', gold: '#C8960C', green: '#1A6B3A', light: '#F5F3EE' },
                    fontFamily: { sans: ['Arial', 'sans-serif'], serif: ['Georgia', 'serif'] },
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-light text-navy flex items-center justify-center p-5">
    <main class="w-full max-w-2xl overflow-hidden rounded-3xl bg-white shadow-2xl shadow-navy/15">
        <div class="h-2 bg-gradient-to-r from-green via-gold to-navy"></div>
        <div class="px-7 py-12 sm:px-14 sm:py-16 text-center">
            <div class="mx-auto mb-7 flex h-20 w-20 items-center justify-center rounded-full bg-navy text-gold shadow-lg shadow-navy/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
            </div>
            <p class="text-sm font-semibold tracking-[0.22em] text-gold">ACCÈS INDISPONIBLE</p>
            <h1 class="mt-4 font-serif text-3xl font-bold sm:text-4xl">Ce module n’est pas accessible</h1>
            <p class="mx-auto mt-5 max-w-lg text-base leading-relaxed text-slate-500">
                Le module demandé est actuellement désactivé ou cette adresse n’est plus disponible.
                Veuillez revenir à votre espace de gestion ou contacter l’administrateur du système.
            </p>
            <div class="mt-9 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ route('bienvenu') }}" class="rounded-xl bg-navy px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Retour à l’accueil
                </a>
                <button type="button" onclick="window.history.back()" class="rounded-xl border border-navy/15 px-6 py-3 text-sm font-semibold text-navy transition hover:bg-navy/5">
                    Page précédente
                </button>
            </div>
        </div>
        <div class="border-t border-navy/5 px-6 py-4 text-center text-xs tracking-wide text-slate-400">
            Mairie de Cocody - Système de Gestion Municipale
        </div>
    </main>
</body>
</html>
