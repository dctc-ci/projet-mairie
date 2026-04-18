<?php

namespace App\Http\Controllers\EtatCivils;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EtatCivil\AutreDeclaration;

class AutreDeclationController extends Controller
{
    public function index()
    {
        $autresDeclarations = AutreDeclaration::latest()->get();
        return view('etatcivils.autredeclarationpage', compact('autresDeclarations'));
    }
}
