<?php

namespace App\Http\Controllers\Personnels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personnel\BulletinSalaire;

class BulletinSalaireController extends Controller
{
    public function index()
    {
        $bulletinsalaires = BulletinSalaire::latest()->get();
        return view('personnels.bulletinsalaire', compact('bulletinsalaires'));
    }
}
