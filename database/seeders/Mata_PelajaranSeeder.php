<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Mata_PelajaranSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['kode' => 'MTK', 'mata_pelajaran' => 'Matematika'],
            ['kode' => 'BIN', 'mata_pelajaran' => 'Bahasa Indonesia'],
            ['kode' => 'BIG', 'mata_pelajaran' => 'Bahasa Inggris'],
            ['kode' => 'PWEB', 'mata_pelajaran' => 'Pemrograman Web'],
            ['kode' => 'BADA', 'mata_pelajaran' => 'Basis Data'],
            ['kode' => 'PAI', 'mata_pelajaran' => 'Pendidikan Agama Islam'],
            ['kode' => 'PKN', 'mata_pelajaran' => 'Pendidikan Kewarganegaraan'],
        ];

        foreach ($data as $item) {
            DB::table('mata_pelajaran')->updateOrInsert(
                ['kode' => $item['kode']],
                ['mata_pelajaran' => $item['mata_pelajaran']]
            );
        }
    }
}