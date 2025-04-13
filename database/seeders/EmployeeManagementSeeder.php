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

        // Seed Employees
        $employees = [
            // ====================== DRIVERS (40 TOTAL: 30 ACTIVE + 10 INACTIVE) ======================
            // Active Drivers (30)
            [
                'first_name' => 'Antonio', 'last_name' => 'Manalo', 'email' => 'antonio.manalo@company.com', 'contact' => '09171234001',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1985-01-10',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Rosa', 'last_name' => 'Dizon', 'email' => 'rosa.dizon@company.com', 'contact' => '09171234002',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1987-03-25',
                'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Eduardo', 'last_name' => 'Bautista', 'email' => 'eduardo.bautista@company.com', 'contact' => '09171234003',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1983-05-12',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Lourdes', 'last_name' => 'Fernandez', 'email' => 'lourdes.fernandez@company.com', 'contact' => '09171234004',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1986-08-18',
                'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Ricardo', 'last_name' => 'Gutierrez', 'email' => 'ricardo.gutierrez@company.com', 'contact' => '09171234005',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1981-11-30',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Teresa', 'last_name' => 'Castillo', 'email' => 'teresa.castillo@company.com', 'contact' => '09171234006',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1984-02-14',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Fernando', 'last_name' => 'Ocampo', 'email' => 'fernando.ocampo@company.com', 'contact' => '09171234007',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1982-07-22',
                'job_type' => 'Part-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Carment', 'last_name' => 'Reyes', 'email' => 'carment.reyes@company.com', 'contact' => '09171234008',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1988-04-05',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Ramon', 'last_name' => 'Aquino', 'email' => 'ramon.aquino@company.com', 'contact' => '09171234009',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1980-09-17',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Amalia', 'last_name' => 'Cruz', 'email' => 'amalia.cruz@company.com', 'contact' => '09171234010',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1989-12-03',
                'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Alfredo', 'last_name' => 'Garcia', 'email' => 'alfredo.garcia@company.com', 'contact' => '09171234011',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1983-06-28',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Corazon', 'last_name' => 'Lopez', 'email' => 'corazon.lopez@company.com', 'contact' => '09171234012',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1987-01-19',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Gregorio', 'last_name' => 'Santos', 'email' => 'gregorio.santos@company.com', 'contact' => '09171234013',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1981-03-08',
                'job_type' => 'Part-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Rosario', 'last_name' => 'Mendoza', 'email' => 'rosario.mendoza@company.com', 'contact' => '09171234014',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1985-10-25',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Roberto', 'last_name' => 'Sanchez', 'email' => 'roberto.sanchez@company.com', 'contact' => '09171234015',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1984-07-14',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Imelda', 'last_name' => 'Torres', 'email' => 'imelda.torres@company.com', 'contact' => '09171234016',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1986-05-30',
                'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Armando', 'last_name' => 'Rivera', 'email' => 'armando.rivera@company.com', 'contact' => '09171234017',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1982-11-11',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Lydia', 'last_name' => 'Gomez', 'email' => 'lydia.gomez@company.com', 'contact' => '09171234018',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1988-08-22',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Ernesto', 'last_name' => 'Diaz', 'email' => 'ernesto.diaz@company.com', 'contact' => '09171234019',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1980-04-17',
                'job_type' => 'Part-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Esperanza', 'last_name' => 'Ramos', 'email' => 'esperanza.ramos@company.com', 'contact' => '09171234020',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1987-09-09',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Rodolfo', 'last_name' => 'Alvarez', 'email' => 'rodolfo.alvarez@company.com', 'contact' => '09171234021',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1983-12-24',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Gloria', 'last_name' => 'Romero', 'email' => 'gloria.romero@company.com', 'contact' => '09171234022',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1985-02-28',
                'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Arturo', 'last_name' => 'Chavez', 'email' => 'arturo.chavez@company.com', 'contact' => '09171234023',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1981-06-13',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Aurora', 'last_name' => 'Ortega', 'email' => 'aurora.ortega@company.com', 'contact' => '09171234024',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1989-03-07',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Felipe', 'last_name' => 'Del Rosario', 'email' => 'felipe.delrosario@company.com', 'contact' => '09171234025',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1984-10-31',
                'job_type' => 'Part-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Beatriz', 'last_name' => 'Navarro', 'email' => 'beatriz.navarro@company.com', 'contact' => '09171234026',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1986-07-16',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Victor', 'last_name' => 'Salazar', 'email' => 'victor.salazar@company.com', 'contact' => '09171234027',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1982-01-23',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Consuelo', 'last_name' => 'Villanueva', 'email' => 'consuelo.villanueva@company.com', 'contact' => '09171234028',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1988-04-04',
                'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Hector', 'last_name' => 'Castro', 'email' => 'hector.castro@company.com', 'contact' => '09171234029',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1980-08-09',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Rebecca', 'last_name' => 'Pineda', 'email' => 'rebecca.pineda@company.com', 'contact' => '09171234030',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1987-11-12',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],

            // Inactive Drivers (10)
            [
                'first_name' => 'Carlos', 'last_name' => 'Lim', 'email' => 'carlos.lim@company.com', 'contact' => '09171234101',
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1982-07-14',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Lorna', 'last_name' => 'Gonzales', 'email' => 'lorna.gonzales@company.com', 'contact' => '09171234102',
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1989-09-05',
                'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Raul', 'last_name' => 'Martinez', 'email' => 'raul.martinez@company.com', 'contact' => '09171234103',
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1981-12-18',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Tessie', 'last_name' => 'Salcedo', 'email' => 'tessie.salcedo@company.com', 'contact' => '09171234104',
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1984-03-27',
                'job_type' => 'Part-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Rogelio', 'last_name' => 'Estrada', 'email' => 'rogelio.estrada@company.com', 'contact' => '09171234105',
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1983-05-30',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Mercedes', 'last_name' => 'Cordero', 'email' => 'mercedes.cordero@company.com', 'contact' => '09171234106',
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1986-08-11',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Arnulfo', 'last_name' => 'Galang', 'email' => 'arnulfo.galang@company.com', 'contact' => '09171234107',
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1980-01-25',
                'job_type' => 'Part-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Nenita', 'last_name' => 'Barrera', 'email' => 'nenita.barrera@company.com', 'contact' => '09171234108',
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1985-06-19',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Dominador', 'last_name' => 'Tuazon', 'email' => 'dominador.tuazon@company.com', 'contact' => '09171234109',
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1987-10-08',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Perla', 'last_name' => 'Samson', 'email' => 'perla.samson@company.com', 'contact' => '09171234110',
                'status' => 'inactive', 'department' => 'Operations', 'position' => 'Driver', 'bdate' => '1982-02-14',
                'job_type' => 'Part-time', 'gender' => 'Female'
            ],

            // ====================== OFFICE STAFF (60) ======================
            // HR Team (4)
            [
                'first_name' => 'Maria', 'last_name' => 'Santos', 'email' => 'maria.santos@company.com', 'contact' => '09187654321',
                'status' => 'active', 'department' => 'HR', 'position' => 'HR Manager', 'bdate' => '1985-08-22',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Luis', 'last_name' => 'Garcia', 'email' => 'luis.garcia@company.com', 'contact' => '09187654322',
                'status' => 'active', 'department' => 'HR', 'position' => 'Recruiter', 'bdate' => '1990-04-15',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Elena', 'last_name' => 'Ramos', 'email' => 'elena.ramos@company.com', 'contact' => '09187654323',
                'status' => 'active', 'department' => 'HR', 'position' => 'Training Officer', 'bdate' => '1988-11-30',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Daniel', 'last_name' => 'Lopez', 'email' => 'daniel.lopez@company.com', 'contact' => '09187654324',
                'status' => 'active', 'department' => 'HR', 'position' => 'Payroll Officer', 'bdate' => '1987-05-18',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // Logistics Team (2)
            [
                'first_name' => 'Ricardo', 'last_name' => 'Mendoza', 'email' => 'ricardo.mendoza@company.com', 'contact' => '09187777001',
                'status' => 'active', 'department' => 'Logistics', 'position' => 'Fleet Manager', 'bdate' => '1980-12-05',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Andrea', 'last_name' => 'Torres', 'email' => 'andrea.torres@company.com', 'contact' => '09187777002',
                'status' => 'active', 'department' => 'Logistics', 'position' => 'Dispatch Coordinator', 'bdate' => '1992-02-20',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],

            // Core Operations (Non-Driver Roles, 2)
            [
                'first_name' => 'Jose', 'last_name' => 'Reyes', 'email' => 'jose.reyes@company.com', 'contact' => '09187888001',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Operations Manager', 'bdate' => '1978-06-10',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Carla', 'last_name' => 'Jimenez', 'email' => 'carla.jimenez@company.com', 'contact' => '09187888002',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Customer Support Lead', 'bdate' => '1991-09-15',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],

            // Finance (1)
            [
                'first_name' => 'Sofia', 'last_name' => 'Lim', 'email' => 'sofia.lim@company.com', 'contact' => '09187999001',
                'status' => 'active', 'department' => 'Finance', 'position' => 'Finance Officer', 'bdate' => '1983-04-25',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],

            // Admin (1)
            [
                'first_name' => 'Gabriel', 'last_name' => 'Cruz', 'email' => 'gabriel.cruz@company.com', 'contact' => '09187000001',
                'status' => 'active', 'department' => 'Admin', 'position' => 'Administrative Assistant', 'bdate' => '1990-07-30',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // IT Team (5)
            [
                'first_name' => 'Juan', 'last_name' => 'Dela Cruz', 'email' => 'juan.delacruz@company.com', 'contact' => '09171234567',
                'status' => 'active', 'department' => 'IT', 'position' => 'Software Developer', 'bdate' => '1990-05-15',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Liza', 'last_name' => 'Panganiban', 'email' => 'liza.panganiban@company.com', 'contact' => '09171234568',
                'status' => 'active', 'department' => 'IT', 'position' => 'System Administrator', 'bdate' => '1988-07-22',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Mark', 'last_name' => 'Salvador', 'email' => 'mark.salvador@company.com', 'contact' => '09171234569',
                'status' => 'active', 'department' => 'IT', 'position' => 'Database Administrator', 'bdate' => '1987-09-10',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Grace', 'last_name' => 'Perez', 'email' => 'grace.perez@company.com', 'contact' => '09171234570',
                'status' => 'active', 'department' => 'IT', 'position' => 'UX Designer', 'bdate' => '1991-03-28',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Ryan', 'last_name' => 'Ong', 'email' => 'ryan.ong@company.com', 'contact' => '09171234571',
                'status' => 'active', 'department' => 'IT', 'position' => 'Network Engineer', 'bdate' => '1989-11-05',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // Marketing Team (4)
            [
                'first_name' => 'Patricia', 'last_name' => 'Gonzalez', 'email' => 'patricia.gonzalez@company.com', 'contact' => '09171333001',
                'status' => 'active', 'department' => 'Marketing', 'position' => 'Marketing Manager', 'bdate' => '1986-04-12',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Albert', 'last_name' => 'Tan', 'email' => 'albert.tan@company.com', 'contact' => '09171333002',
                'status' => 'active', 'department' => 'Marketing', 'position' => 'Digital Marketer', 'bdate' => '1990-08-19',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Maricel', 'last_name' => 'Lazaro', 'email' => 'maricel.lazaro@company.com', 'contact' => '09171333003',
                'status' => 'active', 'department' => 'Marketing', 'position' => 'Content Writer', 'bdate' => '1987-01-25',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Arnel', 'last_name' => 'Ignacio', 'email' => 'arnel.ignacio@company.com', 'contact' => '09171333004',
                'status' => 'active', 'department' => 'Marketing', 'position' => 'Graphic Designer', 'bdate' => '1989-06-30',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // Customer Support (8)
            [
                'first_name' => 'Melissa', 'last_name' => 'Robles', 'email' => 'melissa.robles@company.com', 'contact' => '09171444001',
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent', 'bdate' => '1992-02-15',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Ronald', 'last_name' => 'Sison', 'email' => 'ronald.sisons@company.com', 'contact' => '09171444002',
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent', 'bdate' => '1991-05-20',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Jennifer', 'last_name' => 'Mercado', 'email' => 'jennifer.mercado@company.com', 'contact' => '09171444003',
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent', 'bdate' => '1990-09-10',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Dennis', 'last_name' => 'Reyes', 'email' => 'dennis.reyes@company.com', 'contact' => '09171444004',
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent', 'bdate' => '1989-12-05',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Angelica', 'last_name' => 'Fuentes', 'email' => 'angelica.fuentes@company.com', 'contact' => '09171444005',
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent', 'bdate' => '1993-03-18',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Marvin', 'last_name' => 'Dizon', 'email' => 'marvin.dizon@company.com', 'contact' => '09171444006',
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent', 'bdate' => '1990-07-22',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Catherine', 'last_name' => 'Romero', 'email' => 'catherine.romero@company.com', 'contact' => '09171444007',
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent', 'bdate' => '1991-10-30',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Allan', 'last_name' => 'Navarro', 'email' => 'allan.navarro@company.com', 'contact' => '09171444008',
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Agent', 'bdate' => '1988-04-14',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // Accounting (3)
            [
                'first_name' => 'Roberto', 'last_name' => 'Gonzales', 'email' => 'roberto.gonzales@company.com', 'contact' => '09171555001',
                'status' => 'active', 'department' => 'Accounting', 'position' => 'Accountant', 'bdate' => '1985-11-08',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Susan', 'last_name' => 'Chua', 'email' => 'susan.chua@company.com', 'contact' => '09171555002',
                'status' => 'active', 'department' => 'Accounting', 'position' => 'Bookkeeper', 'bdate' => '1987-02-17',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Benedict', 'last_name' => 'Sy', 'email' => 'benedict.sy@company.com', 'contact' => '09171555003',
                'status' => 'active', 'department' => 'Accounting', 'position' => 'Auditor', 'bdate' => '1984-08-23',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // Legal (2)
            [
                'first_name' => 'Atty. Ramon', 'last_name' => 'Hizon', 'email' => 'ramon.hizons@company.com', 'contact' => '09171666001',
                'status' => 'active', 'department' => 'Legal', 'position' => 'Legal Counsel', 'bdate' => '1975-05-10',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Atty. Lourdes', 'last_name' => 'Manalo', 'email' => 'lourdes.manale@company.com', 'contact' => '09171666002',
                'status' => 'active', 'department' => 'Legal', 'position' => 'Compliance Officer', 'bdate' => '1978-09-15',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],

            // Safety & Compliance (3)
            [
                'first_name' => 'Dante', 'last_name' => 'Silva', 'email' => 'dante.silva@company.com', 'contact' => '09171777001',
                'status' => 'active', 'department' => 'Safety', 'position' => 'Safety Officer', 'bdate' => '1980-12-20',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Marissa', 'last_name' => 'Lazatin', 'email' => 'marissa.lazatin@company.com', 'contact' => '09171777002',
                'status' => 'active', 'department' => 'Safety', 'position' => 'Compliance Specialist', 'bdate' => '1983-04-05',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Ricardo', 'last_name' => 'Molina', 'email' => 'ricardo.molina@company.com', 'contact' => '09171777003',
                'status' => 'active', 'department' => 'Safety', 'position' => 'Vehicle Inspector', 'bdate' => '1982-07-30',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // Executive Team (5)
            [
                'first_name' => 'Enrique', 'last_name' => 'Delgado', 'email' => 'enriquezdelgado@company.com', 'contact' => '09171888001',
                'status' => 'active', 'department' => 'Executive', 'position' => 'CEO', 'bdate' => '1970-03-12',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Isabel', 'last_name' => 'Vasquez', 'email' => 'isabela.vasquez@company.com', 'contact' => '09171888002',
                'status' => 'active', 'department' => 'Executive', 'position' => 'COO', 'bdate' => '1972-06-25',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Raul', 'last_name' => 'Hernandez', 'email' => 'raul.hernandez@company.com', 'contact' => '09171888003',
                'status' => 'active', 'department' => 'Executive', 'position' => 'CFO', 'bdate' => '1973-09-18',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Carmen', 'last_name' => 'Reyes', 'email' => 'carmen.reyes@company.com', 'contact' => '09171888004',
                'status' => 'active', 'department' => 'Executive', 'position' => 'CTO', 'bdate' => '1975-01-30',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Alfredoes', 'last_name' => 'Santos', 'email' => 'alfredoes.santos@company.com', 'contact' => '09171888005',
                'status' => 'active', 'department' => 'Executive', 'position' => 'CMO', 'bdate' => '1974-11-05',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],

            // Additional Staff (To reach 60 office employees)
            [
                'first_name' => 'Ramon', 'last_name' => 'Gutierrez', 'email' => 'ramon.gutierrez@company.com', 'contact' => '09171999001',
                'status' => 'active', 'department' => 'Operations', 'position' => 'Operations Assistant', 'bdate' => '1986-10-12',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Lourdes', 'last_name' => 'Bautista', 'email' => 'lourdes.bautista@company.com', 'contact' => '09171999002',
                'status' => 'active', 'department' => 'HR', 'position' => 'HR Assistant', 'bdate' => '1989-02-28',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Fernandoes', 'last_name' => 'Marquez', 'email' => 'fernandoes.marquez@company.com', 'contact' => '09171999003',
                'status' => 'active', 'department' => 'Logistics', 'position' => 'Logistics Assistant', 'bdate' => '1987-07-15',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Teresita', 'last_name' => 'Santiago', 'email' => 'teresitat.santiago@company.com', 'contact' => '09171999004',
                'status' => 'active', 'department' => 'Customer Support', 'position' => 'Support Assistant', 'bdate' => '1990-04-20',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Arturo', 'last_name' => 'Lopez', 'email' => 'arturo.lopez@company.com', 'contact' => '09171999005',
                'status' => 'active', 'department' => 'IT', 'position' => 'IT Support', 'bdate' => '1988-12-10',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Rosalinda', 'last_name' => 'Garcia', 'email' => 'rosalinda.garcia@company.com', 'contact' => '09171999006',
                'status' => 'active', 'department' => 'Admin', 'position' => 'Receptionist', 'bdate' => '1991-05-25',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Eduardo', 'last_name' => 'Castro', 'email' => 'eduardo.castro@company.com', 'contact' => '09171999007',
                'status' => 'active', 'department' => 'Marketing', 'position' => 'Marketing Assistant', 'bdate' => '1989-08-18',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Imelda', 'last_name' => 'Reyes', 'email' => 'imelda.reyes@company.com', 'contact' => '09171999008',
                'status' => 'active', 'department' => 'Finance', 'position' => 'Finance Assistant', 'bdate' => '1987-11-30',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ],
            [
                'first_name' => 'Rolando', 'last_name' => 'Mendoza', 'email' => 'rolando.mendoza@company.com', 'contact' => '09171999009',
                'status' => 'active', 'department' => 'Safety', 'position' => 'Safety Assistant', 'bdate' => '1986-03-15',
                'job_type' => 'Full-time', 'gender' => 'Male'
            ],
            [
                'first_name' => 'Gina', 'last_name' => 'Torres', 'email' => 'gina.torres@company.com', 'contact' => '09171999010',
                'status' => 'active', 'department' => 'Legal', 'position' => 'Legal Assistant', 'bdate' => '1988-06-22',
                'job_type' => 'Full-time', 'gender' => 'Female'
            ]
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }

        // Seed Adjustments (make sure you have at least 3 adjustments)
        $adjustments = [
            [
                'adjustment' => 'Transportation Allowance',
                'rangestart' => null,
                'rangeend' => null,
                'operation' => 'incentive',
                'percentage' => null,
                'fixedamount' => '1500.00'
            ],
            [
                'adjustment' => 'Meal Allowance',
                'rangestart' => null,
                'rangeend' => null,
                'operation' => 'incentive',
                'percentage' => null,
                'fixedamount' => '2000.00'
            ],
            [
                'adjustment' => 'Tax Deduction',
                'rangestart' => '10000',
                'rangeend' => '50000',
                'operation' => 'deduction',
                'percentage' => '5.00',
                'fixedamount' => null
            ],
            [
                'adjustment' => 'SSS Contribution',
                'rangestart' => null,
                'rangeend' => null,
                'operation' => 'deduction',
                'percentage' => '4.50',
                'fixedamount' => null
            ],
            [
                'adjustment' => 'Performance Bonus',
                'rangestart' => null,
                'rangeend' => null,
                'operation' => 'incentive',
                'percentage' => '10.00',
                'fixedamount' => null
            ]
        ];

        foreach ($adjustments as $adjustment) {
            Adjustment::create($adjustment);
        }

        // Attach adjustments to employees
        $employees = Employee::all();
        $adjustments = Adjustment::all();

        foreach ($employees as $employee) {
            // Get a random number between 1 and the total number of adjustments
            $numAdjustments = rand(1, min(3, count($adjustments)));

            // Safely get random adjustments
            $employeeAdjustments = $adjustments->random($numAdjustments)
                ->mapWithKeys(function ($adjustment) {
                    return [$adjustment->id => ['frequency' => rand(1, 3)]];
                })->toArray();

            $employee->adjustments()->attach($employeeAdjustments);
        }
    }
}
