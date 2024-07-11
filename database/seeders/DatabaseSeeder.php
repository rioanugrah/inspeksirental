<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10) >create();
        $permissions = [
            'Permission List',
            'Permission Create',
            'Permission Detail',
            'Permission Edit',
            'Permission Update',
            'Permission Delete',
            'Role List',
            'Role Create',
            'Role Detail',
            'Role Edit',
            'Role Update',
            'Role Delete',
            'User List',
            'User Create',
            'User Detail',
            'User Edit',
            'User Update',
            'User Delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
