<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Copie Intégrale — {{ strtoupper($extrait->nom_enfant ?? '') }} {{ $extrait->prenom_enfant ?? '' }}</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: Arial, Helvetica, sans-serif; font-size:9.5px; background:#fff; color:#000; }
.page {
    width:210mm; height:297mm; margin:0 auto;
    padding:7mm 10mm; background:#fff;
    display:flex; flex-direction:column;
    position:relative; overflow:hidden;
}
.filigrane {
    position:absolute; top:50%; left:50%;
    transform:translate(-50%,-50%);
    width:155mm; height:155mm;
    opacity:0.06; z-index:0; pointer-events:none;
}
.content { position:relative; z-index:1; flex:1; display:flex; flex-direction:column; }

/* ── Header ── */
.header { display:flex; justify-content:space-between; align-items:flex-start; }
.hl { flex:1; }
.hl .dept { font-weight:bold; text-transform:uppercase; font-size:9px; text-decoration:underline; }
.hl .commune { font-weight:bold; text-transform:uppercase; font-size:9px; text-decoration:underline; }
.hr { text-align:right; }
.hr .rep { font-weight:bold; text-transform:uppercase; font-size:9px; }
.hr .dev { font-size:8px; text-decoration:underline; }
.hr .titre-ci { font-size:22px; font-weight:bold; text-transform:uppercase; margin-top:10px; letter-spacing:1px; }
.hr .sous-titre { font-size:9px; margin-top:2px; font-style:normal; }

