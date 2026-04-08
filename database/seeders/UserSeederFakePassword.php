<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\password;

class UserSeederFakePassword extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make Participant
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'username' => "tim_$i",
                'password' => Hash::make("1234567890"),
                'role' => 'participant'
            ]);
        }

        // Make Pubreg
        $listPubreg = ['shelyn', 'dariel', "admin1", "admin2", "admin3", "admin4"];
        foreach ($listPubreg as $admin){
            User::create([
                'username' => $admin,
                'password' => Hash::make('1234567890'),
                'role' => 'admin'
            ]);
        }

        // Make Acara
        $listAcara = ['jeni', 'leon', "acara1", "acara2", "acara3", "acara4"];
        foreach ($listAcara as $acara) {
            User::create([
                'username' => $acara,
                'password' => Hash::make("1234567890"),
                'role' => 'acara'
            ]);
        }
        
        // Make penpos
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'username' => "penpos_$i",
                'password' => Hash::make("1234567890"),
                'role' => 'penpos'
            ]);
        }

        // Make si
        $listSi = ['ricky', 'yosua', 'cedric', 'nicholas', 'aileen'];
        foreach ($listSi as $si) {
            User::create([
                'username' => $si,
                'password' => Hash::make("1234567890"),
                'role' => 'si'
            ]);
        }

        // Make supersi
        $superSI = ['super_ricky', 'super_yosua'];
        foreach ($superSI as $super) {
            User::create([
                'username' => $super,
                'password' => Hash::make("1234567890"),
                'role' => 'supersi'
            ]);
        }
    }
}
