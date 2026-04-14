<?php

namespace App\Http\Controllers\Personnels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personnel\Agent;

class AgentPermanentController extends Controller
{
    public function index()
    {
        $agents = Agent::latest()->get();
        return view('personnels.agentpermanent', compact('agents'));
    }
}
