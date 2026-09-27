<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accident de Travail - {{ $sollicitation->agent->nom_prenom_agent }}</title>
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
        .logo-section .services    { font-size: 10pt;}

        /* ── Numéro ── */
        .numero { font-size: 11pt; margin: 14px 0 16px 0; }

        /* ── Cadre principal ── */
        .cadre {
            border: 1.5px solid #000;
            padding: 16px 20px;
            position: relative;
        }
        /* ── Photo ── */
        .photo-box {
            position: absolute;
            top: 16px;
            right: 20px;
            width: 90px;
            height: 110px;
            border: 1px solid #000;
        }

        /* ── Titre ── */
        .titre {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        

        /* ── Corps ── */
        .body-text {
            font-size: 11pt;
            line-height: 2;
        }

        .body-text p { margin-bottom: 2px; }

        .row {
            display: flex;
            align-items: baseline;
            gap: 6px;
            margin-bottom: 2px;
            flex-wrap: wrap;
        }

        .label { font-weight: bold; white-space: nowrap; }

        .field {
            display: inline-block;
            min-width: 100px;
            border-bottom: 1px solid #000;
            font-weight: bold;
        }

        .field-long {
            display: inline-block;
            min-width: 200px;
            border-bottom: 1px solid #000;
            font-weight: bold;
        }

        .field-xl {
            display: inline-block;
            min-width: 300px;
            border-bottom: 1px solid #000;
            font-weight: bold;
        }

        /* ── Ligne ITT ── */
        .itt {
            margin-top: 10px;
            font-size: 11.5pt;
            font-weight: bold;
            font-style: italic;
        }

        /* ── Signature ── */
        .signature-section {
            margin-top: 28px;
            text-align: center;
        }
        .signature-section .lieu-date  { font-size: 11pt; margin-bottom: 6px; }
        .signature-section .signataire { font-size: 11pt; font-weight: bold; }

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
        $bareme     = $agent->baremeSalarial;
        $nomCommune = $commune?->nom_commune ?? 'Kouassi-Kouassikro';

        // Civilité
        $civilite = $agent->sexe_agent === 'F' ? 'Mme/Mlle' : 'M';

        // Dates
        $dateNaiss = $agent->date_naissance_agent
            ? \Carbon\Carbon::parse($agent->date_naissance_agent)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateAccident = $sollicitation->date_accident
            ? \Carbon\Carbon::parse($sollicitation->date_accident)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateCnps = $sollicitation->date_declare_cnps
            ? \Carbon\Carbon::parse($sollicitation->date_declare_cnps)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateDoc = \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd DD MMMM YYYY');

        // Situation maritale
        $situationFam = $agent->situationFamiliale?->situation_mariale ?? '_______________';

        // Jours ITT (depuis jours_sollicite ou calcul)
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
        N° &nbsp;&nbsp;&nbsp;&nbsp; /_____ /COM-KKRO/SG/S
    </div>

    {{-- ══ CADRE PRINCIPAL ══ --}}
    <div class="">

    <div class="photo-box">
    @if($agent->photo_agent)
        <img src="{{ storage_path('app/public/' . $agent->photo_agent) }}"
             alt="Photo agent"
             style="width:100%; height:100%; object-fit:cover;">
    @endif
</div>
      

        {{-- Titre --}}
        <div class="titre">ACCIDENT SURVENU AU COURS DU TRAVAIL</div>

        {{-- Corps --}}
        <div class="body-text">

            <div class="row">
                <span class="label">Prénoms et Nom :</span>
                <span class="field-xl">{{ $civilite }} {{ $agent->nom_prenom_agent ?? '_______________' }}</span>
            </div>

            <div class="row">
                <span class="label">Né(e) le :</span>
                <span class="field">{{ $dateNaiss }}</span>
                &nbsp;&nbsp;
                <span class="label">Matricule :</span>
                <span class="field">{{ $agent->matricule ?? '_______________' }}</span>
                &nbsp;&nbsp;
                <span class="label">Grade :</span>
                <span class="field">{{ $bareme?->categorie ?? '___' }}</span>
            </div>

            <div class="row">
                <span class="label">Services :</span>
                <span class="field-long">{{ $agent->service ?? '_______________' }}</span>
            </div>

            <div class="row">
                <span class="label">Fonction :</span>
                <span class="field-long">{{ $agent->fonction ?? '_______________' }}</span>
            </div>

            <div class="row">
                <span class="label">Acte de mise à disposition :</span>
                <span class="field-long">{{ $agent->numero_embauche ?? '_______________' }}</span>
            </div>

            <div class="row">
                <span class="label">Situation maritale</span>
                <span class="field">{{ $situationFam }}</span>
                &nbsp;&nbsp;
                <span class="label">Contacts :</span>
                <span class="field">{{ $agent->contact_agent ?? '_______________' }}</span>
            </div>

            <div class="row">
                <span class="label">N° Pièce d'identité :</span>
                <span class="field-long">{{ $agent->situationFamiliale?->numero_piece ?? '_______________' }}</span>
                &nbsp;&nbsp;
                <span class="label">Etablie le :</span>
                <span class="field">
                    {{ $agent->situationFamiliale?->date_etabli_piece
                        ? \Carbon\Carbon::parse($agent->situationFamiliale->date_etabli_piece)->locale('fr')->isoFormat('DD/MM/YYYY')
                        : '_______________' }}
                </span>
            </div>

            <div class="row">
                <span class="label">Date de l'accident :</span>
                <span class="field-long">{{ $dateAccident }}</span>
            </div>

            <div class="row">
                <span class="label">Lieu de l'accident :</span>
                <span class="field-long">{{ $sollicitation->lieu_accident ?? '_______________' }}</span>
            </div>

            <div class="row">
                <span class="label">Qualification de l'Accident :</span>
                <span class="field-long">{{ $sollicitation->gravite_accident ?? '_______________' }}</span>
            </div>

            <p class="itt">
                L'Incapacité Total de Travail (ITT) est estimé à &nbsp;
                <span class="field" style="min-width:60px;">{{ $jours }}</span>
                &nbsp; jours
            </p>

        </div>

        {{-- ══ SIGNATURE ══ --}}
        <div class="signature-section">
            <div class="lieu-date">{{ $nomCommune }}, le {{ $dateDoc }}</div>
            <div class="signataire">
                {{ $sollicitation->fonction_signataire ?? 'PD' }}
            </div>
            <div style="margin-top: 30px; font-size: 11pt;">
                {{ $sollicitation->signataire ?? '' }}
            </div>
        </div>

    </div>{{-- fin cadre --}}

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