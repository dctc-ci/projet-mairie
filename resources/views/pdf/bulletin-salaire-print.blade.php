<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bulletin de Salaire - {{ $bulletin->agent->nom_prenom_agent }} — {{ $bulletin->mois_paie }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        html, body {
            width: 100%;
            height: 100%;
        }

        body {
            font-family: "Arial", sans-serif;
            font-size: 10pt;
            color: #000;
            background: #fff;
            padding: 16px 24px;
        }

        /* ══ EN-TÊTE ══ */
        .header-wrap {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 6px;
        }
        .header-left { font-size: 9pt; font-weight: bold; line-height: 1.5; }
        .header-left .underline { text-decoration: underline; }
        .header-right { font-size: 9pt; text-align: right; line-height: 1.5; }
        .header-right .bold   { font-weight: bold; }
        .header-right .italic { font-style: italic; }

        .logo-row {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin: 6px 0 8px 0;
        }
        .logo-section img { width: 55px; height: 55px; object-fit: contain; }
        .logo-section .secretariat { font-size: 9pt; font-weight: bold; margin-top: 3px; }
        .logo-section .services    { font-size: 9pt; }

        /* ══ TITRE ══ */
        .titre-bulletin {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            text-decoration: underline;
        }

        .mois-paie {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 12px;
            color: #0B1F3A;
        }

        /* ══ INFOS AGENT ══ */
        .agent-card {
            border: 1.5px solid #000;
            padding: 8px 12px;
            margin-bottom: 10px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px 20px;
            font-size: 9.5pt;
        }

        .agent-card .full-row { grid-column: 1 / -1; }

        .info-row {
            display: flex;
            align-items: baseline;
            gap: 4px;
        }
        .info-label { font-weight: bold; white-space: nowrap; min-width: 110px; }
        .info-value {
            flex: 1;
            border-bottom: 1px solid #555;
            min-height: 16px;
            padding-left: 3px;
            font-weight: bold;
            color: #0B1F3A;
        }

        /* ══ TABLEAU SALAIRE ══ */
        .salaire-wrap {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }

        .bloc-titre {
            background: #0B1F3A;
            color: #fff;
            font-weight: bold;
            font-size: 9pt;
            text-align: center;
            padding: 4px 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
        }

        table th {
            background: #e8ecf0;
            font-weight: bold;
            text-align: left;
            padding: 4px 6px;
            border: 1px solid #999;
            font-size: 8.5pt;
            text-transform: uppercase;
        }

        table th.right, table td.right { text-align: right; }

        table td {
            padding: 4px 6px;
            border: 1px solid #ccc;
            vertical-align: middle;
        }

        table tr:nth-child(even) { background: #f9f9f9; }

        .montant { font-weight: bold; text-align: right; font-family: "Courier New", monospace; }

        .total-row td {
            background: #0B1F3A;
            color: #fff;
            font-weight: bold;
            font-size: 10pt;
            border: 1px solid #0B1F3A;
        }

        .net-row td {
            background: #1A6B3A;
            color: #fff;
            font-weight: bold;
            font-size: 11pt;
            border: 1px solid #1A6B3A;
        }

        /* ══ RÉSUMÉ NET ══ */
        .net-section {
            border: 2px solid #0B1F3A;
            padding: 10px 16px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .net-label {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #0B1F3A;
            letter-spacing: 1px;
        }

        .net-montant {
            font-size: 16pt;
            font-weight: bold;
            color: #1A6B3A;
            font-family: "Courier New", monospace;
        }

        /* ══ SIGNATURE ══ */
        .signature-wrap {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 16px;
        }

        .signature-box {
            text-align: center;
            width: 45%;
        }

        .signature-box .sig-label {
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        .signature-box .sig-line {
            border-top: 1px solid #000;
            margin-top: 30px;
            padding-top: 4px;
            font-size: 8.5pt;
        }

        .mention {
            font-size: 8pt;
            color: #666;
            text-align: center;
            margin-top: 12px;
            font-style: italic;
            border-top: 1px solid #ccc;
            padding-top: 6px;
        }

        @media print {
            body { padding: 8px 16px; }
            @page { size: A4; margin: 10mm 15mm; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    @php
        $agent      = $bulletin->agent;
        $bareme     = $agent->baremeSalarial;
        $commune    = $agent->commune;
        $nomCommune = $commune?->nom_commune ?? 'Kouassi-Kouassikro';

        // Mois formaté
        $moisLabel = \Carbon\Carbon::createFromFormat('Y-m', $bulletin->mois_paie)
                        ->locale('fr')->isoFormat('MMMM YYYY');

        // ── Éléments bruts ──
        $salaireBase    = (float) ($bareme?->salaire_base    ?? 0);
        $salaireBrut    = (float) ($bareme?->salaire_brut    ?? 0);
        $indemResidence = (float) ($bareme?->indem_residence ?? 0);
        $indemTransp    = (float) ($agent->indem_transp      ?? 0);
        $indemFonction  = (float) ($agent->indem_fonction    ?? 0);
        $indemTechn     = (float) ($agent->indem_techn       ?? 0);

        // ── Cotisations / retenues ──
        $indemTranspCot = (float) ($bulletin->indem_transp_cotation ?? 0);
        $igr            = (float) ($bulletin->igr                   ?? 0);
        $impotSalaire   = (float) ($bulletin->impot_salaire         ?? 0);
        $contribNation  = (float) ($bulletin->contrib_nation        ?? 0);

        // ── Totaux ──
        $totalBrut = $salaireBase + $indemResidence + $indemTransp + $indemFonction + $indemTechn;
        $totalRetenues = $indemTranspCot + $igr + $impotSalaire + $contribNation;
        $netAPayer = $totalBrut - $totalRetenues;

        // Civilité
        $civilite = $agent->sexe_agent === 'F' ? 'Mme/Mlle' : 'M.';

        // Date
        $dateDoc = \Carbon\Carbon::now()->locale('fr')->isoFormat('DD MMMM YYYY');

        $fmt = fn($v) => number_format($v, 0, ',', ' ');
    @endphp

    {{-- ══ EN-TÊTE ══ --}}
    <div class="header-wrap">
        <div class="header-left">
            <div>DEPARTEMENT DE {{ Str::upper($nomCommune) }}</div>
            <div style="margin-left: 50px;">-----------</div>
            <div class="">COMMUNE DE {{ Str::upper($nomCommune) }}</div>
        </div>
        <div class="header-right">
            <div class="bold">REPUBLIQUE DE COTE D'IVOIRE</div>
            <div class="logo-zone">
                    @if(file_exists(public_path('storage/img/amoirie.png')))
                    <img src="{{ asset('storage/img/amoirie.png') }}" style="width: 55px; height: 55px;" alt="Logo">
                    @else
                    <div class="logo-placeholder">ARMES</div>
                    @endif
                </div>
            <div class="italic">Union-Discipline-Travail</div>
            <div>------------</div>
        </div>
    </div>

    <div class="logo-row">
        <div class="logo-section">
            <img src="{{ asset('storage/img/logo-mairie.png') }}" alt="Logo">
            <div class="secretariat">SECRETARIAT GENERAL</div>
            <div class="services">Services Administratifs</div>
        </div>
    </div>

    {{-- ══ TITRE ══ --}}
    <div class="titre-bulletin">Bulletin de Salaire</div>
    <div class="mois-paie">Période : {{ Str::upper($moisLabel) }}</div>

    {{-- ══ INFOS AGENT ══ --}}
    <div class="agent-card">
        <div class="full-row">
            <div class="info-row">
                <span class="info-label">Nom & Prénom :</span>
                <span class="info-value">{{ $civilite }} {{ $agent->nom_prenom_agent }}</span>
            </div>
        </div>
        <div class="info-row">
            <span class="info-label">Matricule :</span>
            <span class="info-value">{{ $agent->matricule ?? '—' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Qualification :</span>
            <span class="info-value">{{ $agent->qualification ?? '—' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Fonction :</span>
            <span class="info-value">{{ $agent->fonction ?? '—' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Service :</span>
            <span class="info-value">{{ $agent->service ?? '—' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Groupe :</span>
            <span class="info-value">{{ $agent->groupe ?? '—' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Échelon / Indice :</span>
            <span class="info-value">
                {{ $bareme?->echelon ?? '—' }} / {{ $bareme?->indice ?? '—' }}
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Chapitre paie :</span>
            <span class="info-value">{{ $agent->chapitre_paie ?? '—' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Article paie :</span>
            <span class="info-value">{{ $agent->article_paie ?? '—' }}</span>
        </div>
    </div>

    {{-- ══ ÉLÉMENTS DE SALAIRE ══ --}}
    <div class="salaire-wrap">

        {{-- Gains --}}
        <div>
            <div class="bloc-titre">Éléments de rémunération</div>
            <table>
                <thead>
                    <tr>
                        <th>Libellé</th>
                        <th class="right">Montant (FCFA)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Salaire de base</td>
                        <td class="montant">{{ $fmt($salaireBase) }}</td>
                    </tr>
                    <tr>
                        <td>Indemnité de résidence</td>
                        <td class="montant">{{ $fmt($indemResidence) }}</td>
                    </tr>
                    <tr>
                        <td>Indemnité de transport</td>
                        <td class="montant">{{ $fmt($indemTransp) }}</td>
                    </tr>
                    <tr>
                        <td>Indemnité de fonction</td>
                        <td class="montant">{{ $fmt($indemFonction) }}</td>
                    </tr>
                    <tr>
                        <td>Indemnité technique</td>
                        <td class="montant">{{ $fmt($indemTechn) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td>TOTAL BRUT</td>
                        <td class="montant">{{ $fmt($totalBrut) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Retenues --}}
        <div>
            <div class="bloc-titre">Retenues & Cotisations</div>
            <table>
                <thead>
                    <tr>
                        <th>Libellé</th>
                        <th class="right">Montant (FCFA)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Indem. transport (cotisation)</td>
                        <td class="montant">{{ $fmt($indemTranspCot) }}</td>
                    </tr>
                    <tr>
                        <td>IGR</td>
                        <td class="montant">{{ $fmt($igr) }}</td>
                    </tr>
                    <tr>
                        <td>Impôt sur salaire</td>
                        <td class="montant">{{ $fmt($impotSalaire) }}</td>
                    </tr>
                    <tr>
                        <td>Contribution nationale</td>
                        <td class="montant">{{ $fmt($contribNation) }}</td>
                    </tr>
                    <tr>
                        <td style="background:#fff;">&nbsp;</td>
                        <td style="background:#fff;">&nbsp;</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td>TOTAL RETENUES</td>
                        <td class="montant">{{ $fmt($totalRetenues) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

    {{-- ══ NET À PAYER ══ --}}
    <div class="net-section">
        <div class="net-label"> Net à payer</div>
        <div class="net-montant">{{ $fmt($netAPayer) }} FCFA</div>
    </div>

    {{-- ══ SIGNATURES ══ --}}
    <div class="signature-wrap">
        <div class="signature-box">
            <div class="sig-label">L'Agent</div>
            <div class="sig-line">Signature</div>
        </div>
        <div class="signature-box">
            <div class="sig-label">P/Le Maire et {{ $agent->commune?->nom_commune ?? '' }}</div>
            <div class="sig-line">{{ $dateDoc }}</div>
        </div>
    </div>

    {{-- Mention légale --}}
    <div class="mention">
        Ce bulletin de salaire est un document officiel délivré par la Mairie de {{ $nomCommune }}.
        À conserver soigneusement.
    </div>

    {{-- Bouton impression --}}
    <div style="text-align:center; margin-top:20px;" class="no-print">
        <button onclick="window.print()"
                style="padding: 10px 30px; background: #0B1F3A; color: white;
                       border: none; border-radius: 8px; font-size: 13px;
                       cursor: pointer; font-family: sans-serif;">
            🖨️ Imprimer le bulletin
        </button>
    </div>

</body>
</html>