<?php

namespace App\Http\Controllers\Personnels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personnel\BaremeSalarial;

class BaremeSalarialController extends Controller
{
    public function index()
    {
        $baremesalarials = BaremeSalarial::latest()->get();
        return view('personnels.baremesalarial', compact('baremesalarials'));
    }
}
