<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Permission Mariage/Baptême - {{ $sollicitation->agent?->nom_prenom_agent ?? $sollicitation->agentNonPermanent?->nom_prenom_nopermanent }}</title>
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

        .numero { font-size: 11pt; margin: 14px 0 24px 0; }

        .body-text {
            font-size: 11.5pt;
            line-height: 2.1;
        }
        .body-text p { margin-bottom: 2px; }

        .avec-motif {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 6px 0 10px 0;
            letter-spacing: 1px;
        }

        .indent { padding-left: 40px; }

        .field {
            display: inline-block;
            min-width: 100px;
           
            font-weight: bold;
        }

        .field-sm {
            display: inline-block;
   
    
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

        .ampliations { margin-top: 30px; font-size: 10pt; }
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

        $fonction  = $agent?->fonction
                  ?? $nonPerm?->fonction_nopermanent
                  ?? '_______________';

        $service   = $agent?->service
                  ?? $nonPerm?->service_nopermanent
                  ?? '_______________';

        $commune    = $agent?->commune ?? $nonPerm?->commune;
        $nomCommune = $commune?->nom_commune ?? 'Kouassi-Kouassikro';

        $dateSollicitation = $sollicitation->date_sollicitation
            ? \Carbon\Carbon::parse($sollicitation->date_sollicitation)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateDepart = $sollicitation->date_depart
            ? \Carbon\Carbon::parse($sollicitation->date_depart)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateReprise = $sollicitation->date_reprise
            ? \Carbon\Carbon::parse($sollicitation->date_reprise)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateDoc = \Carbon\Carbon::now()->locale('fr')->isoFormat('DD MMMM YYYY');

        $jours = $sollicitation->jours_sollicite > 0
            ? $sollicitation->jours_sollicite
            : ($sollicitation->date_depart && $sollicitation->date_retour
                ? \Carbon\Carbon::parse($sollicitation->date_depart)
                      ->diffInDays(\Carbon\Carbon::parse($sollicitation->date_retour))
                : '___');
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

    {{-- ══ CORPS ══ --}}
    <div class="body-text">

        <p><strong>Le Maire de la Commune de {{ $nomCommune }} soussigné,</strong></p>
        <p>
            Au regard de la demande formulée par l'intéressé(e) le
            <span class="field">{{ $dateSollicitation }}</span>
        </p>

        <div class="avec-motif">AVEC POUR MOTIF(S)</div>

        <p><strong>ACCORDE A</strong></p>

        <div class="indent">
            <p>
                <span class="field-long">{{ $nom }}</span>
            </p>
            <p>
                Matricule :
                <span class="field">{{ $matricule }}</span>
            </p>
            <p>
                Fonction :
                <span class="field-long">{{ $fonction }}</span>
            </p>
            <p>
                Services :
                <span class="field-long">{{ $service }}</span>
            </p>
        </div>

        <p>
            <strong>
                Une permission de
                <span class="field-sm">{{ $jours }}</span>
                jours consécutifs à solde de présence et non déductibles du congé
                annuel.
            </strong>
        </p>

        <p>&nbsp;</p>

        <p>
            Date de départ :
            <span class="field">{{ $dateDepart }}</span>
        </p>

        <p>
            Date de reprise :
            <span class="field">{{ $dateReprise }}</span>
            &nbsp; à 7h 30mn à son poste habituel
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

    {{-- ══ AMPLIATIONS ══ --}}
    <div class="ampliations">
        <div class="titre-ampl">Ampliations</div>
        <ul>
            <li>SG ————————————————————1</li>
            <li>Chefs de sces———————————————4</li>
            <li>Dossier————————————————————1</li>
            <li>Chrono————————————————————1</li>
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