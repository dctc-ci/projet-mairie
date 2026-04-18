<?php

namespace App\Http\Controllers\EtatCivils;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EtatCivil\Mariage;

class MariageController extends Controller
{
    public function index()
    {
        $mariages = Mariage::latest()->get();
        return view('etatcivils.mariagepage', compact('mariages'));
    }
}
