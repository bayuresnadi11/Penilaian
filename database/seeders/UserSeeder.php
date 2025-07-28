<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            // Data murid (username unik dari 1001 sampai 1020)
            ['username' => '1001', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1002', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1003', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1004', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1005', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1006', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1007', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1008', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1009', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1010', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1011', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1012', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1013', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1014', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1015', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1016', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1017', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1018', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1019', 'password' => Hash::make('password123'), 'role' => 'murid'],
            ['username' => '1020', 'password' => Hash::make('password123'), 'role' => 'murid'],

            // Data guru (username dari NIP dengan password guru123)
            ['username' => '196504121990031002', 'password' => Hash::make('guru123'), 'role' => 'guru'],
            ['username' => '198107252005012003', 'password' => Hash::make('guru123'), 'role' => 'guru'],
            ['username' => '199001152010012005', 'password' => Hash::make('guru123'), 'role' => 'guru'],
            ['username' => '199208172015031001', 'password' => Hash::make('guru123'), 'role' => 'guru'],
            ['username' => '199503062018011001', 'password' => Hash::make('guru123'), 'role' => 'guru'],
            ['username' => '196811221990091009', 'password' => Hash::make('guru123'), 'role' => 'guru'],
            ['username' => '197609111996071007', 'password' => Hash::make('guru123'), 'role' => 'guru'],
            ['username' => '197203051995012003', 'password' => Hash::make('guru123'), 'role' => 'guru'],
            ['username' => '198108101998022004', 'password' => Hash::make('guru123'), 'role' => 'guru'],
            ['username' => '198511221999032005', 'password' => Hash::make('guru123'), 'role' => 'guru'],
            ['username' => '197911011996042006', 'password' => Hash::make('guru123'), 'role' => 'guru'],
            ['username' => '198910151997052007', 'password' => Hash::make('guru123'), 'role' => 'guru'],
            ['username' => '197706301994062008', 'password' => Hash::make('guru123'), 'role' => 'guru'],
            ['username' => '198003101995072009', 'password' => Hash::make('guru123'), 'role' => 'guru'],
        ];

        // Insert the users into the database
        foreach ($users as $user) {
            User::create([
                'username' => $user['username'],
                'password' => $user['password'],
                'role' => $user['role'],
            ]);
        }
    }
}