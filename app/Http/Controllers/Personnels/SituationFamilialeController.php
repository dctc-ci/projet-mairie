<?php

namespace App\Http\Controllers\Personnels;

use App\Http\Controllers\Controller;
use App\Models\Personnel\SituationFamiliale;

class SituationFamilialeController extends Controller
{
    public function index()
    {
        $situations = SituationFamiliale::latest()->get();
        return view('personnels.situationfamiliale', compact('situations'));
    }
}