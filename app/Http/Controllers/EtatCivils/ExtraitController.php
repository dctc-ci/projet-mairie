<?php

namespace App\Http\Controllers\EtatCivils;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EtatCivil\Extrait;

class ExtraitController extends Controller
{
    public function index()
    {
        $naissances = Extrait::latest()->get();
        return view('etatcivils.extraitpage', compact('naissances'));
    }
}
