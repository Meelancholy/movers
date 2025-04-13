<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Adjustment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EmployeeManagementSeeder extends Seeder
{
    public function run()
    {
        // Temporarily disable foreign key constraints
        Schema::disableForeignKeyConstraints();

        // Clear existing data in the correct order
        DB::table('employee_adjustment')->truncate();
        DB::table('adjustments')->truncate();
        DB::table('employees')->truncate();

        // Re-enable foreign key constraints
        Schema::enableForeignKeyConstraints();

        $employees = [
            // DRIVERS (30 active)
            [
                'first_name' => 'Antonio', 'last_name' => 'Manalo',
                'email' => 'antonio.manalo@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1985-01-10', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Rosa', 'last_name' => 'Dizon',
                'email' => 'rosa.dizon@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1987-03-25', 'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Eduardo', 'last_name' => 'Bautista',
                'email' => 'eduardo.bautista@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1983-05-12', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Lourdes', 'last_name' => 'Fernandez',
                'email' => 'lourdes.fernandez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1986-08-18', 'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Ricardo', 'last_name' => 'Gutierrez',
                'email' => 'ricardo.gutierrez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1981-11-30', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Teresa', 'last_name' => 'Castillo',
                'email' => 'teresa.castillo@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1984-02-14', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Fernando', 'last_name' => 'Ocampo',
                'email' => 'fernando.ocampo@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1982-07-22', 'job_type' => 'Part-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Carmen', 'last_name' => 'Reyes',
                'email' => 'carmen.reyes@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1988-04-05', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Ramon', 'last_name' => 'Aquino',
                'email' => 'ramon.aquino@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1980-09-17', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Amalia', 'last_name' => 'Cruz',
                'email' => 'amalia.cruz@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1989-12-03', 'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Alfredo', 'last_name' => 'Garcia',
                'email' => 'alfredo.garcia@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1983-06-28', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Corazon', 'last_name' => 'Lopez',
                'email' => 'corazon.lopez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1987-01-19', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Gregorio', 'last_name' => 'Santos',
                'email' => 'gregorio.santos@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1981-03-08', 'job_type' => 'Part-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Rosario', 'last_name' => 'Mendoza',
                'email' => 'rosario.mendoza@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1985-10-25', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Roberto', 'last_name' => 'Sanchez',
                'email' => 'roberto.sanchez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1984-07-14', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Imelda', 'last_name' => 'Torres',
                'email' => 'imelda.torres@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1986-05-30', 'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Armando', 'last_name' => 'Rivera',
                'email' => 'armando.rivera@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1982-11-11', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Lydia', 'last_name' => 'Gomez',
                'email' => 'lydia.gomez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1988-08-22', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Ernesto', 'last_name' => 'Diaz',
                'email' => 'ernesto.diaz@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1980-04-17', 'job_type' => 'Part-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Esperanza', 'last_name' => 'Ramos',
                'email' => 'esperanza.ramos@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1987-09-09', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Rodolfo', 'last_name' => 'Alvarez',
                'email' => 'rodolfo.alvarez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1983-12-24', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Gloria', 'last_name' => 'Romero',
                'email' => 'gloria.romero@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1985-02-28', 'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Arturo', 'last_name' => 'Chavez',
                'email' => 'arturo.chavez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1981-06-13', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Aurora', 'last_name' => 'Ortega',
                'email' => 'aurora.ortega@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1989-03-07', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Felipe', 'last_name' => 'Del Rosario',
                'email' => 'felipe.delrosario@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1984-10-31', 'job_type' => 'Part-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Beatriz', 'last_name' => 'Navarro',
                'email' => 'beatriz.navarro@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1986-07-16', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Victor', 'last_name' => 'Salazar',
                'email' => 'victor.salazar@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1982-01-23', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Consuelo', 'last_name' => 'Villanueva',
                'email' => 'consuelo.villanueva@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1988-04-04', 'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Hector', 'last_name' => 'Castro',
                'email' => 'hector.castro@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1980-08-09', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Rebecca', 'last_name' => 'Pineda',
                'email' => 'rebecca.pineda@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1987-11-12', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],

            // INACTIVE DRIVERS (10)
            [
                'first_name' => 'Carlos', 'last_name' => 'Lim',
                'email' => 'carlos.lim@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1982-07-14', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Lorna', 'last_name' => 'Gonzales',
                'email' => 'lorna.gonzales@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1989-09-05', 'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Raul', 'last_name' => 'Martinez',
                'email' => 'raul.martinez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1981-12-18', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Tessie', 'last_name' => 'Salcedo',
                'email' => 'tessie.salcedo@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1984-03-27', 'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Rogelio', 'last_name' => 'Estrada',
                'email' => 'rogelio.estrada@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1983-05-30', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Mercedes', 'last_name' => 'Cordero',
                'email' => 'mercedes.cordero@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1986-08-11', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Arnulfo', 'last_name' => 'Galang',
                'email' => 'arnulfo.galang@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1980-01-25', 'job_type' => 'Part-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Nenita', 'last_name' => 'Barrera',
                'email' => 'nenita.barrera@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1985-06-19', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Dominador', 'last_name' => 'Tuazon',
                'email' => 'dominador.tuazon@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1987-10-08', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Perla', 'last_name' => 'Samson',
                'email' => 'perla.samson@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver',
                'bdate' => '1982-02-14', 'job_type' => 'Part-time', 'gender' => 'Female'
            ],

            // OFFICE STAFF (60)
            // HR Team (4)
            [
                'first_name' => 'Maria', 'last_name' => 'Santos',
                'email' => 'maria.santos@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'HR', 'position' => 'HR Manager',
                'bdate' => '1985-08-22', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Luis', 'last_name' => 'Garcia',
                'email' => 'luis.garcia@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'HR', 'position' => 'Recruiter',
                'bdate' => '1990-04-15', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Elena', 'last_name' => 'Ramos',
                'email' => 'elena.ramos@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'HR', 'position' => 'Training Officer',
                'bdate' => '1988-11-30', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Daniel', 'last_name' => 'Lopez',
                'email' => 'daniel.lopez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'HR', 'position' => 'Payroll Officer',
                'bdate' => '1987-05-18', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // Logistics Team (2)
            [
                'first_name' => 'Ricardo', 'last_name' => 'Mendoza',
                'email' => 'ricardo.mendoza@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Logistics', 'position' => 'Fleet Manager',
                'bdate' => '1980-12-05', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Andrea', 'last_name' => 'Torres',
                'email' => 'andrea.torres@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Logistics', 'position' => 'Dispatch Coordinator',
                'bdate' => '1992-02-20', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],

            // Core Operations (2)
            [
                'first_name' => 'Jose', 'last_name' => 'Reyes',
                'email' => 'jose.reyes@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Operations Manager',
                'bdate' => '1978-06-10', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Carla', 'last_name' => 'Jimenez',
                'email' => 'carla.jimenez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Customer Support Lead',
                'bdate' => '1991-09-15', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],

            // Finance (1)
            [
                'first_name' => 'Sofia', 'last_name' => 'Lim',
                'email' => 'sofia.lim@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Finance', 'position' => 'Finance Officer',
                'bdate' => '1983-04-25', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],

            // Admin (1)
            [
                'first_name' => 'Gabriel', 'last_name' => 'Cruz',
                'email' => 'gabriel.cruz@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Admin', 'position' => 'Administrative Assistant',
                'bdate' => '1990-07-30', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // IT Team (5)
            [
                'first_name' => 'Juan', 'last_name' => 'Dela Cruz',
                'email' => 'juan.delacruz@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'IT', 'position' => 'Software Developer',
                'bdate' => '1990-05-15', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Liza', 'last_name' => 'Panganiban',
                'email' => 'liza.panganiban@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'IT', 'position' => 'System Administrator',
                'bdate' => '1988-07-22', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Mark', 'last_name' => 'Salvador',
                'email' => 'mark.salvador@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'IT', 'position' => 'Database Administrator',
                'bdate' => '1987-09-10', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Grace', 'last_name' => 'Perez',
                'email' => 'grace.perez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'IT', 'position' => 'UX Designer',
                'bdate' => '1991-03-28', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Ryan', 'last_name' => 'Ong',
                'email' => 'ryan.ong@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'IT', 'position' => 'Network Engineer',
                'bdate' => '1989-11-05', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // Marketing Team (4)
            [
                'first_name' => 'Patricia', 'last_name' => 'Gonzalez',
                'email' => 'patricia.gonzalez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Marketing', 'position' => 'Marketing Manager',
                'bdate' => '1986-04-12', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Albert', 'last_name' => 'Tan',
                'email' => 'albert.tan@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Marketing', 'position' => 'Digital Marketer',
                'bdate' => '1990-08-19', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Maricel', 'last_name' => 'Lazaro',
                'email' => 'maricel.lazaro@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Marketing', 'position' => 'Content Writer',
                'bdate' => '1987-01-25', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Arnel', 'last_name' => 'Ignacio',
                'email' => 'arnel.ignacio@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Marketing', 'position' => 'Graphic Designer',
                'bdate' => '1989-06-30', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // Customer Support (8)
            [
                'first_name' => 'Melissa', 'last_name' => 'Robles',
                'email' => 'melissa.robles@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent',
                'bdate' => '1992-02-15', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Ronald', 'last_name' => 'Sison',
                'email' => 'ronald.sison@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent',
                'bdate' => '1991-05-20', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Jennifer', 'last_name' => 'Mercado',
                'email' => 'jennifer.mercado@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent',
                'bdate' => '1990-09-10', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Dennis', 'last_name' => 'Reyes',
                'email' => 'dennis.reyes@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent',
                'bdate' => '1989-12-05', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Angelica', 'last_name' => 'Fuentes',
                'email' => 'angelica.fuentes@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent',
                'bdate' => '1993-03-18', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Marvin', 'last_name' => 'Dizon',
                'email' => 'marvin.dizon@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent',
                'bdate' => '1990-07-22', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Catherine', 'last_name' => 'Romero',
                'email' => 'catherine.romero@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent',
                'bdate' => '1991-10-30', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Allan', 'last_name' => 'Navarro',
                'email' => 'allan.navarro@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent',
                'bdate' => '1988-04-14', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // Accounting (3)
            [
                'first_name' => 'Roberto', 'last_name' => 'Gonzales',
                'email' => 'roberto.gonzales@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Accounting', 'position' => 'Accountant',
                'bdate' => '1985-11-08', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Susan', 'last_name' => 'Chua',
                'email' => 'susan.chua@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Accounting', 'position' => 'Bookkeeper',
                'bdate' => '1987-02-17', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Benedict', 'last_name' => 'Sy',
                'email' => 'benedict.sy@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Accounting', 'position' => 'Auditor',
                'bdate' => '1984-08-23', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // Legal (2)
            [
                'first_name' => 'Ramon', 'last_name' => 'Hizon',
                'email' => 'ramon.hizon@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Legal', 'position' => 'Legal Counsel',
                'bdate' => '1975-05-10', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Lourdes', 'last_name' => 'Manalo',
                'email' => 'lourdes.manalo@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Legal', 'position' => 'Compliance Officer',
                'bdate' => '1978-09-15', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],

            // Safety & Compliance (3)
            [
                'first_name' => 'Dante', 'last_name' => 'Silva',
                'email' => 'dante.silva@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Safety', 'position' => 'Safety Officer',
                'bdate' => '1980-12-20', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Marissa', 'last_name' => 'Lazatin',
                'email' => 'marissa.lazatin@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Safety', 'position' => 'Compliance Specialist',
                'bdate' => '1983-04-05', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Ricardo', 'last_name' => 'Molina',
                'email' => 'ricardo.molina@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Safety', 'position' => 'Vehicle Inspector',
                'bdate' => '1982-07-30', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // Executive Team (5)
            [
                'first_name' => 'Enrique', 'last_name' => 'Delgado',
                'email' => 'enrique.delgado@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Executive', 'position' => 'CEO',
                'bdate' => '1970-03-12', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Isabel', 'last_name' => 'Vasquez',
                'email' => 'isabel.vasquez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Executive', 'position' => 'COO',
                'bdate' => '1972-06-25', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Raul', 'last_name' => 'Hernandez',
                'email' => 'raul.hernandez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Executive', 'position' => 'CFO',
                'bdate' => '1973-09-18', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Carmen', 'last_name' => 'Reyes',
                'email' => 'carmen.reyes2@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Executive', 'position' => 'CTO',
                'bdate' => '1975-01-30', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Alfredo', 'last_name' => 'Santos',
                'email' => 'alfredo.santos@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Executive', 'position' => 'CMO',
                'bdate' => '1974-11-05', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // Additional Staff (To reach 60 office employees)
            [
                'first_name' => 'Ramon', 'last_name' => 'Gutierrez',
                'email' => 'ramon.gutierrez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Operations', 'position' => 'Operations Assistant',
                'bdate' => '1986-10-12', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Lourdes', 'last_name' => 'Bautista',
                'email' => 'lourdes.bautista@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'HR', 'position' => 'HR Assistant',
                'bdate' => '1989-02-28', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Fernando', 'last_name' => 'Marquez',
                'email' => 'fernando.marquez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Logistics', 'position' => 'Logistics Assistant',
                'bdate' => '1987-07-15', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Teresita', 'last_name' => 'Santiago',
                'email' => 'teresita.santiago@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Assistant',
                'bdate' => '1990-04-20', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Arturo', 'last_name' => 'Lopez',
                'email' => 'arturo.lopez@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'IT', 'position' => 'IT Support',
                'bdate' => '1988-12-10', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Rosalinda', 'last_name' => 'Garcia',
                'email' => 'rosalinda.garcia@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Admin', 'position' => 'Receptionist',
                'bdate' => '1991-05-25', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Eduardo', 'last_name' => 'Castro',
                'email' => 'eduardo.castro@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Marketing', 'position' => 'Marketing Assistant',
                'bdate' => '1989-08-18', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Imelda', 'last_name' => 'Reyes',
                'email' => 'imelda.reyes@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Finance', 'position' => 'Finance Assistant',
                'bdate' => '1987-11-30', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Rolando', 'last_name' => 'Mendoza',
                'email' => 'rolando.mendoza@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Safety', 'position' => 'Safety Assistant',
                'bdate' => '1986-03-15', 'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Gina', 'last_name' => 'Torres',
                'email' => 'gina.torres@company.com', 'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active', 'department' => 'Legal', 'position' => 'Legal Assistant',
                'bdate' => '1988-06-22', 'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Rafael',
                'last_name' => 'Basilio',
                'email' => 'rafael.basilio@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Operations',
                'position' => 'Driver',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Male'
            ],

            // 2. Customer Support (Operations)
            [
                'first_name' => 'Andrea',
                'last_name' => 'Cortez',
                'email' => 'andrea.cortez@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Operations',
                'position' => 'Customer Support',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Female'
            ],

            // 3. Dispatch Assistant (Logistics)
            [
                'first_name' => 'Marvin',
                'last_name' => 'Estrella',
                'email' => 'marvin.estrella@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Logistics',
                'position' => 'Dispatch Assistant',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Male'
            ],

            // 4. HR Assistant (HR)
            [
                'first_name' => 'Carla',
                'last_name' => 'Jimenez',
                'email' => 'carla.jimenez@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'HR',
                'position' => 'HR Assistant',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Female'
            ],

            // 5. Fleet Maintenance (Logistics)
            [
                'first_name' => 'Eduardo',
                'last_name' => 'Magsaysay',
                'email' => 'eduardo.magsaysay@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Logistics',
                'position' => 'Fleet Maintenance',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Male'
            ],

            // 6. Finance Clerk (Finance)
            [
                'first_name' => 'Lourdes',
                'last_name' => 'Natividad',
                'email' => 'lourdes.natividad@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Finance',
                'position' => 'Finance Clerk',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Female'
            ],

            // 7. Admin Assistant (Admin)
            [
                'first_name' => 'Romeo',
                'last_name' => 'Pascual',
                'email' => 'romeo.pascual@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Admin',
                'position' => 'Admin Assistant',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Male'
            ],

            // 8. Part-time Driver (Operations)
            [
                'first_name' => 'Teresita',
                'last_name' => 'Quizon',
                'email' => 'teresita.quizon@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Operations',
                'position' => 'Driver',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Part-time',
                'gender' => 'Female'
            ],

            // 9. Data Entry (Operations)
            [
                'first_name' => 'Samuel',
                'last_name' => 'Rubio',
                'email' => 'samuel.rubio@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Operations',
                'position' => 'Data Entry',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Male'
            ],

            // 10. Safety Assistant (Core)
            [
                'first_name' => 'Victoria',
                'last_name' => 'Sison',
                'email' => 'victoria.sison@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Support',
                'position' => 'Safety Assistant',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Female'
            ],
            [
                'first_name' => 'Benjamin',
                'last_name' => 'Tolentino',
                'email' => 'benjamin.tolentino@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Operations',
                'position' => 'Driver',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Male'
            ],

            // 2. Customer Support (Operations)
            [
                'first_name' => 'Danica',
                'last_name' => 'Umali',
                'email' => 'danica.umali@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Operations',
                'position' => 'Customer Support',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Female'
            ],

            // 3. Logistics - Vehicle Inspector
            [
                'first_name' => 'Christian',
                'last_name' => 'Villanueva',
                'email' => 'christian.villanueva@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Logistics',
                'position' => 'Vehicle Inspector',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Male'
            ],

            // 4. HR - Recruitment Assistant
            [
                'first_name' => 'Erica',
                'last_name' => 'Yabut',
                'email' => 'erica.yabut@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'HR',
                'position' => 'Recruitment Assistant',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Female'
            ],

            // 5. Finance - Billing Clerk
            [
                'first_name' => 'Francis',
                'last_name' => 'Zamora',
                'email' => 'francis.zamora@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Finance',
                'position' => 'Billing Clerk',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Male'
            ],

            // 6. Admin - Office Clerk
            [
                'first_name' => 'Giselle',
                'last_name' => 'Aguilar',
                'email' => 'giselle.aguilar@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Admin',
                'position' => 'Office Clerk',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Female'
            ],

            // 7. Operations - Night Shift Driver
            [
                'first_name' => 'Harold',
                'last_name' => 'Bautista',
                'email' => 'harold.bautista@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Operations',
                'position' => 'Driver',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Male'
            ],

            // 8. Core - Safety Monitor
            [
                'first_name' => 'Irene',
                'last_name' => 'Cruz',
                'email' => 'irene.cruz@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Support',
                'position' => 'Safety Monitor',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Female'
            ],

            // 9. Logistics - Fleet Assistant
            [
                'first_name' => 'Jerome',
                'last_name' => 'Dela Rosa',
                'email' => 'jerome.delarosa@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Logistics',
                'position' => 'Fleet Assistant',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Male'
            ],

            // 10. Operations - Reservation Specialist
            [
                'first_name' => 'Katherine',
                'last_name' => 'Evangelista',
                'email' => 'katherine.evangelista@company.com',
                'contact' => '09' . rand(10000000, 99999999),
                'status' => 'active',
                'department' => 'Operations',
                'position' => 'Reservation Specialist',
                'bdate' => now()->subYears(rand(21, 30))->format('Y-m-d'),
                'job_type' => 'Full-time',
                'gender' => 'Female'
            ]
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }

        // Seed Adjustments (make sure you have at least 3 adjustments)
        $adjustments = [
                [
                    'adjustment' => 'PhilHealth',
                    'rangestart' => 0,
                    'rangeend' => 10000,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '250.00' // Employee pays ONLY this
                ],
                // Salary ₱10,000.01 - ₱99,999.99 → Employee pays 2.5% (half of 5%)
                [
                    'adjustment' => 'PhilHealth',
                    'rangestart' => 10000.01,
                    'rangeend' => 99999.99,
                    'operation' => 'contribution',
                    'percentage' => '2.5', // 2.5% (employee's half of 5%)
                    'fixedamount' => null
                ],
                // Salary ≥ ₱100,000 → Employee pays ₱2,500 (half of ₱5,000)
                [
                    'adjustment' => 'PhilHealth',
                    'rangestart' => 100000,
                    'rangeend' => null,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '2500.00' // Employee pays ONLY this
                ],
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 0,
                    'rangeend' => 5249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '250.00'
                ],
                // ₱5,250 - ₱5,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 5250,
                    'rangeend' => 5749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '275.00'
                ],
                // ₱5,750 - ₱6,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 5750,
                    'rangeend' => 6249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '300.00'
                ],
                // ₱6,250 - ₱6,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 6250,
                    'rangeend' => 6749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '325.00'
                ],
                // ₱6,750 - ₱7,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 6750,
                    'rangeend' => 7249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '350.00'
                ],
                // ₱7,250 - ₱7,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 7250,
                    'rangeend' => 7749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '375.00'
                ],
                // ₱7,750 - ₱8,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 7750,
                    'rangeend' => 8249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '400.00'
                ],
                // ₱8,250 - ₱8,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 8250,
                    'rangeend' => 8749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '425.00'
                ],
                // ₱8,750 - ₱9,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 8750,
                    'rangeend' => 9249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '450.00'
                ],
                // ₱9,250 - ₱9,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 9250,
                    'rangeend' => 9749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '475.00'
                ],
                // ₱9,750 - ₱10,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 9750,
                    'rangeend' => 10249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '500.00'
                ],
                // ₱10,250 - ₱10,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 10250,
                    'rangeend' => 10749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '525.00'
                ],
                // ₱10,750 - ₱11,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 10750,
                    'rangeend' => 11249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '550.00'
                ],
                // ₱11,250 - ₱11,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 11250,
                    'rangeend' => 11749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '575.00'
                ],
                // ₱11,750 - ₱12,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 11750,
                    'rangeend' => 12249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '600.00'
                ],
                // ₱12,250 - ₱12,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 12250,
                    'rangeend' => 12749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '625.00'
                ],
                // ₱12,750 - ₱13,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 12750,
                    'rangeend' => 13249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '650.00'
                ],
                // ₱13,250 - ₱13,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 13250,
                    'rangeend' => 13749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '675.00'
                ],
                // ₱13,750 - ₱14,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 13750,
                    'rangeend' => 14249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '700.00'
                ],
                // ₱14,250 - ₱14,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 14250,
                    'rangeend' => 14749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '725.00'
                ],
                // ₱14,750 - ₱15,249.99 (EC increases to ₱30)
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 14750,
                    'rangeend' => 15249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '750.00'
                ],
                // ₱15,250 - ₱15,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 15250,
                    'rangeend' => 15749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '775.00'
                ],
                // ₱15,750 - ₱16,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 15750,
                    'rangeend' => 16249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '800.00'
                ],
                // ₱16,250 - ₱16,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 16250,
                    'rangeend' => 16749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '825.00'
                ],
                // ₱16,750 - ₱17,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 16750,
                    'rangeend' => 17249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '850.00'
                ],
                // ₱17,250 - ₱17,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 17250,
                    'rangeend' => 17749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '875.00'
                ],
                // ₱17,750 - ₱18,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 17750,
                    'rangeend' => 18249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '900.00'
                ],
                // ₱18,250 - ₱18,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 18250,
                    'rangeend' => 18749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '925.00'
                ],
                // ₱18,750 - ₱19,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 18750,
                    'rangeend' => 19249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '950.00'
                ],
                // ₱19,250 - ₱19,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 19250,
                    'rangeend' => 19749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '975.00'
                ],
                // ₱19,750 - ₱20,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 19750,
                    'rangeend' => 20249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1000.00'
                ],
                // ₱20,250 - ₱20,749.99 (MPF starts)
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 20250,
                    'rangeend' => 20749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1025.00' // ₱1,000 + ₱25 MPF
                ],
                // ₱20,750 - ₱21,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 20750,
                    'rangeend' => 21249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1050.00' // ₱1,000 + ₱50 MPF
                ],
                // ₱21,250 - ₱21,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 21250,
                    'rangeend' => 21749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1075.00' // ₱1,000 + ₱75 MPF
                ],
                // ₱21,750 - ₱22,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 21750,
                    'rangeend' => 22249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1100.00' // ₱1,000 + ₱100 MPF
                ],
                // ₱22,250 - ₱22,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 22250,
                    'rangeend' => 22749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1125.00' // ₱1,000 + ₱125 MPF
                ],
                // ₱22,750 - ₱23,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 22750,
                    'rangeend' => 23249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1150.00' // ₱1,000 + ₱150 MPF
                ],
                // ₱23,250 - ₱23,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 23250,
                    'rangeend' => 23749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1175.00' // ₱1,000 + ₱175 MPF
                ],
                // ₱23,750 - ₱24,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 23750,
                    'rangeend' => 24249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1200.00' // ₱1,000 + ₱200 MPF
                ],
                // ₱24,250 - ₱24,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 24250,
                    'rangeend' => 24749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1225.00' // ₱1,000 + ₱225 MPF
                ],
                // ₱24,750 - ₱25,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 24750,
                    'rangeend' => 25249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1250.00' // ₱1,000 + ₱250 MPF
                ],
                // ₱25,250 - ₱25,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 25250,
                    'rangeend' => 25749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1275.00' // ₱1,000 + ₱275 MPF
                ],
                // ₱25,750 - ₱26,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 25750,
                    'rangeend' => 26249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1300.00' // ₱1,000 + ₱300 MPF
                ],
                // ₱26,250 - ₱26,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 26250,
                    'rangeend' => 26749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1325.00' // ₱1,000 + ₱325 MPF
                ],
                // ₱26,750 - ₱27,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 26750,
                    'rangeend' => 27249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1350.00' // ₱1,000 + ₱350 MPF
                ],
                // ₱27,250 - ₱27,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 27250,
                    'rangeend' => 27749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1375.00' // ₱1,000 + ₱375 MPF
                ],
                // ₱27,750 - ₱28,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 27750,
                    'rangeend' => 28249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1400.00' // ₱1,000 + ₱400 MPF
                ],
                // ₱28,250 - ₱28,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 28250,
                    'rangeend' => 28749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1425.00' // ₱1,000 + ₱425 MPF
                ],
                // ₱28,750 - ₱29,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 28750,
                    'rangeend' => 29249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1450.00' // ₱1,000 + ₱450 MPF
                ],
                // ₱29,250 - ₱29,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 29250,
                    'rangeend' => 29749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1475.00' // ₱1,000 + ₱475 MPF
                ],
                // ₱29,750 - ₱30,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 29750,
                    'rangeend' => 30249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1500.00' // ₱1,000 + ₱500 MPF
                ],
                // ₱30,250 - ₱30,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 30250,
                    'rangeend' => 30749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1525.00' // ₱1,000 + ₱525 MPF
                ],
                // ₱30,750 - ₱31,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 30750,
                    'rangeend' => 31249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1550.00' // ₱1,000 + ₱550 MPF
                ],
                // ₱31,250 - ₱31,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 31250,
                    'rangeend' => 31749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1575.00' // ₱1,000 + ₱575 MPF
                ],
                // ₱31,750 - ₱32,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 31750,
                    'rangeend' => 32249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1600.00' // ₱1,000 + ₱600 MPF
                ],
                // ₱32,250 - ₱32,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 32250,
                    'rangeend' => 32749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1625.00' // ₱1,000 + ₱625 MPF
                ],
                // ₱32,750 - ₱33,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 32750,
                    'rangeend' => 33249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1650.00' // ₱1,000 + ₱650 MPF
                ],
                // ₱33,250 - ₱33,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 33250,
                    'rangeend' => 33749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1675.00' // ₱1,000 + ₱675 MPF
                ],
                // ₱33,750 - ₱34,249.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 33750,
                    'rangeend' => 34249.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1700.00' // ₱1,000 + ₱700 MPF
                ],
                // ₱34,250 - ₱34,749.99
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 34250,
                    'rangeend' => 34749.99,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1725.00' // ₱1,000 + ₱725 MPF
                ],
                // ₱34,750 and above (maximum adjustment)
                [
                    'adjustment' => 'SSS',
                    'rangestart' => 34750,
                    'rangeend' => null,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '1750.00' // ₱1,000 + ₱750 MPF (max)
                ],
                [
                    'adjustment' => 'PAGIBIG',
                    'rangestart' => 0,
                    'rangeend' => 1500,
                    'operation' => 'contribution',
                    'percentage' => 1,
                    'fixedamount' => 'null' // ₱1,000 + ₱750 MPF (max)
                ],
                [
                    'adjustment' => 'PAGIBIG',
                    'rangestart' => 1500,
                    'rangeend' => null,
                    'operation' => 'contribution',
                    'percentage' => null,
                    'fixedamount' => '200' // ₱1,000 + ₱750 MPF (max)
                ],
                [
                    'compensation' => '13TH MONTH PAY',
                    'rangestart' => 0,
                    'rangeend' => null,
                    'operation' => 'incentive',
                    'percentage' => 100,
                    'fixedamount' => null,
                ],
                [
                    'compensation' => 'PERFORMANCE BONUS',
                    'rangestart' => 0,
                    'rangeend' => null,
                    'operation' => 'incentive',
                    'percentage' => null,
                    'fixedamount' => null,
                ],
                [
                    'compensation' => 'MATERNITY LEAVE',
                    'rangestart' => 0,
                    'rangeend' => null,
                    'operation' => 'incentive',
                    'percentage' => null,
                    'fixedamount' => null,
                ],
                [
                    'compensation' => 'PATERNITY LEAVE',
                    'rangestart' => 0,
                    'rangeend' => null,
                    'operation' => 'incentive',
                    'percentage' => null,
                    'fixedamount' => null,
                ]
        ];

        foreach ($adjustments as $adjustment) {
            Adjustment::create($adjustment);
        }
    }
}
