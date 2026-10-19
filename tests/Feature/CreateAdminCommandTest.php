<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateAdminCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_creates_an_administrator_account(): void
    {
        $this->artisan('cso:create-admin', [
            '--name' => 'Site Administrator',
            '--email' => 'site-admin@example.com',
            '--password' => 'correct-horse-battery',
        ])->assertExitCode(0);

        $user = User::query()->where('email', 'site-admin@example.com')->first();

        $this->assertNotNull($user);
        $this->assertSame('Site Administrator', $user->name);
        $this->assertTrue($user->is_admin);
        $this->assertTrue(Hash::check('correct-horse-battery', $user->password));
    }

    public function test_command_rejects_a_short_password(): void
    {
        $this->artisan('cso:create-admin', [
            '--name' => 'Site Administrator',
            '--email' => 'site-admin@example.com',
            '--password' => 'short',
        ])->assertExitCode(1);

        $this->assertDatabaseMissing('users', [
            'email' => 'site-admin@example.com',
        ]);
    }
}
