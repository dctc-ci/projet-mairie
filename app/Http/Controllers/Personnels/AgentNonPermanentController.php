<?php

namespace App\Http\Controllers\Personnels;

use App\Http\Controllers\Controller;
use App\Models\Personnel\AgentNonPermanent;

class AgentNonPermanentController extends Controller
{
    public function index()
    {
        $agents = AgentNonPermanent::latest()->get();
        return view('personnels.agentnonpermanent', compact('agents'));
    }
}
