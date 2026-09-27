<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SessionIdleTimeoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_are_logged_out_after_five_minutes_of_inactivity(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->withSession(['last_activity' => now()->subMinutes(5)->timestamp])
            ->get(route('personnels.dashboard'))
            ->assertRedirect(route('login'))
            ->assertSessionHas('status');

        $this->assertGuest();
    }

    public function test_users_remain_authenticated_while_active(): void
    {
        $response = $this->actingAs(User::factory()->create(['role' => 'utilisateur']))
            ->withSession(['last_activity' => now()->subMinute()->timestamp])
            ->get(route('personnels.dashboard'));

        $response->assertOk();
        $this->assertAuthenticated();
    }

    public function test_the_idle_timer_script_is_injected_into_authenticated_pages(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'utilisateur']))
            ->get(route('personnels.dashboard'))
            ->assertOk()
            ->assertSee('data-idle-timeout', false);
    }

    public function test_the_activity_timestamp_is_recorded_on_each_request(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'utilisateur']))
            ->get(route('personnels.dashboard'))
            ->assertOk()
            ->assertSessionHas('last_activity');
    }
}
