<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'advertising_points.view',
            'advertising_points.create',
            'advertising_points.edit',
            'advertising_points.delete',
            'portfolios.view',
            'portfolios.create',
            'portfolios.edit',
            'portfolios.delete',
            'posts.view',
            'posts.create',
            'posts.edit',
            'posts.delete',
            'inquiries.view',
            'inquiries.edit',
            'inquiries.delete',
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'categories.view',
            'categories.create',
            'categories.edit',
            'categories.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $superAdmin = Role::findOrCreate('super-admin');
        $superAdmin->syncPermissions(Permission::all());

        $admin = Role::findOrCreate('admin');
        $admin->syncPermissions([
            'advertising_points.view', 'advertising_points.create', 'advertising_points.edit', 'advertising_points.delete',
            'portfolios.view', 'portfolios.create', 'portfolios.edit', 'portfolios.delete',
            'posts.view', 'posts.create', 'posts.edit', 'posts.delete',
            'inquiries.view', 'inquiries.edit', 'inquiries.delete',
            'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
        ]);

        $editor = Role::findOrCreate('editor');
        $editor->syncPermissions([
            'advertising_points.view', 'advertising_points.create', 'advertising_points.edit',
            'portfolios.view', 'portfolios.create', 'portfolios.edit',
            'posts.view', 'posts.create', 'posts.edit',
            'inquiries.view',
        ]);
    }
}
