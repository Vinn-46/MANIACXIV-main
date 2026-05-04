<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\password;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $passwords = [
            'admin'       => Hash::make('AdminManiac!@#$'),
            'acara'       => Hash::make('AcaraManiac!@#$'),
            'si'          => Hash::make('SIManiacJago!@#$'),
            'supersi'     => Hash::make('SuperSIJago!@#$'),
            'participant' => Hash::make('TimManiac!@#$'),
            'penpos'      => Hash::make('Penpos!@#$'),
        ];

        $users = [
            'admin'       => ['nadya', 'felly', 'cecilia', 'jessika', 'admin3', 'admin4'],
            'acara'       => ['joshua', 'vellya', 'acara1', 'acara2', 'acara3', 'acara4'],
            'si'          => ['kelvin', 'leon', 'arkan', 'margaret'],
            'supersi'     => ['super_kelvin', 'super_leon'],
            'participant' => collect(range(1, 20))->map(fn($i) => "tim_$i")->toArray(),
            'penpos'      => collect(range(1, 20))->map(fn($i) => "penpos_$i")->toArray(),
        ];

        foreach ($users as $role => $names) {
            foreach ($names as $name) {
                User::create([
                    'username' => $name,
                    'password' => $passwords[$role],
                    'role' => $role,
                ]);
            }
        }
    }
}
