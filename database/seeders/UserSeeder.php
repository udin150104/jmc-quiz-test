<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach(["Administrator","Operator"] as $k => $v){
            Roles::updateOrCreate(["id" => ($k+1) ],[
                "id" => ($k+1) ,
                "nama" => $v
            ]);
        }
        $data = [
            [
                'id' => 1,
                'name' => "Raizo Sukma",
                'password' => bcrypt("Adm1n*48*123"),
                'email' => "admin@local.com",
                'username' => "administator",
            ],
            [
                'id' => 2,
                'name' => "Sirda Cahya",
                'password' => bcrypt("Oper4t*rrr"),
                'email' => "operator@local.com",
                'username' => "operator",
            ]
            ];
        foreach($data as $kk => $vv){
            $user = User::updateOrCreate([ 'id' => ($kk+1) ],$vv);
            $user?->roles()?->sync(($kk+1));
        }
    }
}
