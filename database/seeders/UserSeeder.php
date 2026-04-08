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
        // // Make Participant
        // for ($i = 1; $i <= 20; $i++) {
        //     User::create([
        //         'username' => "tim_$i",
        //         'password' => Hash::make("TimManiac@2025"),
        //         'role' => 'participant'
        //     ]);
        // }

        // // Make Pubreg
        // $listPubreg = ['shelyn', 'dariel', "admin1", "admin2", "admin3", "admin4"];
        // foreach ($listPubreg as $admin){
        //     User::create([
        //         'username' => $admin,
        //         'password' => Hash::make('AdminManiac@2025'),
        //         'role' => 'admin'
        //     ]);
        // }

        // // Make Acara
        // $listAcara = ['jeni', 'leon', "acara1", "acara2", "acara3", "acara4"];
        // foreach ($listAcara as $acara) {
        //     User::create([
        //         'username' => $acara,
        //         'password' => Hash::make("AcaraManiac@2025"),
        //         'role' => 'acara'
        //     ]);
        // }
        
        // // Make penpos
        // for ($i = 1; $i <= 20; $i++) {
        //     User::create([
        //         'username' => $i,
        //         'password' => Hash::make("pp@2025"),
        //         'role' => 'penpos'
        //     ]);
        // }

        // // Make si
        // $listSi = ['ricky', 'yosua', 'cedric', 'nicholas', 'aileen'];
        // foreach ($listSi as $si) {
        //     User::create([
        //         'username' => $si,
        //         'password' => Hash::make("SIManiacJago@2025"),
        //         'role' => 'si'
        //     ]);
        // }

        // // Make supersi
        // $superSI = ['super_ricky', 'super_yosua'];
        // foreach ($superSI as $super) {
        //     User::create([
        //         'username' => "super_$super",
        //         'password' => Hash::make("SuperSIJago@2025"),
        //         'role' => 'supersi'
        //     ]);
        // }
       
        // Make supersi
        // $penpos = [
        //     'patrick', 
        //     "jonathan", 
        //     "nicho", 
        //     "vellacia", 
        //     "josh", 
        //     "chelsie", 
        //     "jesselyn", 
        //     "antonio", 
        //     "jeremy", 
        //     "han", 
        //     "felicia", 
        //     "terry", 
        //     "calvin", 
        //     "mega", 
        //     "vuai", 
        //     "dennis"
        // ];
        
        // $count = 0;
        // foreach ($penpos as $penpos) {
        //     if($count == 0){
        //         $pass = "pos1Maniac2025";
        //         $count = 3;
        //     }else if ($count == 3){
        //         $pass = "pos3Maniac2025";
        //         $count = 7;
        //     }else{
        //         $pass = "pos7Maniac2025";
        //         $count = 0;
        //     }
        //     User::create([
        //         'username' => "$penpos",
        //         'password' => Hash::make($pass),
        //         'role' => 'penpos'
        //     ]);
        // }
    }
}
