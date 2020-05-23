<?php

use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
        	[
        		'id' => 1,
        		'type' => 'User',
        		'is_active' => true,
                'is_admin' => false
        	],
            [
                'id' => 2,
                'type' => 'Admin',
                'is_active' => true,
                'is_admin' => true
            ],
            [
                'id' => 3,
                'type' => 'Professional',
                'is_active' => true,
                'is_admin' => false
            ],
            [
                'id' => 4,
                'type' => 'Service Provider',
                'is_active' => true,
                'is_admin' => false
            ]
        ];

        DB::table('user_types')->insert($types);
    }
}
