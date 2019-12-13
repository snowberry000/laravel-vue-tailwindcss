<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class InsertRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Moderator']);
        Role::create(['name' => 'Contributor']);
    }
}
