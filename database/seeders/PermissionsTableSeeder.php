<?php

namespace Database\Seeders;

use App\EMS\Permission\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'employee_access',
            ],
            [
                'id'    => 2,
                'title' => 'payroll_access',
            ],
            [
                'id'    => 3,
                'title' => 'leave_access',
            ],
            [
                'id'    => 4,
                'title' => 'complaint_access',
            ],
            [
                'id'    => 5,
                'title' => 'department_access',
            ],
            [
                'id'    => 6,
                'title' => 'country_access',
            ],
            [
                'id'    => 7,
                'title' => 'designation_access',
            ],
            [
                'id'    => 8,
                'title' => 'holiday_access',
            ],
            [
                'id'    => 9,
                'title' => 'leave_type_access',
            ],
            [
                'id'    => 10,
                'title' => 'message_access',
            ],
            [
                'id'    => 11,
                'title' => 'notification_access',
            ],
            [
                'id'    => 12,
                'title' => 'permission_access',
            ],
            [
                'id'    => 13,
                'title' => 'role_access',
            ],
            [
                'id'    => 14,
                'title' => 'state_access',
            ],
            [
                'id'    => 15,
                'title' => 'todo_access',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
