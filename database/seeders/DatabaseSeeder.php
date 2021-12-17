<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Coordinador',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'Aux',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'Contratista',
            'guard_name' => 'web'
        ]);
        User::factory(10)->create();
    }
}
