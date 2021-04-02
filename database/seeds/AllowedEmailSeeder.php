<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllowedEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('allowed_emails')->insert(['email' => 'example@allowed-email.com']);
        DB::table('allowed_emails')->insert(['email' => '@allowed-domain.com']);
    }
}
