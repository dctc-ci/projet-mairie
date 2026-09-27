<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin de Salaire - {{ $bulletin->agent?->nom_prenom_agent }}</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        background: #fff;
        color: #000;
    }

    .page {
        width: 210mm;
        height: 297mm;
        /* hauteur fixe A4, pas min-height */
        margin: 0 auto;
        padding: 10mm 12mm;
        background: #fff;
        display: flex;
        flex-direction: column;
        /* layout vertical */
        box-sizing: border-box;
    }

    .spacer {
        flex: 1;
        /* occupe tout l'espace restant */
        border: 1px solid #000;
        border-top: none;
    }

    /* ── En-tête ── */
    .header {
        display: flex;
        border: 1px solid #000;
        margin-bottom: 6px;
    }

    .header-left {
        flex: 1;
        border-right: 1px solid #000;
        padding: 8px 10px;
        text-align: center;
    }

    .header-right {
        flex: 1;
        padding: 8px 10px;
        text-align: center;
    }

    .header-left .dept {
        font-weight: bold;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .header-left .commune {
        font-size: 10px;
        margin-top: 2px;
        text-transform: uppercase;
    }

    .header-left .logo-zone {
        margin: 8px auto;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .header-left .logo-zone img {
        max-width: 60px;
        max-height: 60px;
    }

    .header-left .services {
        font-size: 10px;
        font-weight: bold;
        margin-top: 4px;
    }

    .header-right .republique {
        font-weight: bold;
        font-size: 11px;
        text-transform: uppercase;
    }

    .header-right .devise {
        font-style: italic;
        font-size: 10px;
        margin-top: 2px;
    }

    /* ── Titre ── */
    .titre {
        text-align: center;
        font-size: 15px;
        font-weight: bold;
        letter-spacing: 3px;
        text-transform: uppercase;
        border: 1px solid #000;
        padding: 6px;
        margin-bottom: 0;
    }

    /* ── Infos code ── */
    .infos-code {
        border: 1px solid #000;
        border-top: none;
        padding: 4px 8px;
        font-size: 10px;
        display: flex;
        gap: 30px;
        align-items: center;
    }

    .infos-periode {
        border: 1px solid #000;
        border-top: none;
        padding: 3px 8px;
        font-size: 10px;
    }

    .infos-nom {
        border: 1px solid #000;
        border-top: none;
        padding: 3px 8px;
        font-size: 10px;
    }

    /* ── Ligne agent ── */
    .agent-line {
        border: 1px solid #000;
        border-top: none;
        display: flex;
        font-size: 10px;
    }

    .agent-line .cell {
        padding: 3px 6px;
        border-right: 1px solid #000;
        flex: 1;
    }

    .agent-line .cell:last-child {
        border-right: none;
    }

    .agent-line .cell .label {
        font-size: 9px;
        color: #555;
    }

    .agent-line .cell .val {
        font-weight: bold;
    }

    /* ── Lignes de montants ── */
    .row-montant {
        display: flex;
        border: 1px solid #000;
        border-top: none;
        font-size: 10px;
    }

    .row-montant .libelle {
        flex: 1;
        padding: 3px 8px;
        border-right: 1px solid #000;
    }

    .row-montant .montant {
        width: 100px;
        padding: 3px 6px;
        text-align: right;
        font-weight: bold;
    }

    .row-montant .dots {
        flex: 1;
        overflow: hidden;
        padding: 3px 4px;
        border-right: 1px solid #000;
    }

    .dots-line {
        border-bottom: 1px dotted #aaa;
        height: 50%;
    }

    /* ── Séparateurs titre section ── */
    .section-title {
        display: flex;
        border: 1px solid #000;
        border-top: none;
        background: #f0f0f0;
    }

    .section-title .text {
        flex: 1;
        text-align: center;
        font-weight: bold;
        font-size: 11px;
        padding: 4px 8px;
        letter-spacing: 2px;
        border-right: 1px solid #000;
    }

    .section-title .total-box {
        width: 100px;
        text-align: right;
        font-weight: bold;
        font-size: 11px;
        padding: 4px 6px;
    }

    /* ── Footer ── */
    .footer {
        margin-top: 20px;
        text-align: center;
        font-size: 10px;
    }

    .footer .lieu-date {
        margin-bottom: 4px;
    }

    .footer .signataire {
        font-weight: bold;
    }

    /* ── Impression ── */
    @media print {
        body {
            background: #fff;
        }

        .page {
            margin: 0;
            padding: 10mm 12mm;
            height: 297mm;
            width: 210mm;
        }

        .no-print {
            display: none !important;
        }

        @page {
            size: A4;
            margin: 0;
        }
    }

    /* ── Bouton impression (écran uniquement) ── */
    .print-btn {
        position: fixed;
        top: 16px;
        right: 16px;
        background: #0B1F3A;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        z-index: 100;
    }

    .print-btn:hover {
        background: #0f2d56;
    }
    </style>
</head>

<body>

    {{-- Bouton imprimer (masqué à l'impression) --}}
    <button class="print-btn no-print" onclick="window.print()">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
        </svg>
        Imprimer
    </button>

    @php
    use App\Livewire\Personnels\CreateBulletinSalaire;

    $agent = $bulletin->agent;
    $bareme = $agent?->baremeSalarial;
    $commune = $agent?->commune;
    $calc = CreateBulletinSalaire::calculer($bulletin);

    // Formatage du mois
    $moisFormate = '';
    try {
    $moisFormate = \Carbon\Carbon::createFromFormat('Y-m', $bulletin->mois_paie)
    ->locale('fr')
    ->isoFormat('MMMM YYYY');
    } catch (\Throwable) {
    $moisFormate = $bulletin->mois_paie;
    }

    // Date du jour
    $dateAujourdhui = \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY');

    $communeNom = $commune?->nom_commune ?? 'Kouassi-Kouassikro';
    $codeCommune = $commune?->code_commune ?? '—';

    // Helper formatage
    $f = fn($v) => number_format((float)$v, 0, ',', ' ');
    @endphp

    <div class="page">

        {{-- ── EN-TÊTE ── --}}
        <div class="header">
            <div class="header-left">
                <div class="dept">DEPARTEMENT DE {{ strtoupper($communeNom) }}</div>
                <div class="commune">COMMUNE DE {{ strtoupper($communeNom) }}</div>
                <div class="logo-zone">
                    {{-- Logo de la mairie si disponible --}}
                    @if(file_exists(public_path('storage/img/logo-mairie.png')))
                    <img src="{{ asset('storage/img/logo-mairie.png') }}" alt="Logo">
                    @else
                    {{-- Placeholder cercle --}}
                    <svg width="50" height="50" viewBox="0 0 50 50" fill="none">
                        <circle cx="25" cy="25" r="24" stroke="#333" stroke-width="1.5" />
                        <text x="25" y="29" text-anchor="middle" font-size="8" fill="#333"
                            font-family="Arial">MAIRIE</text>
                    </svg>
                    @endif
                </div>
                <div class="services">Servives Administratifs</div>
            </div>
            <div class="header-right">
                <div class="republique">REPUBLIQUE DE COTE D'IVOIRE</div>
                <div class="logo-zone">
                    @if(file_exists(public_path('storage/img/amoirie.png')))
                    <img src="{{ asset('storage/img/amoirie.png') }}" style="width: 55px; height: 55px;" alt="Logo">
                    @else
                    <div class="logo-placeholder">ARMES</div>
                    @endif
                </div>
                <div class="devise">Union-Discipline-Travail</div>
            </div>
        </div>

        {{-- ── TITRE ── --}}
        <div class="titre">B U L L E T I N &nbsp; D E &nbsp; S A L A I R E</div>

        {{-- ── INFOS CODE ── --}}
        <div class="infos-code">
            <span>CODE COMMUNE: <strong>{{ $codeCommune }}</strong></span>
            <span>CHAP &nbsp;&nbsp;&nbsp;&nbsp; <strong>{{ $agent?->chapitre_paie ?? '' }}</strong></span>
            <span>ART &nbsp;&nbsp;&nbsp;&nbsp; <strong>{{ $agent?->article_paie ?? '' }}</strong></span>
            <span>CODE CNPS: <strong></strong></span>
        </div>

        {{-- ── PÉRIODE ── --}}
        <div class="infos-periode">
            Période de paie : <strong>{{ ucfirst($moisFormate) }}</strong>
        </div>

        {{-- ── NOM ── --}}
        <div class="infos-nom">
            Nom et Prénoms &nbsp;&nbsp; <strong>{{ strtoupper($agent?->nom_prenom_agent ?? '—') }}</strong>
        </div>

        {{-- ── LIGNE AGENT (Fonction / Matricule / Catégorie / CNPS) ── --}}
        <div class="agent-line">
            <div class="cell" style="flex:2">
                <div class="label">Fonction</div>
                <div class="val">{{ $agent?->fonction ?? '—' }}</div>
            </div>
            <div class="cell">
                <div class="label">Mat</div>
                <div class="val">{{ $agent?->matricule ?? '—' }}</div>
            </div>
            <div class="cell">
                <div class="label">Cat</div>
                <div class="val">{{ $bareme?->categorie ?? '—' }}</div>
            </div>
            <div class="cell">
                <div class="label">N° CNPS</div>
                <div class="val"></div>
            </div>
        </div>

        {{-- ── SALAIRE DE BASE ── --}}
        <div class="row-montant">
            <div class="libelle">Salaire de base<span
                    style="letter-spacing:2px">.................................................................................................</span>
            </div>
            <div class="montant">{{ $f($calc['salaire_base']) }}</div>
        </div>

        {{-- ── INDEMNITÉ DE RÉSIDENCE ── --}}
        <div class="row-montant">
            <div class="libelle">Indemnité de résidence<span
                    style="letter-spacing:2px">.....................................................................................</span>
            </div>
            <div class="montant">{{ $f($calc['indem_residence']) }}</div>
        </div>

        {{-- ── SALAIRE BRUT ── --}}
        <div class="section-title">
            <div class="text">S A L A I R E &nbsp; B R U T</div>
            <div class="total-box">{{ $f($calc['salaire_brut']) }}</div>
        </div>

        {{-- ── RETENUES ── --}}
        <div class="row-montant" style="border-top:1px solid #000;">
            <div class="libelle" style="font-weight:bold; padding-top:5px;">RETENUES</div>
            <div class="montant"></div>
        </div>

        <div class="row-montant">
            <div class="libelle">IGR<span
                    style="letter-spacing:2px">............................................................................................................</span>
            </div>
            <div class="montant">{{ $f($calc['igr']) }}</div>
        </div>
        <div class="row-montant">
            <div class="libelle">Contribution Nationale<span
                    style="letter-spacing:2px">.....................................................................................</span>
            </div>
            <div class="montant">{{ $f($calc['contrib_nation']) }}</div>
        </div>
        <div class="row-montant">
            <div class="libelle">Impôt sur salaire<span
                    style="letter-spacing:2px">........................................................................................</span>
            </div>
            <div class="montant">{{ $f($calc['impot_salaire']) }}</div>
        </div>
        <div class="row-montant">
            <div class="libelle">Caisse de retraite (CNPS)<span
                    style="letter-spacing:2px">.............................................................................</span>
            </div>
            <div class="montant">{{ $f($calc['cnps']) }}</div>
        </div>

        {{-- ── TOTAL RETENUES ── --}}
        <div class="section-title">
            <div class="text">T O T A L &nbsp; R E T E N U E S</div>
            <div class="total-box">{{ $f($calc['total_retenues']) }}</div>
        </div>

        {{-- ── SALAIRE NET ── --}}
        <div class="section-title">
            <div class="text">S A L A I R E &nbsp; N E T</div>
            <div class="total-box">{{ $f($calc['salaire_net']) }}</div>
        </div>

        {{-- ── INDEMNITÉS ── --}}
        <div class="row-montant" style="border-top:1px solid #000;">
            <div class="libelle">Indemnité de Transport<span
                    style="letter-spacing:2px">.....................................................................................</span>
            </div>
            <div class="montant">{{ $f($calc['indem_transp']) }}</div>
        </div>
        <div class="row-montant">
            <div class="libelle">Indemnité de Fonction<span
                    style="letter-spacing:2px">....................................................................................</span>
            </div>
            <div class="montant">{{ $f($calc['indem_fonction']) }}</div>
        </div>
        <div class="row-montant">
            <div class="libelle">Indemnité de logement<span
                    style="letter-spacing:2px">....................................................................................</span>
            </div>
            <div class="montant">0</div>
        </div>
        <div class="row-montant">
            <div class="libelle">Indemnité de technicité<span
                    style="letter-spacing:2px">.................................................................................</span>
            </div>
            <div class="montant">{{ $f($calc['indem_techn']) }}</div>
        </div>

        {{-- ── SALAIRE NET À PAYER ── --}}
        <div class="section-title" style="font-size:12px;">
            <div class="text" style="font-size:12px;">S A L A I R E &nbsp; N E T &nbsp; A &nbsp; P A Y E R</div>
            <div class="total-box" style="font-size:12px;">{{ $f($calc['salaire_net_a_payer']) }}</div>
        </div>

        {{-- ── ZONE SIGNATURE — s'étire pour remplir la page ── --}}
        <div class="spacer"></div>

        {{-- ── FOOTER ── --}}
        <div class="footer">
            <div class="lieu-date">
                Délivré à {{ $communeNom }}, le {{ $dateAujourdhui }}
            </div>
            <div class="signataire">P/Le Maire et PD</div>
        </div>

    </div>

</body>

</html>