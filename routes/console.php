<?php

use Illuminate\Foundation\Inspiring;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('mairie:install-superadmin', function () {
    if (User::query()->exists()) {
        $this->error('Installation impossible : un compte existe déjà.');
        $this->line('Utilisez la gestion des administrateurs dans l’application pour créer un autre compte.');

        return Command::FAILURE;
    }

    $name = $this->ask('Nom complet du superadministrateur');
    $email = $this->ask('Adresse e-mail');
    $password = $this->secret('Mot de passe (au moins 8 caractères)');
    $confirmation = $this->secret('Confirmez le mot de passe');

    if ($password !== $confirmation) {
        $this->error('Les mots de passe ne correspondent pas. Aucun compte n’a été créé.');

        return Command::FAILURE;
    }

    $data = Validator::make([
        'name' => $name,
        'email' => $email,
        'password' => $password,
    ], [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8'],
    ])->validate();

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => 'superadmin',
    ]);

    $user->forceFill(['email_verified_at' => now()])->save();

    $this->info("Le compte superadmin {$user->email} a été créé.");

    return Command::SUCCESS;
})->purpose('Create the first superadmin account during installation');
