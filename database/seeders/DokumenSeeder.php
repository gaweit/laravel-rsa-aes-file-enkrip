<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('dokumens')->insert([
            [
                'user_id' => 1,
                'algoritme' => 'AES',
                'file' => 'files/sample-aes-encrypted.txt',
            ],
            [
                'user_id' => 2,
                'algoritme' => 'RSA',
                'file' => 'files/sample-rsa-encrypted.txt',
            ],
        ]);
    }
}
