<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiSeeder extends Seeder
{
    public function run()
    {
        $nips = [
            '196504121990031002', '198107252005012003', '199001152010012005',
            '199208172015031001', '199503062018011001', '196811221990091009',
            '197609111996071007', '197203051995012003', '198108101998022004',
            '198511221999032005', '197911011996042006', '198910151997052007',
            '197706301994062008', '198003101995072009'
        ];

        $nilaiData = [
            ['nilai' => 78, 'predikat' => 'C', 'semester' => 1],
            ['nilai' => 98, 'predikat' => 'A', 'semester' => 1],
            ['nilai' => 64, 'predikat' => 'D', 'semester' => 1],
            ['nilai' => 77, 'predikat' => 'C', 'semester' => 1],
            ['nilai' => 52, 'predikat' => 'E', 'semester' => 1],
            ['nilai' => 94, 'predikat' => 'A', 'semester' => 1],
            ['nilai' => 64, 'predikat' => 'D', 'semester' => 1],
            ['nilai' => 72, 'predikat' => 'C', 'semester' => 1],
            ['nilai' => 56, 'predikat' => 'E', 'semester' => 1],
            ['nilai' => 78, 'predikat' => 'C', 'semester' => 1],
            ['nilai' => 69, 'predikat' => 'D', 'semester' => 1],
            ['nilai' => 79, 'predikat' => 'C', 'semester' => 1],
            ['nilai' => 62, 'predikat' => 'D', 'semester' => 1],
            ['nilai' => 83, 'predikat' => 'B', 'semester' => 1],
            ['nilai' => 53, 'predikat' => 'E', 'semester' => 1],
            ['nilai' => 94, 'predikat' => 'A', 'semester' => 1],
            ['nilai' => 53, 'predikat' => 'E', 'semester' => 1],
            ['nilai' => 54, 'predikat' => 'E', 'semester' => 1],
            ['nilai' => 88, 'predikat' => 'B', 'semester' => 1],
        ];

        $kodeMapel = ['MTK', 'BIN', 'BIG', 'PWEB', 'BADA', 'PAI', 'PKN'];

        foreach ($nilaiData as $i => $item) {
            DB::table('nilai')->insert([
                'id' => $i + 1,
                'nip' => $nips[$i % count($nips)],
                'nis' => 1001 + $i,
                'kode' => $kodeMapel[$i % count($kodeMapel)],
                'nilai' => $item['nilai'],
                'predikat' => $item['predikat'],
                'semester' => $item['semester'],
            ]);
        }
    }
}
