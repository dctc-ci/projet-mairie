<?php

namespace App\Http\Controllers\EtatCivils;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminEtatCivilController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('etatcivils.administrationpage', compact('users'));
    }
}
