<?php

namespace App\Http\Controllers\Personnels;

use App\Http\Controllers\Controller;
use App\Models\Personnel\Sollicitation;

class SollicitationController extends Controller
{
    public function index()
    {
        $sollicitations = Sollicitation::latest()->get();
        return view('personnels.sollicitation', compact('sollicitations'));
    }
}
