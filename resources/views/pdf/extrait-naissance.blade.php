<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Extrait de Naissance — {{ strtoupper($extrait->nom_enfant ?? '') }} {{ $extrait->prenom_enfant ?? '' }}</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; background:#fff; color:#000; }

.page {
    width: 210mm; height: 297mm;
    margin: 0 auto;
    padding: 8mm 10mm;
    background: #fff;
    display: flex; flex-direction: column;
    position: relative;
    overflow: hidden;
}

/* ── Filigrane ── */
.filigrane {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 160mm; height: 160mm;
    opacity: 0.07;
    z-index: 0;
    pointer-events: none;
}

.content { position: relative; z-index: 1; flex:1; display:flex; flex-direction:column; }

/* ── En-tête 2 colonnes ── */
.header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:4px; }
.header-left { flex:1; font-size:9px; line-height:1.5; }
.header-left .dept { font-weight:bold; text-decoration:underline; text-transform:uppercase; letter-spacing:.3px; }
.header-left .commune { font-weight:bold; text-decoration:underline; text-transform:uppercase; font-size:9.5px; }
.header-right { text-align:right; font-size:9px; line-height:1.5; }
.header-right .rep { font-weight:bold; text-transform:uppercase; letter-spacing:.3px; }
.header-right .devise { font-size:8.5px; text-decoration:underline; }

