<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Certificat de Prise de Service — {{ $sollicitation->agent->nom_prenom_agent }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            color: #000;
            background: #fff;
            padding: 20px 40px;
        }

        /* ── En-tête ── */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }
        .header-left { font-size: 10pt; font-weight: bold; line-height: 1.6; }
        .header-left .underline { text-decoration: underline; }
        .header-right { font-size: 10pt; text-align: right; line-height: 1.6; }
        .header-right .bold   { font-weight: bold; }
        .header-right .italic { font-style: italic; }

        /* ── Logo ── */
        .logo-section { margin: 10px 0 4px 0; }
        .logo-section img { width: 70px; height: 70px; object-fit: contain; }
        .logo-section .secretariat { font-size: 10pt; font-weight: bold; margin-top: 4px; }
        .logo-section .services    { font-size: 10pt; }

        /* ── Numéro ── */
        .numero { font-size: 11pt; margin: 14px 0 16px 0; }

        /* ── Cadre ── */
        .cadre {
            border: 1.5px solid #000;
            padding: 20px 24px;
        }

        /* ── Titre ── */
        .titre {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin-bottom: 24px;
            letter-spacing: 1px;
        }

        /* ── Corps ── */
        .body-text {
            font-size: 11.5pt;
            line-height: 2.1;
            text-align: justify;
        }
        .body-text p { margin-bottom: 2px; }

        .field {
            display: inline-block;
            min-width: 120px;
            border-bottom: 1px solid #000;
            font-weight: bold;
        }

        .field-long {
            display: inline-block;
            min-width: 240px;
            border-bottom: 1px solid #000;
            font-weight: bold;
        }

        /* ── Signature ── */
        .signature-section {
            margin-top: 28px;
            text-align: center;
        }
        .signature-section .lieu-date  { font-size: 11pt; margin-bottom: 6px; }
        .signature-section .signataire { font-size: 11pt; font-weight: bold; }

        /* ── Ampliations ── */
        .ampliations { margin-top: 36px; font-size: 10pt; }
        .ampliations .titre-ampl { font-weight: bold; text-decoration: underline; margin-bottom: 4px; }
        .ampliations ul { list-style: none; padding-left: 10px; line-height: 1.8; }

        @media print {
            body { padding: 10px 30px; }
            @page { size: A4; margin: 15mm 20mm; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    @php
        $agent      = $sollicitation->agent;
        $commune    = $agent->commune;
        $nomCommune = $commune?->nom_commune ?? 'Kouassi-Kouassikro';

        // Civilité
        $civilite = $agent->sexe_agent === 'F' ? 'Mme/Mlle' : 'M';

        // Dates
        $datePrise = $agent->date_prise_service
            ? \Carbon\Carbon::parse($agent->date_prise_service)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateDoc = \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd DD MMMM YYYY');
    @endphp

    {{-- ══ EN-TÊTE ══ --}}
   <div class="header">
        <div class="header-left">
            <div>DEPARTEMENT DE {{ Str::upper($nomCommune) }}</div>
            <div style="margin-left: 50px;">-----------</div>
            <div class="">COMMUNE DE {{ Str::upper($nomCommune) }}</div>
        </div>
        <div class="header-right">
            <div class="bold">REPUBLIQUE DE COTE D'IVOIRE</div>
            <div class="italic">Union-Discipline-Travail</div>
            <div>------------</div>
        </div>
    </div>

    {{-- Logo + Secrétariat --}}
    <div class="logo-section">
        <img src="{{ asset('storage/img/logo-mairie.png') }}" alt="Logo Mairie">
        <div class="secretariat">SECRETARIAT GENERAL</div>
        <div class="services">Services Administratifs</div>
        <div style="margin-left: 50px;">-----------</div>
    </div>

    {{-- Numéro --}}
    <div class="numero">
        N° &nbsp;&nbsp;&nbsp;&nbsp; /_____ /COM-KKRO/SG/SA
    </div>


        <div class="titre">CERTIFICAT DE PRISE DE SERVICE</div>

        {{-- ══ CORPS ══ --}}
        <div class="body-text">

            <p>
                <strong>Le Maire de la Commune de {{ $nomCommune }} soussigné, certifie que :</strong>
            </p>

            <p>{{ $civilite }}</p>

            <p>
                <span class="field-long">{{ $agent->nom_prenom_agent ?? '_______________' }}</span>
            </p>

            <p>
                Matricule
                <span class="field">{{ $agent->matricule ?? '_______________' }}</span>
            </p>

            <p>
                Mis(e) à la disposition de la Commune de {{ $nomCommune }}
            </p>

            <p>&nbsp;</p>

            <p>
                pour y servir en qualité de
                <span class="field-long">{{ $agent->fonction ?? '_______________' }}</span>
            </p>

            <p>
                a effectivement pris service le
                <span class="field">{{ $datePrise }}</span>
                .
            </p>

            <p style="margin-top: 14px;">
                En foi de quoi, le présent Certificat est établi pour servir et valoir ce que de droit.
            </p>

        </div>

        {{-- ══ SIGNATURE ══ --}}
        <div class="signature-section">
            <div class="lieu-date">{{ $nomCommune }}, le {{ $dateDoc }}</div>
            <div class="signataire">
                 {{ $sollicitation->fonction_signataire ?? 'PD' }}
            </div>
            <div style="margin-top: 10px; font-size: 11pt;">
                {{ $sollicitation->signataire ?? '' }}
            </div>
        </div>

    

    {{-- ══ AMPLIATIONS ══ --}}
    <div class="ampliations">
        <div class="titre-ampl">Ampliations</div>
        <ul>
            <li>Intéressé(e)——————————1</li>
            <li>Dossier————————————1</li>
            <li>Chrono————————————1</li>
        </ul>
    </div>

    {{-- Bouton impression --}}
    <div style="text-align:center; margin-top:30px;" class="no-print">
        <button onclick="window.print()"
                style="padding: 10px 30px; background: #0B1F3A; color: white;
                       border: none; border-radius: 8px; font-size: 13px;
                       cursor: pointer; font-family: sans-serif;">
            🖨️ Imprimer ce document
        </button>
    </div>

</body>
</html>