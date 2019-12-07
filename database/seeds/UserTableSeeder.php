<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=0; $i<=10; $i++){ 

            DB:: table('users')->insert([
                'name' => 'administrator' .$i,
                'email' => 'admin' . $i .'@gmail.com',
                'password' => bcrypt ('password')
            ]);
        }
       
    }
}
