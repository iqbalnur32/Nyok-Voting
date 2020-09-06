<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
 
    	for($i = 1; $i <= 50; $i++){
 
    	      // insert data ke table pegawai menggunakan Faker
    		DB::table('users_voting')->insert([
    			'username' => $faker->username,
    			'email' => $faker->email,
    			'password' => '$2y$10$lpTulBsLl1ZKMtgdtJEdtOmszttmitBEUtN4mygJ1Ot8tUedcw44S',
    			'status' => 'tidak_aktif',
    			'level_id' => 2
    		]);
 
    	}
    }
}
