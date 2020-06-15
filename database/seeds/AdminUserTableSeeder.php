<?php

use Illuminate\Database\Seeder;
use App\AdminUser;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUsers =[
            [
             'username'=>'Bharti',
             'password'=>'bharti123',
             'created_at'=>'2020-04-17 04:42:08',
             'updated_at'=>'2020-04-17 04:42:08'
            ],
            [
             'username'=>'Rupali',
             'password'=>'rupali123',
             'created_at'=>'2020-04-17 04:42:08',
             'updated_at'=>'2020-04-17 04:42:08'
            ],
            [
             'username'=>'Binal',
             'password'=>'Binal123',
             'created_at'=>'2020-04-17 04:42:08',
             'updated_at'=>'2020-04-17 04:42:08'
            ]
        ];

       AdminUser::insert($adminUsers);
    }
}
