<?php

namespace Tests\Feature;

use App\Livewire\Personnels\CreateAdministration;
use App\Livewire\Personnels\CreateAgent;
use App\Livewire\Personnels\CreateAgentNonPermanent;
use App\Livewire\Personnels\CreateBaremeSalarial;
use App\Livewire\Personnels\CreateBulletinSalaire;
use App\Livewire\Personnels\CreateSituationFamiliale;
use App\Livewire\Personnels\CreateSollicitation;
use App\Livewire\Personnels\CreateStagiaire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class PersonnelAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadministrators_administrators_and_users_can_view_the_personnel_dashboard(): void
    {
        foreach (['superadmin', 'admin', 'utilisateur'] as $role) {
            $response = $this->actingAs(User::factory()->create(['role' => $role]))
                ->get(route('personnels.dashboard'));

            $response->assertOk();
        }
    }

    public function test_users_cannot_call_personnel_management_actions(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'utilisateur']));

        Livewire::test(CreateAgent::class)
            ->call('save')
            ->assertForbidden();

        Livewire::test(CreateAgent::class)
            ->call('confirmDelete')
            ->assertForbidden();
    }

    public function test_users_without_edit_rights_do_not_see_the_creation_button(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'utilisateur']));

        foreach (self::personnelComponents() as $component) {
            Livewire::test($component)
                ->assertDontSee('wire:click="openModal"', false);
        }
    }

    public function test_managers_see_the_creation_button(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        foreach (self::personnelComponents() as $component) {
            Livewire::test($component)
                ->assertSee('wire:click="openModal"', false);
        }
    }

    public function test_users_without_edit_rights_do_not_see_the_delete_and_edit_buttons(): void
    {
        $agentId = $this->createAgentWithDependencies();

        $this->actingAs(User::factory()->create(['role' => 'utilisateur']));

        Livewire::test(CreateAgent::class)
            ->call('viewAgent', $agentId)
            ->assertSet('showAgentModal', true)
            ->assertDontSee('wire:click="confirmDelete"', false)
            ->assertDontSee('wire:click="enableEditMode"', false);
    }

    public function test_managers_see_the_delete_and_edit_buttons(): void
    {
        $agentId = $this->createAgentWithDependencies();

        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(CreateAgent::class)
            ->call('viewAgent', $agentId)
            ->assertSet('showAgentModal', true)
            ->assertSee('wire:click="confirmDelete"', false)
            ->assertSee('wire:click="enableEditMode"', false);
    }

    public function test_sollicitation_files_open_in_read_only_mode_without_edit_rights(): void
    {
        $sollicitationId = $this->createSollicitation();

        $this->actingAs(User::factory()->create(['role' => 'utilisateur']));

        Livewire::test(CreateSollicitation::class)
            ->call('openFicheFromTable', $sollicitationId)
            ->assertSet('showFicheModal', true)
            ->assertSet('editMode', false);

        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(CreateSollicitation::class)
            ->call('openFicheFromTable', $sollicitationId)
            ->assertSet('showFicheModal', true)
            ->assertSet('editMode', true);
    }

    /**
     * Composants Livewire du module Personnels.
     *
     * @return array<int, class-string>
     */
    private static function personnelComponents(): array
    {
        return [
            CreateAgent::class,
            CreateAgentNonPermanent::class,
            CreateStagiaire::class,
            CreateSituationFamiliale::class,
            CreateSollicitation::class,
            CreateBaremeSalarial::class,
            CreateBulletinSalaire::class,
            CreateAdministration::class,
        ];
    }

    /**
     * Crée les données minimales (commune, barème, agent) car ces modèles n'ont pas encore de factory.
     */
    private function createAgentWithDependencies(): int
    {
        $communeId = DB::table('communes')->insertGetId([
            'nom_commune' => 'Mairie Test',
            'code_commune' => 'MT-001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $baremeId = DB::table('bareme_salarials')->insertGetId([
            'categorie' => 'A',
            'echelon' => '1',
            'indice' => 100,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return DB::table('agents')->insertGetId([
            'commune_id' => $communeId,
            'bareme_salarial_id' => $baremeId,
            'nom_prenom_agent' => 'Koné Jean',
            'date_naissance_agent' => '1990-01-01',
            'sexe_agent' => 'M',
            'matricule' => 'MAT-001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createSollicitation(): int
    {
        $agentId = $this->createAgentWithDependencies();

        return DB::table('sollicitations')->insertGetId([
            'agent_id' => $agentId,
            'type_sollicitation_id' => null,
            'etat_sollicitation' => 'en_attente',
            'date_sollicitation' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
