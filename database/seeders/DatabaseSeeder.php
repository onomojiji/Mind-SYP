<?php

namespace Database\Seeders;

use App\Models\Personnel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $personnel = [
          "Mayiwi",
          "TEst",
          "F",
        ];

        $user = [
            "mayiwi@test.com",
        ];

        $p = Personnel::create([
            "nom" => $personnel[0],
            "prenom" => $personnel[1],
            "sexe" => $personnel[2]
        ]);

        $u = \App\Models\User::create([
            "email" => $user[0],
            "password" => Hash::make("password"),
            "is_admin" => true,
            "personnel_id" => $p->id
        ]);
    }
}
