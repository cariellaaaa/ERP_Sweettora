<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'employee_code' => 'EMP00001',
                'name' => 'John Doe',
                'email' => 'john.doe@sweettora.com',
                'phone' => '081234567890',
                'id_number' => '3201234567890001',
                'birth_date' => '1990-05-15',
                'gender' => 'male',
                'address' => 'Jl. Merdeka No. 123',
                'province_id' => 11, // DKI Jakarta
                'city_id' => 1171, // Jakarta Pusat
                'postal_code' => 10110,
                'position' => 'General Manager',
                'department' => 'Management',
                'hire_date' => '2020-01-15',
                'salary' => 15000000.00,
                'employment_status' => 'permanent',
                'status' => 'active',
            ],
            [
                'employee_code' => 'EMP00002',
                'name' => 'Jane Smith',
                'email' => 'jane.smith@sweettora.com',
                'phone' => '081234567891',
                'id_number' => '3201234567890002',
                'birth_date' => '1992-08-20',
                'gender' => 'female',
                'address' => 'Jl. Sudirman No. 456',
                'province_id' => 11,
                'city_id' => 1171,
                'postal_code' => 10220,
                'position' => 'Finance Manager',
                'department' => 'Finance',
                'hire_date' => '2020-03-01',
                'salary' => 12000000.00,
                'employment_status' => 'permanent',
                'status' => 'active',
            ],
            [
                'employee_code' => 'EMP00003',
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad.rizki@sweettora.com',
                'phone' => '081234567892',
                'id_number' => '3201234567890003',
                'birth_date' => '1995-03-10',
                'gender' => 'male',
                'address' => 'Jl. Gatot Subroto No. 789',
                'province_id' => 11,
                'city_id' => 1172, // Jakarta Timur
                'postal_code' => 13220,
                'position' => 'IT Supervisor',
                'department' => 'IT',
                'hire_date' => '2021-06-15',
                'salary' => 9000000.00,
                'employment_status' => 'permanent',
                'status' => 'active',
            ],
            [
                'employee_code' => 'EMP00004',
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@sweettora.com',
                'phone' => '081234567893',
                'id_number' => '3201234567890004',
                'birth_date' => '1993-11-25',
                'gender' => 'female',
                'address' => 'Jl. Thamrin No. 321',
                'province_id' => 11,
                'city_id' => 1171,
                'postal_code' => 10350,
                'position' => 'HR Manager',
                'department' => 'Human Resources',
                'hire_date' => '2020-09-01',
                'salary' => 10000000.00,
                'employment_status' => 'permanent',
                'status' => 'active',
            ],
            [
                'employee_code' => 'EMP00005',
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@sweettora.com',
                'phone' => '081234567894',
                'id_number' => '3201234567890005',
                'birth_date' => '1997-07-18',
                'gender' => 'male',
                'address' => 'Jl. Kuningan No. 654',
                'province_id' => 11,
                'city_id' => 1173, // Jakarta Selatan
                'postal_code' => 12940,
                'position' => 'Marketing Staff',
                'department' => 'Marketing',
                'hire_date' => '2022-01-10',
                'salary' => 6000000.00,
                'employment_status' => 'contract',
                'status' => 'active',
            ],
            [
                'employee_code' => 'EMP00006',
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@sweettora.com',
                'phone' => '081234567895',
                'id_number' => '3201234567890006',
                'birth_date' => '1998-12-05',
                'gender' => 'female',
                'address' => 'Jl. Rasuna Said No. 987',
                'province_id' => 11,
                'city_id' => 1173,
                'postal_code' => 12950,
                'position' => 'Accounting Staff',
                'department' => 'Finance',
                'hire_date' => '2023-03-15',
                'salary' => 5500000.00,
                'employment_status' => 'probation',
                'status' => 'active',
            ],
            [
                'employee_code' => 'EMP00007',
                'name' => 'Rudi Hermawan',
                'email' => 'rudi.hermawan@sweettora.com',
                'phone' => '081234567896',
                'id_number' => '3201234567890007',
                'birth_date' => '1996-04-22',
                'gender' => 'male',
                'address' => 'Jl. HR Rasuna Said No. 111',
                'province_id' => 11,
                'city_id' => 1174, // Jakarta Barat
                'postal_code' => 11410,
                'position' => 'Production Supervisor',
                'department' => 'Production',
                'hire_date' => '2021-11-20',
                'salary' => 8000000.00,
                'employment_status' => 'permanent',
                'status' => 'active',
            ],
            [
                'employee_code' => 'EMP00008',
                'name' => 'Maya Angelina',
                'email' => 'maya.angelina@sweettora.com',
                'phone' => '081234567897',
                'id_number' => '3201234567890008',
                'birth_date' => '1999-09-30',
                'gender' => 'female',
                'address' => 'Jl. Kebon Sirih No. 222',
                'province_id' => 11,
                'city_id' => 1171,
                'postal_code' => 10340,
                'position' => 'Intern',
                'department' => 'IT',
                'hire_date' => '2024-08-01',
                'salary' => 3000000.00,
                'employment_status' => 'internship',
                'status' => 'active',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
