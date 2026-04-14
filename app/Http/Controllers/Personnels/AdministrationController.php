<?php

namespace App\Http\Controllers\Personnels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdministrationController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('personnels.administration', compact('users'));
    }
}
