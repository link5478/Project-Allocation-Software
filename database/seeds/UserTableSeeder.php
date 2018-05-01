<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {


        /*
         * Creating Full Admin.
         */

        DB::table('users')->insert([
            'fname' => 'Super',
            'lname' => 'User',
            'email' => 'superuser@gmail.com',
            'password' => bcrypt('superuser'),
            'is_student' => true,
            'is_supervisor' => true,
            'is_coordinator' => true,
        ]);

        /*
         * Creating Supervisor.
         */

        DB::table('users')->insert([
            'fname' => 'Super',
            'lname' => 'Visor',
            'email' => 'supervisor@gmail.com',
            'password' => bcrypt('supervisor'),
            'is_supervisor' => true,
        ]);

        /*
         * Creating Student.
         */

        DB::table('users')->insert([
            'fname' => 'Stu',
            'lname' => 'Dent',
            'email' => 'student@gmail.com',
            'password' => bcrypt('student'),
            'is_student' => true,
        ]);


    }

}