/* ── Logo / État-Civil ── */
.logo-zone { display:flex; flex-direction:column; align-items:center; margin: 3px 0; }
.logo-zone img { width:40px; height:40px; object-fit:contain; }
.logo-zone .ec { font-weight:bold; font-size:11px; text-transform:uppercase; letter-spacing:1px; margin-top:2px; }
.logo-zone .centre { font-size:8px; font-style:italic; color:#555; }

/* ── Titre document ── */
.titre-doc {
    text-align:center;
    border: 1px solid #000;
    padding: 5px 10px;
    margin: 4px 0;
}
.titre-doc .t1 { font-size:16px; font-weight:bold; text-transform:uppercase; letter-spacing:2px; }
.titre-doc .t2 { font-size:9px; margin-top:1px; }

/* ── Registre ── */
.registre-line {
    display:flex;
    align-items:center;
    border: 1px solid #000;
    border-top: none;
    padding: 3px 6px;
    font-size:9px;
    gap: 20px;
}
.registre-line .cell { display:flex; align-items:center; gap:4px; }
.registre-line .cell .underline-val {
    border-bottom: 1px solid #000;
    min-width: 40px;
    display:inline-block;
    padding: 0 3px;
}

/* ── Naissance de ── */
.naiss-header {
    border: 1px solid #000;
    border-top: none;
    display:flex;
}
.naiss-left {
    width: 60mm;
    border-right: 1px solid #000;
    padding: 4px 6px;
    font-size:10px;
    font-weight:bold;
    display:flex;
    align-items:center;
    justify-content:center;
    text-transform:uppercase;
    letter-spacing:1px;
}
.naiss-right {
    flex:1;
    padding: 3px 6px;
    font-size:9px;
    display:flex;
    align-items:center;
}

/* ── Corps principal (2 colonnes) ── */
.corps {
    border: 1px solid #000;
    border-top: none;
    display:flex;
    flex: 1;
}
.corps-left {
    width: 60mm;
    border-right: 1px solid #000;
    padding: 4px 6px;
    font-size:9px;
    line-height:2.2;
    position: relative;
}
.corps-right {
    flex:1;
    padding: 4px 8px;
    font-size:9px;
    line-height:2.2;
}
.val {
    border-bottom: 1px solid #000;
    display: inline-block;
    min-width: 70px;
    padding: 0 2px;
    font-weight: bold;
}
.val-long {
    border-bottom: 1px solid #000;
    display: inline-block;
    min-width: 120px;
    padding: 0 2px;
    font-weight: bold;
}

/* ── Mentions ── */
.mentions-section {
    border: 1px solid #000;
    border-top: none;
    padding: 5px 8px;
}
.mentions-title {
    text-align:center;
    font-weight:bold;
    font-size:11px;
    letter-spacing:4px;
    text-transform:uppercase;
    margin-bottom:4px;
    border-bottom: 1px solid #ccc;
    padding-bottom:2px;
}
.mention-line {
    font-size:9px;
    line-height:2.3;
    display:flex;
    align-items:baseline;
    gap:3px;
}
.m-dots {
    flex:1;
    border-bottom: 1px dotted #aaa;
    height:1em;
    margin: 0 3px;
    vertical-align:bottom;
}
.m-val { font-weight:bold; min-width:30px; display:inline-block; border-bottom:1px solid #000; }

/* ── Certification & Footer ── */
.certification {
    border: 1px solid #000;
    border-top: none;
    padding: 3px 8px;
    font-size:8.5px;
    font-style:italic;
    text-align:center;
}
.footer-doc {
    border: 1px solid #000;
    border-top: none;
    padding: 4px 8px;
    font-size:9px;
}
.footer-doc .lieu-date { margin-bottom:2px; }
.footer-doc .officier { font-weight:bold; text-align:center; margin-top:4px; }
.footer-doc .sig { font-style:italic; text-align:center; }

/* ── QR ── */
.qr-zone { margin-top:4px; }

/* ── Impression ── */
@media print {
    body { background:#fff; }
    .page { margin:0; }
    .no-print { display:none !important; }
    @page { size: A4; margin:0; }
}
.btn-print {
    position:fixed; top:14px; right:14px;
    background:#1A6B3A; color:#fff; border:none; border-radius:10px;
    padding:10px 18px; font-size:13px; font-weight:bold;
    cursor:pointer; display:flex; align-items:center; gap:8px;
    box-shadow:0 4px 12px rgba(0,0,0,.2); z-index:100;
}
.btn-print:hover { background:#155a30; }
</style>
</head>
<body>

<button class="btn-print no-print" onclick="window.print()">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"/>
    </svg>
    Imprimer
</button>

@php
    $e       = $extrait;
    $commune = $e->commune;
    $fd = fn($v) => $v ? \Carbon\Carbon::parse($v)->locale('fr')->isoFormat('DD MMMM YYYY') : '';
    $fv = fn($v) => $v ?? '';
    $dateAuj = \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY');
    $communeNom = $commune?->nom_commune ?? 'Kouassi-Kouassikro';
    $deptNom    = $commune?->departement ?? 'Kouassi-Kouassikro';

    // Mentions
    $mentions = $e->mentions ?? collect();
    $m1 = $mentions->first();
    $m2 = $mentions->skip(1)->first();
@endphp

<div class="page">

    {{-- Filigrane --}}
    @if(file_exists(public_path('storage/img/amoirie.png')))
    <img src="{{ asset('storage/img/amoirie.png') }}" class="filigrane" alt="">
    @endif

    <div class="content">

        {{-- ── En-tête ── --}}
        <div class="header">
            <div class="header-left">
                <div class="dept">DEPARTEMENT DE {{ strtoupper($deptNom) }}</div>
                <div class="commune">COMMUNE DE {{ strtoupper($communeNom) }}</div>
                @if(file_exists(public_path('storage/img/amoirie.png')))
                <div class="logo-zone">
                    <img src="{{ asset('storage/img/amoirie.png') }}" alt="">
                    <div class="ec">ETAT-CIVIL</div>
                    <div class="centre">Centre de {{ $communeNom }}</div>
                </div>
                @else
                <div class="logo-zone">
                    <div class="ec">ETAT-CIVIL</div>
                    <div class="centre">Centre de {{ $communeNom }}</div>
                </div>
                @endif
            </div>
            <div class="header-right">
                <div class="rep">REPUBLIQUE DE COTE D'IVOIRE</div>
                <div class="devise">-----------</div>
                <div style="margin-top:16px">
                    <div class="titre-doc">
                        <div class="t1">EXTRAIT</div>
                        <div class="t2">Du registre des actes de Naissance<br>pour l'année <strong>{{ $fv($e->annee_registre_extrai) }}</strong></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Registre ── --}}
        <div class="registre-line">
            <div class="cell">N° <span class="underline-val">{{ $fv($e->numero_act_extrai) }}</span></div>
            <div class="cell">Du <span class="underline-val">{{ $fd($e->date_dressage) }}</span></div>
            <div class="cell">DU REGISTRE</div>
        </div>

        {{-- ── Naissance de ── --}}
        <div class="naiss-header">
            <div class="naiss-left">NAISSANCE DE</div>
            <div class="naiss-right" style="font-weight:bold; font-size:11px; text-transform:uppercase; letter-spacing:.5px;">
                {{ $fv($e->nom_enfant) }} {{ $fv($e->prenom_enfant) }}
            </div>
        </div>

        {{-- ── Corps (2 colonnes) ── --}}
        <div class="corps">
            <div class="corps-left">
                <div>à</div>
                <div>est né</div>
                <div>l'enfant</div>
                <div>de Sexe</div>
                <div>de:</div>
                <div style="margin-top:4px;">Profession</div>
                <div>Domicilié à</div>
                <div>et de</div>
                <div>Profession</div>
                <div>Domiciliée à</div>
            </div>
            <div class="corps-right">
                <div><span class="val">{{ $fd($e->date_naissance) }}</span></div>
                <div><span class="val-long">{{ $fv($e->lieux_naissance) }}</span></div>
                <div><span class="val-long">{{ $fv($e->nom_prenom_pere) }}</span></div>
                <div><span class="val">{{ $e->sexe === 'M' ? 'Masculin' : ($e->sexe === 'F' ? 'Féminin' : '') }}</span></div>
                <div><span class="val-long">{{ $fv($e->nom_prenom_pere) }}</span></div>
                <div><span class="val">{{ $fv($e->profession_pere) }}</span></div>
                <div><span class="val-long">{{ $fv($e->domicile_pere) }}</span></div>
                <div><span class="val-long">{{ $fv($e->nom_prenom_mere) }}</span></div>
                <div><span class="val">{{ $fv($e->profession_mere) }}</span></div>
                <div><span class="val-long">{{ $fv($e->domicile_mere) }}</span></div>
            </div>
        </div>

        {{-- ── Mentions ── --}}
        <div class="mentions-section">
            <div class="mentions-title">M E N T I O N S &nbsp;&nbsp; (éventuellement)</div>
            <div class="mention-line">
                Marié(e) le <span class="m-val">{{ $m1 ? $fd($m1->date_mariage_mention) : '' }}</span>
                à <span class="m-dots"></span>
                N<span class="m-val">{{ $m1?->ref_act_dissous ?? '' }}</span>
            </div>
            <div class="mention-line">
                Avec <span class="m-dots"></span>
                à <span class="m-dots"></span>
            </div>
            <div class="mention-line">
                Mariage dissous par Décision de divorce en date du
                <span class="m-val">{{ $m1 ? $fd($m1->date_mariage_dissous) : '' }}</span>
                à <span class="m-dots"></span>
            </div>
            <div class="mention-line" style="margin-top:3px;">
                &nbsp;
                <span class="m-dots"></span>
            </div>
            <div class="mention-line">
                Décédé(e) le
                <span class="m-val">{{ $m1 ? $fd($m1->date_deces_mention) : '' }}</span>
                à <span class="m-dots"></span>
                l <span class="m-dots"></span>
            </div>
        </div>

        {{-- ── Certification ── --}}
        <div class="certification">
            Certifié le présent extrait conforme aux indications contenues dans le registre.
        </div>

        {{-- ── Footer ── --}}
        <div class="footer-doc">
            <div class="lieu-date">
                Délivré, le {{ $dateAuj }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                à {{ $communeNom }}
            </div>
            <div class="officier">L'Officier de l'Etat Civil</div>
            <div class="sig">(signature)</div>
            <div style="margin-top:6px; width:50px; height:50px; border:1px solid #ccc;"></div>
        </div>

        {{-- QR factice ── --}}
        <div class="qr-zone">
            <div style="width:50px; height:50px; border:2px solid #000; display:flex; align-items:center; justify-content:center; font-size:7px; color:#aaa;">QR</div>
        </div>

    </div>
</div>
</body>
</html>
