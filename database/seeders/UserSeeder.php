<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@reklamepro.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]
        );
        $admin->assignRole('super-admin');

        $editorUser = User::firstOrCreate(
            ['email' => 'editor@reklamepro.com'],
            [
                'name' => 'Editor',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]
        );
        $editorUser->assignRole('editor');

        if (!User::where('email', 'user@reklamepro.com')->exists()) {
            $user = User::factory()->create([
                'name' => 'Staff Admin',
                'email' => 'staff@reklamepro.com',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]);
            $user->assignRole('admin');
        }
    }
}
