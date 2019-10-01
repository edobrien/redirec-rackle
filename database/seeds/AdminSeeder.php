<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => "Ed O'Brien",
            'firm_name' => 'Rec-Direc',
            'position' => 'Owner',
            'email' => 'recdirec@gmail.com',
            'email_verified_at' => now(),
            'contact_number' => '0123456789',
            'password' => bcrypt('recdirec@123'),
            'is_admin' => 'YES',
            'is_active' => 'YES',
            'approved_at' => now(),
            'accepted_terms' => 'YES',
            'privacy_policy' => 'YES',
        ]);
    }
}
