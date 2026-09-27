<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Congé Maternité - {{ $sollicitation->agent?->nom_prenom_agent ?? $sollicitation->agentNonPermanent?->nom_prenom_nopermanent }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            color: #000;
            background: #fff;
            padding: 20px 40px;
        }

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

        .logo-section { margin: 10px 0 4px 0; }
        .logo-section img { width: 70px; height: 70px; object-fit: contain; }
        .logo-section .secretariat { font-size: 10pt; font-weight: bold; margin-top: 4px; }
        .logo-section .services    { font-size: 10pt;  }

        .numero { font-size: 11pt; margin: 14px 0 16px 0; }

        /* ── Cadre ── */
        .cadre { border: 1.5px solid #000; padding: 20px 24px; }

        /* ── Titre encadré ── */
        .titre-box {
            border: 1.5px solid #000;
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            padding: 6px 12px;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }

        .body-text {
            font-size: 11.5pt;
            line-height: 2.1;
            text-align: justify;
        }
        .body-text p { margin-bottom: 2px; }

        .field {
            display: inline-block;
            min-width: 100px;
          
            font-weight: bold;
        }

        .field-long {
            display: inline-block;
            min-width: 220px;
        
            font-weight: bold;
        }

        .signature-section {
            margin-top: 20px;
            text-align: center;
        }
        .signature-section .lieu-date  { font-size: 11pt; margin-bottom: 6px; }
        .signature-section .signataire { font-size: 11pt; font-weight: bold; }

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
        $agent   = $sollicitation->agent;
        $nonPerm = $sollicitation->agentNonPermanent;

        $nom = $agent?->nom_prenom_agent
            ?? $nonPerm?->nom_prenom_nopermanent
            ?? '_______________';

        $matricule = $agent?->matricule
                  ?? $nonPerm?->numero_act_recrutement_nopermanent
                  ?? '_______________';

        $commune    = $agent?->commune ?? $nonPerm?->commune;
        $nomCommune = $commune?->nom_commune ?? 'Kouassi-Kouassikro';

        // Dates
        $dateDepart = $sollicitation->date_depart
            ? \Carbon\Carbon::parse($sollicitation->date_depart)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateRetour = $sollicitation->date_retour
            ? \Carbon\Carbon::parse($sollicitation->date_retour)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateReprise = $sollicitation->date_reprise
            ? \Carbon\Carbon::parse($sollicitation->date_reprise)->locale('fr')->isoFormat('DD MMMM YYYY')
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

    <div class="logo-section">
        <img src="{{ asset('storage/img/logo-mairie.png') }}" alt="Logo Mairie">
        <div class="secretariat">SECRETARIAT GENERAL</div>
        <div class="services">Services Administratifs</div>
        <div style="margin-left: 50px;">-----------</div>
    </div>

    <div class="numero">
        N° &nbsp;&nbsp;&nbsp;&nbsp; /_____ /COM-KKRO/SG/SA
    </div>

    {{-- ══ CADRE ══ --}}
    <div class="">

        {{-- Titre encadré --}}
        <div class="titre-box">
            CERTIFICAT DE CESSATION DE SERVICE POUR<br>
            COUCHE ET ALLAITEMENT
        </div>

        <div class="body-text">

            <p>
                <strong>Le Maire de la Commune de {{ $nomCommune }} soussigné, certifie que :</strong>
            </p>

            <p>&nbsp;</p>

            <p>
                Matricule
                <span class="field">{{ $matricule }}</span>
            </p>

            <p>
                <span class="field-long">{{ $nom }}</span>
            </p>

            <p>
                à la Mairie de {{ $nomCommune }}, qui sera en situation de couche dans une approximative
                de six (6) semaines, bénéficie d'un congé pour couche et allaitement de vingt-six (26)
                semaines dont six (6) semaines avant l'accouchement et vingt (20) semaines après du
            </p>

            <p>
                <span class="field">{{ $dateDepart }}</span>
                au
                <span class="field">{{ $dateRetour }}</span>
                inclus.
            </p>

            <p>&nbsp;</p>

            <p>
                A l'issue de ce congé, l'intéressée reprendra service à son poste habituel le
                <span class="field">{{ $dateReprise }}</span>
            </p>

            <p>à 7 h 30 mn.</p>

            <p style="margin-top: 14px;">
                En foi de quoi, le présent certificat est établi pour servir et valoir ce que de droit.-
            </p>

        </div>

        {{-- ══ SIGNATURE ══ --}}
        <div class="signature-section">
            <div class="lieu-date">{{ $nomCommune }}, le {{ $dateDoc }}</div>
            <div class="signataire">
                P/Le Maire et {{ $sollicitation->fonction_signataire ?? 'PD' }}
            </div>
            <div style="margin-top: 10px; font-size: 11pt;">
                {{ $sollicitation->signataire ?? '' }}
            </div>
        </div>

    </div>{{-- fin cadre --}}

    {{-- ══ AMPLIATIONS ══ --}}
    <div class="ampliations">
        <div class="titre-ampl">Ampliations</div>
        <ul>
            <li>Intéressée—————————————————1</li>
            <li>Dossier——————————————————1</li>
            <li>Chrono——————————————————1</li>
        </ul>
    </div>

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