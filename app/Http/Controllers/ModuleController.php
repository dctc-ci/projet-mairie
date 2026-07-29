<?php

namespace App\Http\Controllers;

use App\Models\ModuleSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModuleController extends Controller
{
    private const MODULES = [
        ModuleSetting::PERSONNELS,
        ModuleSetting::ETAT_CIVIL,
        ModuleSetting::PRESTATIONS,
    ];

    public function dashboard(): View
    {
        $modules = collect(self::MODULES)
            ->mapWithKeys(fn (string $module) => [$module => ModuleSetting::enabled($module)]);

        return view('dashboard', compact('modules'));
    }

    public function update(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->role === 'superadmin', 403);

        $data = $request->validate([
            'modules' => ['array'],
            'modules.*' => ['string', 'in:'.implode(',', self::MODULES)],
        ]);

        foreach (self::MODULES as $module) {
            ModuleSetting::updateOrCreate(
                ['key' => $module],
                ['enabled' => in_array($module, $data['modules'] ?? [], true)]
            );
        }

        return back()->with('success', 'Les modules ont été mis à jour.');
    }
}
