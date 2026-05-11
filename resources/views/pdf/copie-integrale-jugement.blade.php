<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Copie Intégrale J.S. - {{ strtoupper($extrait->nom_enfant ?? '') }} {{ $extrait->prenom_enfant ?? '' }}</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: "Times New Roman", Times, serif;
    font-size: 11px;
    background: #fff;
    color: #000;
}

.page {
    width: 210mm;
    height: 297mm;
    margin: 0 auto;
    padding: 10mm 12mm 8mm 12mm;
    background: #fff;
    position: relative;
    display: flex;
    flex-direction: column;
}

/* ── Filigrane centré ── */
.filigrane {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 170mm; height: 170mm;
    opacity: 0.07;
    z-index: 0;
    pointer-events: none;
}

.content {
    position: relative;
    z-index: 1;
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* ════════════════════════════════
   ENTÊTE : 2 colonnes côte à côte
   ════════════════════════════════ */
.entete {
    display: flex;
    align-items: flex-start;
    width: 100%;
}

/* ── Colonne gauche ── */
.col-gauche {
    width: 80mm;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    font-size: 10px;
}

.col-gauche .dept {
    font-weight: bold;
    font-size: 15px;
    text-transform: uppercase;
    letter-spacing: .2px;
    margin-bottom: 1px;
}
.col-gauche .tiret {
    font-size: 15px;
    color: #333;
    margin: 2px 0;
    margin-left: 30px;
    letter-spacing: 3px;
}
.col-gauche .commune {
    font-weight: bold;
    font-size: 15px;
    text-transform: uppercase;
    letter-spacing: .2px;
    margin-bottom: 4px;
}

.logo-wrap {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 100%;
    margin: 6px 0 4px 0;
}
.logo-wrap img {
    width: 60px;
    height: 60px;
    margin-left: 40px;
    object-fit: contain;
}
.logo-placeholder {
    width: 60px;
    height: 60px;
    border: 1px solid #aaa;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 7px;
    color: #aaa;
    margin-left: 40px;
}

.ec-title {
    font-weight: bold;
    font-size: 15px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-left: 30px;
    margin-top: 4px;
    text-align: left;
}
.ec-tiret {
    letter-spacing: 3px;
    font-size: 15px;
    margin: 2px 0;
    margin-left: 40px;
    color: #444;
}
.ec-centre {
    font-size: 15px;
    font-style: italic;
    margin-bottom: 2px;
    margin-left: 30px;
}

/* Bas colonne gauche */
.col-gauche-bas {
    margin-top: 20px;
    line-height: 1.9;
}
.registre-ref {
    font-weight: bold;
    font-size: 15px;
    white-space: nowrap;
    margin-bottom: 14px;
}
.naiss-label {
    font-size: 15px;
    margin-bottom: 8px;
}
.enfant-prenom {
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 6px;
    display: block;
}
.enfant-nom {
    font-weight: bold;
    font-size: 14px;
    display: block;
}

/* ── Bloc jugement supplétif (spécifique) ── */
.js-bloc {
    margin-top: 16px;
    padding-top: 10px;
    border-top: 1px solid #bbb;
    font-size: 13px;
    line-height: 1.7;
}
.js-label {
    font-weight: bold;
    font-size: 13px;
    margin-bottom: 10px;
    display: block;
}
.js-contenu {
    font-size: 13px;
    line-height: 1.7;
    color: #111;
}

/* ── Colonne droite ── */
.col-droite {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-left: 6mm;
}

.rep {
    font-weight: bold;
    font-size: 15px;
    text-transform: uppercase;
    letter-spacing: .3px;
    text-align: center;
    margin-bottom: 2px;
}
.rep-tiret {
    letter-spacing: 3px;
    font-size: 15px;
    text-align: center;
    color: #444;
    margin-bottom: 4px;
}

.titre-principal {
    font-weight: bold;
    font-size: 24px;
    letter-spacing: 4px;
    text-align: center;
    margin: 4px 0 2px 0;
    text-transform: uppercase;
}
.titre-sous {
    font-size: 17px;
    text-align: center;
    line-height: 1.6;
    margin-bottom: 4px;
}

/* ── Texte narratif ── */
.narration {
    width: 100%;
    margin-top: 20px;
    font-size: 17px;
    line-height: 1.3;
}
.narration .ligne {
    display: block;
}
.narration .ligne .b {
    font-weight: bold;
}
.narration .italic-note {
    font-style: italic;
    font-size: 14px;
    color: #333;
    margin: 4px 0;
    display: block;
}
.narration .copie-fidele {
    font-style: italic;
    font-size: 15px;
    margin-top: 4px;
    display: block;
}

/* ════════════════════════════════
   SÉPARATEUR DOUBLE LIGNE
   ════════════════════════════════ */
.double-sep {
    margin: 10px 0 8px 0;
    border-top: 2px solid #000;
    border-bottom: 1px solid #000;
    padding-bottom: 3px;
}

/* ════════════════════════════════
   MENTIONS
   ════════════════════════════════ */
.mentions-zone {
    font-size: 15px;
}
.mentions-titre {
    text-align: center;
    font-size: 18px;
    letter-spacing: 5px;
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 8px;
}
.m-line {
    display: flex;
    align-items: baseline;
    margin-bottom: 2px;
    font-size: 15px;
    line-height: 1.9;
}
.m-line .txt { flex-shrink: 0; }
.m-val-bold { font-weight: bold; margin: 0 1px; flex-shrink: 0; }
.m-dots-fill {
    flex: 1;
    border-bottom: 1px dotted #555;
    margin: 0 3px;
    min-width: 15px;
}

.cert-line {
    font-size: 15px;
    font-style: italic;
    margin-top: 6px;
}

/* ════════════════════════════════
   FOOTER
   ════════════════════════════════ */
.footer-zone {
    margin-top: 10px;
    display: flex;
    align-items: flex-start;
    gap: 8px;
}

.footer-gauche {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
    width: 52mm;
    flex-shrink: 0;
}
.timbre-box {
    width: 50mm;
    height: 36mm;
    border: 1px dashed #aaa;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 8px;
    color: #bbb;
    background: #fafafa;
}
.barcode-box {
    width: 50mm;
    height: 14mm;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #000;
    letter-spacing: -2px;
    font-family: "Courier New", monospace;
    border: 1px solid #ccc;
}

.footer-droite {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    font-size: 15px;
    gap: 6px;
}
.delivery-line {
    font-size: 15px;
    text-align: right;
}
.sig-zone {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 55mm;
}
.sig-title { font-size: 15px; font-style: italic; margin-bottom: 4px; }
.sig-image-box {
    width: 45mm;
    height: 24mm;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 8px;
    color: #bbb;
    font-style: italic;
}
.sig-label {
    font-size: 13px;
    font-style: italic;
    border-top: 1px solid #000;
    padding-top: 2px;
    padding-left: 8px;
    padding-right: 8px;
}

.officier-bas {
    margin-top: 6px;
    text-align: center;
    font-size: 13px;
    line-height: 1.6;
    border: 1px solid #999;
    padding: 4px 10px;
    display: inline-block;
}
.officier-bas .o-title { font-weight: bold; font-size: 14px; }

.ref-doc {
    font-size: 8px;
    color: #666;
    text-align: right;
    margin-top: 4px;
    font-style: italic;
}

/* ── Impression ── */
@media print {
    body { background: #fff; }
    .page { margin: 0; }
    .no-print { display: none !important; }
    @page { size: A4; margin: 0; }
}

.btn-print {
    position: fixed;
    top: 14px; right: 14px;
    background: #C8960C; color: #fff;
    border: none; border-radius: 10px;
    padding: 10px 18px; font-size: 13px;
    font-weight: bold; cursor: pointer;
    display: flex; align-items: center; gap: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,.2); z-index: 100;
}
.btn-print:hover { background: #a67a0a; }
</style>
</head>
<body>

<button class="btn-print no-print" onclick="window.print()">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659"/>
    </svg>
    Imprimer
</button>

@php
    $e       = $extrait;
    $commune = $e->commune;
    $fv      = fn($v) => $v ?? '';

    $communeNom = $commune?->nom_commune ?? '';
    $deptNom    = $commune?->departement ?? '';
    $centreName = $commune?->centre      ?? $communeNom;

    /* ── Tribunal ── */
    $tribunal = $e->tribunal ?? ('du Tribunal de ' . strtoupper($deptNom));

    /* ── Date naissance en lettres ── */
    $fmt = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);
    $dateNaissLettre     = '';
    $heure_min_naissance = '';

    if ($e->date_naissance) {
        $dn = \Carbon\Carbon::parse($e->date_naissance)->locale('fr');
        $dateNaissLettre =
            $fmt->format($dn->day) . ' ' .
            $dn->isoFormat('MMMM') . ' ' .
            $fmt->format($dn->year);
    }

    /* ── Heure en lettres ── */
    if (!empty($e->heure_min_naissance)) {
        $time = str_replace('H', ':', strtoupper($e->heure_min_naissance));
        [$hh, $mm] = array_pad(explode(':', $time), 2, 0);
        $hh = (int)$hh; $mm = (int)$mm;
        $hL = $fmt->format($hh) . ' heure' . ($hh > 1 ? 's' : '');
        $mL = $mm > 0 ? ' ' . $fmt->format($mm) . ' minute' . ($mm > 1 ? 's' : '') : '';
        $heure_min_naissance = $hL . $mL;
    }

    /* ── Date dressage ── */
    $dateRegistre = $e->date_dressage
        ? \Carbon\Carbon::parse($e->date_dressage)->format('d/m/Y')
        : '';

    /* ── Date dressage en lettres ── */
    $dateDressageLettre = '';
    if ($e->date_dressage) {
        $dd = \Carbon\Carbon::parse($e->date_dressage)->locale('fr');
        $dateDressageLettre =
            $fmt->format($dd->day) . ' ' .
            $dd->isoFormat('MMMM') . ' ' .
            $fmt->format($dd->year);
    }

    /* ── Fils / fille ── */
    $filsFille = ($e->sexe === 'F') ? 'fille de' : 'fils de';
    $estNe     = ($e->sexe === 'F') ? 'est née' : 'est né';

    /* ── Mentions ── */
    $mentions = $e->mentions ?? collect();
    $m1       = $mentions->first();

    $mVal  = fn($v) => $v ?: 'Néant';
    $mDate = fn($v) => $v
        ? \Carbon\Carbon::parse($v)->locale('fr')->isoFormat('DD MMMM YYYY')
        : 'Néant';

    /* ── Date livraison ── */
    $dateDeliv = \Carbon\Carbon::now()->locale('fr')->isoFormat('D MMMM YYYY');

    /* ── Ref document ── */
    $refDoc = strtolower(str_replace(' ', '', $communeNom)) . '.js' . date('dmY') . ($e->id ?? '');
@endphp

<div class="page">

    {{-- Filigrane --}}
    @if(file_exists(public_path('storage/img/amoirie.png')))
    <img src="{{ asset('storage/img/amoirie.png') }}" class="filigrane" alt="">
    @endif

    <div class="content">

        {{-- ══════════════════════════════
             ENTÊTE : Gauche + Droite
             ══════════════════════════════ --}}
        <div class="entete">

            {{-- ──────── Colonne GAUCHE ──────── --}}
            <div class="col-gauche">

                <div class="dept">DEPARTEMENT DE {{ strtoupper($communeNom) }}</div>
                <div class="tiret">--------</div>
                <div class="commune">COMMUNE DE {{ strtoupper($communeNom) }}</div>

                <div class="logo-wrap">
                    @if(file_exists(public_path('storage/img/logo-mairie.png')))
                        <img src="{{ asset('storage/img/logo-mairie.png') }}" alt="logo">
                    @elseif(file_exists(public_path('storage/img/amoirie.png')))
                        <img src="{{ asset('storage/img/amoirie.png') }}" alt="armoiries">
                    @else
                        <div class="logo-placeholder">LOGO</div>
                    @endif
                </div>

                <div class="ec-title">ETAT CIVIL</div>
                <div class="ec-tiret">--------</div>
                <div class="ec-centre">Centre de {{ $centreName }}</div>
                <div class="ec-tiret">--------</div>

                <div class="col-gauche-bas">

                    <div class="registre-ref">
                        N°{{ $fv($e->numero_act_extrai) }} DU {{ $dateRegistre }} DU REGISTRE
                    </div>

                    <div class="naiss-label">NAISSANCE DE</div>

                    <span class="enfant-prenom">{{ $fv($e->prenom_enfant) }}</span>
                    <span class="enfant-nom">{{ strtoupper($fv($e->nom_enfant)) }}.&nbsp;/</span>

                    {{-- ── Bloc jugement supplétif ── --}}
                    <div class="">
                        <span class="js-label">
                            Transcription du jugement supplétif d'acte de naissance N° {{ $fv($e->numero_act_extrai ?? 'Néant') }} Du {{ $fv($e->date_dressage_copie_integrale ?? 'Néant') }} rendu par la Section
                            {{ $tribunal }}
                        </span>
                        @if($fv($e->ment_jugem_supplet ?? ''))
                        <div class="js-contenu">
                            {{ $fv($e->ment_jugem_supplet) }}
                        </div>
                        @endif
                    </div>

                </div>

            </div>{{-- /col-gauche --}}

            {{-- ──────── Colonne DROITE ──────── --}}
            <div class="col-droite">

                <div class="rep">REPUBLIQUE DE COTE D'IVOIRE</div>
                <div class="rep-tiret">--------</div>

                <div class="titre-principal">COPIE INTÉGRALE</div>
                <div class="titre-sous">
                    Du registre des actes de l'Etat Civil<br>
                    Pour l'année&nbsp;&nbsp;<strong>{{ $fv($e->annee_registre_extrai) }}</strong>
                </div>

                {{-- ── Texte narratif ── --}}
                <div class="narration">

                    @if($dateNaissLettre)
                    <span class="ligne">
                        Le&nbsp;<span class="b">{{ $dateNaissLettre }}</span>&nbsp;./
                    </span>
                    @endif

                    @if($heure_min_naissance)
                    <span class="ligne">
                        à&nbsp;<span class="b">{{ $heure_min_naissance }}</span>&nbsp;./
                    </span>
                    @endif

                    <span class="ligne">
                        {{ $estNe }}&nbsp;<span class="b">{{ $fv($e->prenom_enfant) }}</span>&nbsp;./
                    </span>

                    @if($fv($e->lieux_naissance))
                    <span class="ligne">
                        à &nbsp;<span class="b">{{ $fv($e->lieux_naissance) }}</span>&nbsp;./
                    </span>
                    @endif

                    <span class="ligne">
                        Commune de&nbsp;<span class="b">{{ $communeNom }}</span>&nbsp;./
                    </span>

                    <span>
                        du Sexe&nbsp;<span class="b" style="margin-top: 6px; font-weight: bold;">{{ $fv($e->sexe) }}</span>&nbsp;./
                    </span>

                    {{-- ── PÈRE ── --}}
                    <span class="ligne">
                        Ayant pour père&nbsp;<span class="b">{{ $fv($e->nom_prenom_pere) }}</span>&nbsp;./
                    </span>

                    @if($fv($e->annee_naissance_pere))
                    <span class="ligne">
                        né&nbsp;<span class="b">{{ $fv($e->annee_naissance_pere) }}</span>&nbsp;./
                    </span>
                    @endif

                    @if($fv($e->lieu_naissance_pere))
                    <span class="ligne">
                        à&nbsp;<span class="b">{{ $fv($e->lieu_naissance_pere) }}</span>&nbsp;./
                    </span>
                    @endif

                    @if($fv($e->nationnalite_pere))
                    <span class="ligne">
                        nationalité&nbsp;<span class="b">{{ $fv($e->nationnalite_pere) }}</span>&nbsp;./
                    </span>
                    @endif

                    @if($fv($e->profession_pere))
                    <span class="ligne">
                        profession&nbsp;<span class="b">{{ $fv($e->profession_pere) }}</span>&nbsp;./
                    </span>
                    @endif

                    @if($fv($e->domicile_pere))
                    <span class="ligne">
                        domicilié à&nbsp;<span class="b">{{ $fv($e->domicile_pere) }}</span>&nbsp;./
                    </span>
                    @endif

                    {{-- ── MÈRE ── --}}
                    <span class="ligne">
                        et pour mère&nbsp;<span class="b">{{ $fv($e->nom_prenom_mere) }}</span>&nbsp;./
                    </span>

                    @if($fv($e->annee_naissance_mere))
                    <span class="ligne">
                        née&nbsp;<span class="b">{{ $fv($e->annee_naissance_mere) }}</span>&nbsp;./
                    </span>
                    @endif

                    @if($fv($e->lieu_naissance_mere ?? ''))
                    <span class="ligne">
                        à&nbsp;<span class="b">{{ $fv($e->lieu_naissance_mere) }}</span>&nbsp;./
                    </span>
                    @endif

                    @if($fv($e->nationalite_mere))
                    <span class="ligne">
                        nationalité&nbsp;<span class="b">{{ $fv($e->nationalite_mere) }}</span>&nbsp;./
                    </span>
                    @endif

                    @if($fv($e->profession_mere))
                    <span class="ligne">
                        profession&nbsp;<span class="b">{{ $fv($e->profession_mere) }}</span>&nbsp;./
                    </span>
                    @endif

                    @if($fv($e->domicile_mere))
                    <span class="ligne">
                        domiciliée à&nbsp;<span class="b">{{ $fv($e->domicile_mere) }}</span>&nbsp;./
                    </span>
                    @endif

                    {{-- ── Date de dressage (spécifique jugement) ── --}}
                    @if($dateDressageLettre)
                    <span class="ligne">
                        Dressé le&nbsp;<span class="b">{{ $dateDressageLettre }}</span>&nbsp;./
                    </span>
                    @endif

                    <span class="ligne">
                        à&nbsp;<span class="b">{{ $communeNom }}</span>&nbsp;./
                    </span>

                    {{-- ── Bas de l'acte (spécifique jugement) ── --}}
                    <span class="ligne">
                        Par nous.
                    </span>

                    <span class="ligne">
                        Officier de l'État-Civil de la Commune de&nbsp;<span class="b">{{ $communeNom }}</span>&nbsp;./
                    </span>

                    <span class="italic-note">
                        Après que le déclarant ait été averti des peines sanctionnant les fausses déclarations.
                    </span>

                    <span class="ligne">
                        Lecture faite, et le déclarant invité à lire l'acte.
                    </span>

                    <span class="ligne">
                        Nous avons signé.
                    </span>

                    <span class="italic-note">
                        (sur les registres suivent les signatures)
                    </span>

                    <span class="copie-fidele">
                        Pour copie certifiée conforme aux indications portées au registre
                    </span>

                </div>

            </div>{{-- /col-droite --}}

        </div>{{-- /entete --}}

        {{-- ══════════════════════════════
             FOOTER
             ══════════════════════════════ --}}
        <div class="footer-zone">

            {{-- Droite : livraison + signature + officier --}}
            <div class="footer-droite">

                <div class="delivery-line">
                    Délivré à&nbsp;<strong>{{ strtoupper($communeNom) }}</strong>&nbsp;,&nbsp;le&nbsp;{{ $dateDeliv }}
                </div>

                <div class="sig-zone">
                    <div class="sig-title">L'Officier de l'Etat civil</div>

                    @if(file_exists(public_path('storage/img/signature.png')))
                        <img src="{{ asset('storage/img/signature.png') }}"
                             style="width:45mm; height:24mm; object-fit:contain;">
                    @else
                        <div class="sig-image-box">(Signature)</div>
                    @endif

                    <span class="sig-label">(Signature)</span>
                </div>

                <div class="ref-doc">{{ $refDoc }}</div>

            </div>

        </div>{{-- /footer-zone --}}

    </div>{{-- /content --}}
</div>{{-- /page --}}

</body>
</html>