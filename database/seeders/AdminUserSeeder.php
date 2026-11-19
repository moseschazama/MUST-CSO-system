<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@must.ac.mw'],
            [
                'name' => 'MUST CSO Administrator',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ],
        );

        $admin->update(['is_admin' => true]);

        $this->command->info('Admin credentials: admin@must.ac.mw / password');
    }
}
