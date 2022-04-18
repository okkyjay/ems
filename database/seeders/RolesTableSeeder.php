<?php

namespace Database\Seeders;

use App\EMS\Role\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'Super Admin',
            ],
        ];

        Role::insert($roles);
    }
}
