<?php

use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\SpecialtySeeder;

use App\Activity;
use App\Booking;
use App\BusinessOwner;
use App\Customer;
use App\Employee;
use App\Role;
use App\WorkingTime;

use Carbon\Carbon as Time;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(SpecialtySeeder::class);
    }
}
