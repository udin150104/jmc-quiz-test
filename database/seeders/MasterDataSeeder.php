<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // DB::table('penduduk')->truncate();
        // DB::table('kabupaten')->truncate();
        // DB::table('provinsi')->truncate();

        $provinsiList = [];

        // Insert Provinsi
        for ($i = 1; $i <= 5; $i++) {
            $provinsiId = DB::table('provinsi')->insertGetId([
                'nama' => "Provinsi Contoh $i",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $provinsiList[] = $provinsiId;

            // Insert Kabupaten per Provinsi
            for ($j = 1; $j <= 3; $j++) {
                $kabupatenId = DB::table('kabupaten')->insertGetId([
                    'provinsi_id' => $provinsiId,
                    'nama' => "Kabupaten $j Prov-$i",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert Penduduk per Kabupaten
                for ($k = 1; $k <= 10; $k++) {
                    DB::table('penduduk')->insert([
                        'nama' => $faker->name,
                        'nik' => $faker->unique()->numerify('3276##########'),
                        'tanggal_lahir' => $faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
                        'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                        'provinsi_id' => $provinsiId,
                        'kabupaten_id' => $kabupatenId,
                        'alamat' => $faker->address,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