.logo-ec { text-align:center; margin:4px 0; }
.logo-ec img { width:38px; height:38px; object-fit:contain; }
.logo-ec .ec { font-weight:bold; font-size:11px; text-transform:uppercase; letter-spacing:1px; }
.logo-ec .centre { font-size:8px; font-style:italic; color:#555; }

/* ── Registre ── */
.reg-line {
    border:1px solid #000; border-top:none;
    display:flex; gap:20px; padding:3px 6px; font-size:9px; align-items:center;
}
.uv { border-bottom:1px solid #000; min-width:35px; display:inline-block; padding:0 2px; }

/* ── Naissance de ── */
.naiss-bar {
    border:1px solid #000; border-top:none;
    display:flex;
}
.naiss-label {
    width:58mm; border-right:1px solid #000;
    padding:4px 6px; font-weight:bold; text-transform:uppercase;
    letter-spacing:1px; font-size:10px;
    display:flex; align-items:center; justify-content:center;
}
.naiss-nom {
    flex:1; padding:4px 8px;
    font-weight:bold; font-size:11px; text-transform:uppercase;
    display:flex; align-items:center;
}

/* ── Corps 2 colonnes ── */
.body-cols {
    border:1px solid #000; border-top:none;
    display:flex; flex:1;
}
.col-labels {
    width:58mm; border-right:1px solid #000;
    padding:4px 6px; font-size:9px;
    line-height:2.05;
}
.col-vals {
    flex:1; padding:4px 8px; font-size:9px;
    line-height:2.05;
}
.v { border-bottom:1px solid #000; min-width:60px; display:inline-block; padding:0 2px; font-weight:bold; }
.vl { border-bottom:1px solid #000; min-width:110px; display:inline-block; padding:0 2px; font-weight:bold; }

/* ── Bas de page ── */
.bas {
    border:1px solid #000; border-top:none;
    padding:5px 8px; font-size:9px; line-height:1.8;
}
.bas .par-nous { font-weight:bold; margin-bottom:3px; }
.bas .italic-line { font-style:italic; color:#c00; font-size:8.5px; }

.footer-doc {
    border:1px solid #000; border-top:none;
    padding:4px 8px; font-size:9px;
}
.footer-doc .sig { font-weight:bold; text-align:center; }

@media print {
    body { background:#fff; }
    .page { margin:0; }
    .no-print { display:none !important; }
    @page { size:A4; margin:0; }
}
.btn-print {
    position:fixed; top:14px; right:14px;
    background:#0B1F3A; color:#fff; border:none; border-radius:10px;
    padding:10px 18px; font-size:13px; font-weight:bold;
    cursor:pointer; display:flex; align-items:center; gap:8px;
    box-shadow:0 4px 12px rgba(0,0,0,.2); z-index:100;
}
.btn-print:hover { background:#0f2d56; }
</style>
</head>
<body>
<button class="btn-print no-print" onclick="window.print()">🖨 Imprimer</button>

@php
    $e = $extrait;
    $commune = $e->commune;
    $fd = fn($v) => $v ? \Carbon\Carbon::parse($v)->locale('fr')->isoFormat('DD MMMM YYYY') : '';
    $fv = fn($v) => $v ?? '';
    $dateAuj = \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY');
    $communeNom = $commune?->nom_commune ?? 'Kouassi-Kouassikro';
    $deptNom    = $commune?->departement ?? 'Kouassi-Kouassikro';
@endphp

<div class="page">
    @if(file_exists(public_path('storage/img/amoirie.png')))
    <img src="{{ asset('storage/img/amoirie.png') }}" class="filigrane" alt="">
    @endif

    <div class="content">
        <div class="header">
            <div class="hl">
                <div class="dept">DEPARTEMENT DE {{ strtoupper($deptNom) }}</div>
                <div class="commune">COMMUNE DE {{ strtoupper($communeNom) }}</div>
                <div class="logo-ec">
                    @if(file_exists(public_path('storage/img/amoirie.png')))
                    <img src="{{ asset('storage/img/amoirie.png') }}" alt="">
                    @endif
                    <div class="ec">ETAT-CIVIL</div>
                    <div class="centre">Centre de {{ $communeNom }}</div>
                </div>
            </div>
            <div class="hr">
                <div class="rep">REPUBLIQUE DE COTE D'IVOIRE</div>
                <div class="dev">-----------</div>
                <div class="titre-ci">COPIE INTEGRALE</div>
                <div class="sous-titre">Du registre des actes de Naissance<br>pour l'année <strong>{{ $fv($e->annee_registre_extrai) }}</strong></div>
            </div>
        </div>

        <div class="reg-line">
            <span>N° <span class="uv">{{ $fv($e->numero_act_extrai) }}</span></span>
            <span>Du <span class="uv">{{ $fd($e->date_dressage) }}</span></span>
            <span>DU REGISTRE</span>
        </div>

        <div class="naiss-bar">
            <div class="naiss-label">NAISSANCE DE</div>
            <div class="naiss-nom">{{ strtoupper($fv($e->nom_enfant)) }} {{ $fv($e->prenom_enfant) }}</div>
        </div>

        <div class="body-cols">
            <div class="col-labels">
                <div>A</div>
                <div>Est né</div>
                <div>Commune de {{ $communeNom }}</div>
                <div>L'enfant</div>
                <div>Du Sexe</div>
                <div>Ayant pour père</div>
                <div>Âgé de</div>
                <div>Né à</div>
                <div>Nationalité</div>
                <div>Profession</div>
                <div>Domicilié à</div>
                <div>et pour Mère</div>
                <div>Agée de</div>
                <div>Née à</div>
                <div>Nationalité</div>
                <div>Profession</div>
                <div>Domiciliée à</div>
                <div>L'Intéressé(e)</div>
                <div>la déclaration a été faite par :</div>
            </div>
            <div class="col-vals">
                <div><span class="v">{{ $fd($e->date_naissance) }}</span></div>
                <div><span class="vl">{{ $fv($e->lieux_naissance) }}</span></div>
                <div>&nbsp;</div>
                <div><span class="vl">{{ strtoupper($fv($e->nom_enfant)) }} {{ $fv($e->prenom_enfant) }}</span></div>
                <div><span class="v">{{ $e->sexe === 'M' ? 'Masculin' : ($e->sexe === 'F' ? 'Féminin' : '') }}</span></div>
                <div><span class="vl">{{ $fv($e->nom_prenom_pere) }}</span></div>
                <div><span class="v">{{ $fv($e->annee_naissance_pere) }}</span></div>
                <div><span class="vl">{{ $fv($e->lieu_naissance_pere) }}</span></div>
                <div><span class="v">{{ $fv($e->nationnalite_pere) }}</span></div>
                <div><span class="v">{{ $fv($e->profession_pere) }}</span></div>
                <div><span class="vl">{{ $fv($e->domicile_pere) }}</span></div>
                <div><span class="vl">{{ $fv($e->nom_prenom_mere) }}</span></div>
                <div><span class="v">{{ $fv($e->annee_naissance_mere) }}</span></div>
                <div><span class="vl">{{ $fv($e->lieu_naissance_mere ?? '') }}</span></div>
                <div><span class="v">{{ $fv($e->nationalite_mere) }}</span></div>
                <div><span class="v">{{ $fv($e->profession_mere) }}</span></div>
                <div><span class="vl">{{ $fv($e->domicile_mere) }}</span></div>
                <div><span class="vl">{{ $fv($e->info_declarant) }}</span></div>
                <div>&nbsp;</div>
            </div>
        </div>

        <div class="bas">
            <div>en présence des témoins</div>
            <div style="margin:3px 0;">&nbsp;</div>
            <div>et</div>
            <div style="margin:3px 0;">&nbsp;</div>
            <div class="italic-line">
                témoins qui ont attesté la sincérité de la déclaration. Le déclarant et les témoins ont été avertis des peines sanctionnant les fausses déclarations. Le présent acte a été dressé par nous.
            </div>
            <div style="margin-top:4px;">
                Officier de l'État-Civil de la Commune de {{ $communeNom }}
            </div>
            <div>le <span class="v">{{ $dateAuj }}</span></div>
            <div>en présence du déclarant et des témoins susnommés.</div>
            <div>Lecture faite, nous avons signé</div>
            <div class="italic-line">(sur les registres suivent les signatures)</div>
            <div>Pour copie fidèle conforme aux indications portées au registre</div>
        </div>

        <div class="footer-doc">
            <div>Délivré, le {{ $dateAuj }} &nbsp;&nbsp; à {{ $communeNom }}</div>
            <div class="sig">L'Officier de l'État Civil</div>
            <div style="text-align:center; font-style:italic;">(signature)</div>
        </div>

        <div style="margin-top:4px;">
            <div style="width:50px;height:50px;border:2px solid #000;display:flex;align-items:center;justify-content:center;font-size:7px;color:#aaa;">QR</div>
        </div>
    </div>
</div>
</body>
</html>
