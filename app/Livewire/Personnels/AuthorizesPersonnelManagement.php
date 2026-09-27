<?php

namespace App\Livewire\Personnels;

trait AuthorizesPersonnelManagement
{
    protected function authorizePersonnelManagement(): void
    {
        abort_unless(in_array(auth()->user()?->role, ['superadmin', 'admin'], true), 403);
    }

    public function getCanManagePersonnelProperty(): bool
    {
        return in_array(auth()->user()?->role, ['superadmin', 'admin'], true);
    }
}
