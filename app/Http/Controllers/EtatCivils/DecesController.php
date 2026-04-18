<?php

namespace App\Http\Controllers\EtatCivils;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EtatCivil\Deces;

class DecesController extends Controller
{
    public function index()
    {
        $deces = Deces::latest()->get();
        return view('etatcivils.decespage', compact('deces'));
    }
}
