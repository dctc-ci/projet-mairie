<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Attestation de Fin de Stage — {{ $stagiaire->nom_prenom_stagiaire }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Calibri', Arial, sans-serif;
            font-size: 11.5px;
            background: #fff;
            color: #1a1a1a;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 12mm 18mm 15mm;
            background: #fff;
        }

        /* ── Bouton print ── */
        .btn-print {
            position: fixed;
            top: 16px; right: 16px;
            background: #1A6B3A;
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
            box-shadow: 0 4px 12px rgba(0,0,0,.2);
            z-index: 100;
        }
        .btn-print:hover { background: #155a30; }

        /* ── En-tête ── */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }
        .header-left { flex: 1; }
        .header-right { text-align: right; }

        .header-left .dept {
            font-weight: bold;
            font-size: 10.5px;
            text-transform: uppercase;
        }
        .header-left .commune {
            font-size: 10px;
            margin-top: 1px;
            text-transform: uppercase;
        }
        .header-left .logo-zone { margin: 8px 0; }
        .header-left .logo-zone img { width: 55px; height: 55px; object-fit: contain; }
        .header-left .secretariat {
            font-size: 10px;
            font-weight: bold;
            line-height: 1.5;
        }

        .header-right .republique {
            font-weight: bold;
            font-size: 10.5px;
            text-transform: uppercase;
        }
        .header-right .devise {
            font-style: italic;
            font-size: 10px;
            margin-top: 2px;
            text-decoration: underline;
        }

        /* ── Titre ── */
        .main-title {
            text-align: right;
            margin-top: 30px;
        }
        .main-title h1 {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0B1F3A;
            line-height: 1.3;
        }
        .main-title .subtitle {
            font-size: 14px;
            font-style: italic;
            color: #0B1F3A;
            margin-top: 2px;
            letter-spacing: 4px;
        }

        /* ── Numéro ── */
        .numero {
            font-size: 11px;
            margin: 24px 0 20px;
            color: #333;
        }
        .numero .n-val {
            display: inline-block;
            min-width: 30px;
            border-bottom: 1px solid #000;
        }

        /* ── Séparateur ── */
        .separator {
            border: none;
            border-top: 2px solid #0B1F3A;
            margin: 10px 0 20px;
        }

        /* ── Bloc attestation ── */
        .attestation-header {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: #f0f3f7;
            border: 1px solid #ccd5e0;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 20px;
            color: #0B1F3A;
        }

        /* ── Corps ── */
        .body-text {
            line-height: 2.2;
            font-size: 11.5px;
        }
        .body-text p { margin-bottom: 2px; }
        .field {
            display: inline-block;
            min-width: 90px;
            border-bottom: 1px solid #000;
            font-weight: 600;
            color: #0B1F3A;
            margin: 0 3px;
            padding: 0 4px;
            vertical-align: bottom;
        }
        .field.large { min-width: 140px; }
        .field.xl    { min-width: 200px; }
        .field.xxl   { min-width: 260px; }

        /* ── Valeur ── */
        .valeur {
            margin-top: 24px;
            line-height: 1.8;
            font-size: 11.5px;
        }

        /* ── Zones signature ── */
        .signature-zone {
            margin-top: 20px;
        }
        .sig-box {
            border: 1px solid #ccc;
            border-radius: 4px;
            height: 45px;
            margin-bottom: 10px;
            background: #fafafa;
        }

        /* ── Footer ── */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
        }
        .footer .lieu-date { margin-bottom: 6px; color: #333; }
        .footer .signataire { font-weight: bold; font-size: 12px; }

        /* ── Logo placeholder ── */
        .logo-placeholder {
            width: 55px; height: 55px;
            border: 1px solid #ccc;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 8px; color: #aaa; text-align: center;
            margin: 8px 0;
        }

        @media print {
            body { background: #fff; }
            .page { margin: 0; padding: 10mm 16mm; }
            .btn-print { display: none !important; }
            @page { size: A4; margin: 0; }
        }
    </style>
</head>
<body>

<button class="btn-print" onclick="window.print()">
    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"/>
    </svg>
    Imprimer
</button>

@php
    $dateAuj   = \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY');
    $naissance = $stagiaire->date_naissance_stagiaire
        ? \Carbon\Carbon::parse($stagiaire->date_naissance_stagiaire)->locale('fr')->isoFormat('DD MMMM YYYY')
        : '_______________';
    $demarrage = $stagiaire->date_demarrage
        ? \Carbon\Carbon::parse($stagiaire->date_demarrage)->locale('fr')->isoFormat('DD MMMM YYYY')
        : '_______________';
    $fin = $stagiaire->date_fin
        ? \Carbon\Carbon::parse($stagiaire->date_fin)->locale('fr')->isoFormat('DD MMMM YYYY')
        : '_______________';
    $f = fn($v) => $v ?: '_______________';
@endphp

<div class="page">

    {{-- ── En-tête ── --}}
    <div class="header">
        <div class="header-left">
            <div class="dept">DEPARTEMENT DE KOUASSI-KOUASSIKRO</div>
            <div class="commune">COMMUNE DE KOUASSI-KOUASSIKRO</div>
            <div class="logo-zone">
                @if(file_exists(public_path('storage/img/logo-mairie.png')))
                    <img src="{{ asset('storage/img/logo-mairie.png') }}" alt="Logo">
                @else
                    <div class="logo-placeholder">MAIRIE</div>
                @endif
            </div>
            <div class="secretariat">
                SECRETARIAT GENERAL<br>
                Services Administratifs
            </div>
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

            <div class="main-title">
                <h1>ATTESTATION DE FIN DE</h1>
                <div class="subtitle">S t a g e &nbsp; P r a t i q u e</div>
            </div>
        </div>
    </div>

    <hr class="separator">

    {{-- ── Numéro ── --}}
    <div class="numero">
        N° &nbsp;&nbsp;&nbsp;&nbsp;
        <span class="n-val">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        &nbsp;/COM-KKRO/SG/SA
    </div>

    {{-- ── Bloc attestation ── --}}
    <div class="attestation-header">
        LE MAIRE DE LA COMMUNE DE KOUASSI-KOUASSIKRO ATTESTE QUE
    </div>

    {{-- ── Corps ── --}}
    <div class="body-text">
        <p>
            L'Etudiant(e) &nbsp;
            <span class="field xxl">{{ strtoupper($stagiaire->nom_prenom_stagiaire ?? '') }}</span>
        </p>
        <p>
            né(e) le <span class="field">{{ $naissance }}</span>
            &nbsp; à <span class="field large">{{ $f($stagiaire->lieu_naissance_stagiaire) }}</span>
        </p>
        <p>
            DIPLÔME n° <span class="field">{{ $f($stagiaire->numero_diplome) }}</span>
            &nbsp;&nbsp;&nbsp;
            Session <span class="field">{{ $f($stagiaire->session) }}</span>
        </p>
        <p>
            Option <span class="field xl">{{ $f($stagiaire->option) }}</span>
        </p>
        <p>
            A effectué avec succès, un stage pratique du
            <span class="field">{{ $demarrage }}</span>
            au
            <span class="field">{{ $fin }}</span>
        </p>
        <p>
            dans les locaux
            <span class="field xl">Mairie de Kouassi-Kouassikro</span>
            sur le thème :
        </p>
        <p>
            <span class="field xxl" style="font-style:italic; min-width:320px;">
                {{ $f($stagiaire->theme_stage) }}
            </span>
        </p>
    </div>

    {{-- ── Formule ── --}}
    <div class="valeur">
        <p>
            En foi de quoi, la présente Attestation lui est délivrée pour servir et valoir ce que de droit./-
        </p>
    </div>

    {{-- ── Footer ── --}}
    <div class="footer">
        <div class="lieu-date">Kouassi-Kouassikro, le {{ $dateAuj }}</div>
        <div class="signataire">P/Le Maire et PD</div>
    </div>

    {{-- ── Zones signature ── --}}
    <div class="signature-zone">
        <div class="sig-box"></div>
        <div class="sig-box"></div>
    </div>

</div>
</body>
</html>
