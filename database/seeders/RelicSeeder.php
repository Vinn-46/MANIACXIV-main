<?php

namespace Database\Seeders;

use App\Models\Relic;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RelicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relicDatas = [
            1 => [
                'name' => 'Band of Aetherion',
                // 'desc' => 'Band of Aetherion merupakan gelang legendaris yang dulunya dikenakan oleh para penjaga Olympus saat Perang Besar. Terbuat dari api Aether yang abadi, relik ini melambangkan semangat pantang menyerah dan keberanian mutlak. Daya sihirnya memberi kekuatan tempur pada pemiliknya dan menjadikannya tak tergoyahkan di medan pertempuran. Dalam misi para demigod, relik ini harus dikumpulkan untuk membuka gerbang Elysium dan menjadi kunci penguji kekuatan fisik sejati.',
                'color' => 'red',
            ],
            
            2 => [
                'name' => 'Amulet of Nyxshade',
                // 'desc' => 'Amulet of Nyxshade merupakan artefak terlangka yang berasal dari bayangan Nyxion sendiri. Kalung ini menyerap kekuatan malam dan menguji moral serta keberanian terdalam dari seorang demigod. Relik ini bukan hanya sumber kekuatan, tetapi juga alat penyaring jiwa: hanya yang memiliki visi murni yang dapat memakainya. Amulet ini menjadi komponen penting dalam membuktikan kelayakan kepemimpinan di akhir Agon Theos.',
                'color' => 'purple',
            ],

            3 => [
                'name' => 'Ring of Mnemosyne',
                // 'desc' => 'Ring of Mnemosyne adalah cincin kebijaksanaan yang mengandung esensi sang dewi ingatan. Konon, cincin ini menyimpan potongan memori para dewa yang hilang, dan hanya dapat dipahami oleh mereka yang cerdas dan penuh strategi. Relik ini dibutuhkan untuk menavigasi labirin Divine Vessel dan mengenali kebenaran tersembunyi di balik misi Agon Theos.',
                'color' => 'blue',
            ],
        ];

        foreach ($relicDatas as $relic) {
            Relic::create([
                'nama' => $relic['name'],
                // 'desc' => $relic['desc'],
                'color' => $relic['color'],
            ]);
        }
    }
}
