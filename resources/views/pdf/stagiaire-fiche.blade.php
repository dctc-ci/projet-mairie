<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche Stagiaire - {{ $stagiaire->nom_prenom_stagiaire }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Calibri', 'Segoe UI', Arial, sans-serif;
            font-size: 11px;
            background: #fff;
            color: #1a1a1a;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 12mm 15mm 15mm;
            background: #fff;
            position: relative;
        }

        /* ── Bouton print ── */
        .btn-print {
            position: fixed;
            top: 16px; right: 16px;
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
            box-shadow: 0 4px 12px rgba(0,0,0,.2);
            z-index: 100;
        }
        .btn-print:hover { background: #0f2d56; }

        /* ── En-tête ── */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        .header .date-top {
            font-size: 10px;
            color: #555;
            text-align: right;
        }

        /* ── Titre ── */
        .title-block {
            text-align: center;
            margin: 8px 0 6px;
        }
        .title-block h1 {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #0B1F3A;
        }

        /* ── Ligne décorative ── */
        .divider {
            height: 3px;
            background: linear-gradient(90deg, #C8960C 0%, #0B1F3A 50%, #C8960C 100%);
            border-radius: 2px;
            margin: 6px 0 16px;
        }

        /* ── Photo stagiaire ── */
        .photo-zone {
            display: flex;
            justify-content: center;
            margin-bottom: 16px;
        }
        .photo-box {
            width: 90px;
            height: 110px;
            border: 2px solid #0B1F3A;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f8f8;
            border-radius: 4px;
            overflow: hidden;
        }
        .photo-box img { width: 100%; height: 100%; object-fit: cover; }
        .photo-box .no-photo {
            font-size: 9px;
            color: #aaa;
            text-align: center;
            padding: 8px;
        }

        /* ── Grille infos ── */
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .info-grid tr { border-bottom: 1px solid #e8e8e8; }
        .info-grid tr:last-child { border-bottom: none; }
        .info-grid td {
            padding: 5px 8px;
            vertical-align: top;
        }
        .info-grid td.label {
            color: #555;
            font-size: 10px;
            text-align: right;
            width: 42%;
            padding-right: 12px;
            white-space: nowrap;
        }
        .info-grid td.val {
            font-weight: 600;
            color: #0B1F3A;
            font-size: 11px;
            border-bottom: 1px dotted #ccc;
            min-width: 120px;
        }
        .info-grid td.val.empty { color: #bbb; font-weight: normal; font-style: italic; }

        /* ── Sections ── */
        .section-title {
            font-size: 13px;
            font-weight: bold;
            text-align: center;
            color: #0B1F3A;
            margin: 14px 0 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .section-box {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px 14px;
            min-height: 40px;
            background: #fafafa;
            color: #0B1F3A;
            font-size: 11px;
            margin-bottom: 10px;
        }

        /* ── Appréciation ── */
        .appreciation-title {
            font-size: 13px;
            font-weight: bold;
            text-align: center;
            color: #0B1F3A;
            margin: 10px 0 4px;
        }
        .note-badge {
            display: inline-block;
            background: #0B1F3A;
            color: #C8960C;
            font-size: 16px;
            font-weight: bold;
            padding: 4px 16px;
            border-radius: 20px;
            margin-bottom: 8px;
        }
        .note-center { text-align: center; margin-bottom: 6px; }

        /* ── Contacts ── */
        .contacts-grid {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        .contacts-grid td { padding: 4px 8px; font-size: 10px; }
        .contacts-grid td.label { color: #555; text-align: right; width: 45%; padding-right: 10px; }
        .contacts-grid td.val {
            font-weight: 600;
            border-bottom: 1px dotted #ccc;
        }

        /* ── Logos ── */
        .logo { width: 55px; height: 55px; object-fit: contain; }
        .logo-placeholder {
            width: 55px; height: 55px;
            border: 1px solid #ccc;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 8px; color: #aaa; text-align: center;
        }

        @media print {
            body { background: #fff; }
            .page { margin: 0; padding: 10mm 14mm; }
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
    $dateAuj = \Carbon\Carbon::now()->locale('fr')->isoFormat('DD/MM/YYYY');
    $f = fn($v) => $v ?: '—';
    $fd = fn($v) => $v ? \Carbon\Carbon::parse($v)->locale('fr')->isoFormat('DD MMMM YYYY') : '—';
@endphp

<div class="page">

    {{-- ── En-tête ── --}}
    <div class="header">
        {{-- Logo gauche --}}
        @if(file_exists(public_path('storage/img/logo-mairie.png')))
            <img src="{{ asset('storage/img/logo-mairie.png') }}" class="logo" alt="Logo">
        @else
            <div class="logo-placeholder">MAIRIE</div>
        @endif

        {{-- Date --}}
        <div class="date-top">{{ $dateAuj }}</div>

        {{-- Logo droit --}}
        @if(file_exists(public_path('storage/img/amoirie.png')))
            <img src="{{ asset('storage/img/amoirie.png') }}" class="logo" alt="Armoiries">
        @else
            <div class="logo-placeholder">ARMES</div>
        @endif
    </div>

    {{-- ── Titre ── --}}
    <div class="title-block">
        <h1>Fiche du Stagiaire</h1>
    </div>
    <div class="divider"></div>

    {{-- ── Photo ── --}}
    <div class="photo-zone">
        <div class="photo-box">
            @if(file_exists(public_path('storage/img/logo-mairie.png')))
                <img src="{{ asset('storage/img/logo-mairie.pngb') }}" alt="">
            @else
                <div class="no-photo">Photo<br>stagiaire</div>
            @endif
        </div>
    </div>

    {{-- ── Infos stagiaire ── --}}
    <table class="info-grid">
        <tr>
            <td class="label">Nom et Prénoms du stagiaire :</td>
            <td class="val {{ $stagiaire->nom_prenom_stagiaire ? '' : 'empty' }}">
                {{ strtoupper($stagiaire->nom_prenom_stagiaire ?? '—') }}
            </td>
        </tr>
        <tr>
            <td class="label">Nom et Prénoms Maître de stage :</td>
            <td class="val">{{ $f($stagiaire->maitre_stage) }}</td>
        </tr>
        <tr>
            <td class="label">Nature du Diplôme :</td>
            <td class="val">{{ $f($stagiaire->nature_diplome) }}</td>
        </tr>
        <tr>
            <td class="label">N° du diplôme :</td>
            <td class="val">{{ $f($stagiaire->numero_diplome) }}</td>
        </tr>
        <tr>
            <td class="label">Option :</td>
            <td class="val">{{ $f($stagiaire->option) }}</td>
        </tr>
        <tr>
            <td class="label">Inscrit à Emploi Jeune :</td>
            <td class="val">{{ $stagiaire->inscri_emploi_jeune ? 'Oui' : 'Non' }}</td>
        </tr>
        <tr>
            <td class="label">Date de démarrage du stage :</td>
            <td class="val">{{ $fd($stagiaire->date_demarrage) }}</td>
        </tr>
        <tr>
            <td class="label">Date de fin du stage :</td>
            <td class="val">{{ $fd($stagiaire->date_fin) }}</td>
        </tr>
    </table>

    {{-- ── Thème ── --}}
    <div class="section-title">Thème traité</div>
    <div class="section-box" style="text-align:center; font-size:13px; font-weight:bold; color:#1A6B3A;">
        {{ $f($stagiaire->theme_stage) }}
    </div>

    {{-- ── Note ── --}}
    @if($stagiaire->note !== null)
    <div class="note-center">
        <div style="font-size:10px; color:#555; margin-bottom:4px;">Note/20 :</div>
        <div class="note-badge">{{ number_format($stagiaire->note, 2) }} / 20</div>
    </div>
    @endif

    {{-- ── Appréciation ── --}}
    @if($stagiaire->appreciation)
    <div class="appreciation-title">Appréciation du Maître de Stage</div>
    <div class="section-box" style="text-align:center; font-size:13px; font-weight:bold; color:#1A6B3A;">
        {{ $stagiaire->appreciation }}
    </div>
    @endif

    {{-- ── Contacts ── --}}
    <table class="contacts-grid">
        <tr>
            <td class="label">Contacts du stagiaire :</td>
            <td class="val">{{ $f($stagiaire->contact_stagiaire) }}</td>
        </tr>
        <tr>
            <td class="label">Personne à contacter en cas d'urgence :</td>
            <td class="val">{{ $f($stagiaire->contact_urgence_stagiaire) }}</td>
        </tr>
    </table>

</div>
</body>
</html>
