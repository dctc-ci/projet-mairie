<?php

namespace App\Http\Controllers\Personnels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personnel\Stagiaire;

class StagiaireController extends Controller
{
    public function index()
    {
        $stagiaires = Stagiaire::latest()->get();
        return view('personnels.stagiaire', compact('stagiaires'));
    }
}
