<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Employee;
use App\Role;

class SpecialtySeeder extends Seeder
{
    /**
     * Seed sample doctors with each common medical specialty.
     */
    public function run(): void
    {
        $doctorRole = Role::where('name', 'doctor')->first();

        if (!$doctorRole) {
            $this->command->warn('Doctor role not found. Skipping SpecialtySeeder.');
            return;
        }

        $specialties = [
            ['title' => 'General Practitioner', 'specialty' => 'General Practice',      'firstname' => 'James',    'lastname' => 'Carter'],
            ['title' => 'Cardiologist',          'specialty' => 'Cardiology',            'firstname' => 'Sarah',    'lastname' => 'Mitchell'],
            ['title' => 'Dermatologist',         'specialty' => 'Dermatology',           'firstname' => 'Emma',     'lastname' => 'Brooks'],
            ['title' => 'Neurologist',           'specialty' => 'Neurology',             'firstname' => 'Robert',   'lastname' => 'Hayes'],
            ['title' => 'Orthopedic Surgeon',   'specialty' => 'Orthopedics',           'firstname' => 'Michael',  'lastname' => 'Turner'],
            ['title' => 'Pediatrician',          'specialty' => 'Pediatrics',            'firstname' => 'Linda',    'lastname' => 'Foster'],
            ['title' => 'Psychiatrist',          'specialty' => 'Psychiatry',            'firstname' => 'David',    'lastname' => 'Newton'],
            ['title' => 'Ophthalmologist',       'specialty' => 'Ophthalmology',         'firstname' => 'Laura',    'lastname' => 'Spencer'],
            ['title' => 'ENT Specialist',        'specialty' => 'Ear, Nose & Throat',    'firstname' => 'Kevin',    'lastname' => 'Ward'],
            ['title' => 'Gynecologist',          'specialty' => 'Gynecology',            'firstname' => 'Patricia', 'lastname' => 'Adams'],
            ['title' => 'Urologist',             'specialty' => 'Urology',               'firstname' => 'Thomas',   'lastname' => 'Hughes'],
            ['title' => 'Endocrinologist',       'specialty' => 'Endocrinology',         'firstname' => 'Nancy',    'lastname' => 'Cooper'],
            ['title' => 'Gastroenterologist',    'specialty' => 'Gastroenterology',      'firstname' => 'Brian',    'lastname' => 'Bell'],
            ['title' => 'Pulmonologist',         'specialty' => 'Pulmonology',           'firstname' => 'Angela',   'lastname' => 'Reed'],
            ['title' => 'Rheumatologist',        'specialty' => 'Rheumatology',          'firstname' => 'Jason',    'lastname' => 'Price'],
        ];

        foreach ($specialties as $index => $data) {
            $username = strtolower($data['firstname'] . '.' . $data['lastname']);

            // Skip if this username already exists
            if (Employee::where('username', $username)->exists()) {
                continue;
            }

            Employee::create([
                'firstname'   => $data['firstname'],
                'lastname'    => $data['lastname'],
                'title'       => $data['title'],
                'specialty'   => $data['specialty'],
                'phone'       => '0400' . str_pad($index + 100, 6, '0', STR_PAD_LEFT),
                'role_id'     => $doctorRole->id,
                'username'    => $username,
                'password'    => Hash::make('password'),
                'is_approved' => true,
                'approved_at' => now(),
            ]);
        }

        $this->command->info('SpecialtySeeder: ' . count($specialties) . ' specialties seeded.');
    }
}
