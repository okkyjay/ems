<?php

namespace Database\Seeders;

use App\EMS\Department\Department;
use App\EMS\Designation\Designation;
use App\EMS\Employee\Employee;
use App\EMS\LeaveType\LeaveType;
use Illuminate\Database\Seeder;

class OthersTableSeeder extends Seeder
{
    public function run()
    {
        $department = [
            [
                'id'              => 1,
                'name'            => 'I.T',
                'status'           => '1',
            ],
        ];

        Department::insert($department);

        $designation = [
            [
                'id'              => 1,
                'name'            => 'CTO',
                'status'           => '1',
            ],
        ];

        Designation::insert($designation);

        $leaveType = [
            [
                'id'              => 1,
                'name'            => 'Annual',
                'status'           => '1',
            ],
        ];

        LeaveType::insert($leaveType);


        $employee = [
            [
                'id'              => 1,
                'first_name'            => 'Fikayo',
                'last_name'            => 'Adekunle',
                'email'            => 'fikayoadekunle@tonote.com',
                'password'            => bcrypt('password'),
                'phone_number'            => "0902022828",
                'employee_number'            => "TN2828",
                'gender' => 'male',
                'status'           => '1',
                'address'           => '21.....',
                'basic_salary'           => '10000',
                'department_id'           => '1',
                'designation_id'           => '1',
            ],
        ];

        Employee::insert($employee);
    }
}
