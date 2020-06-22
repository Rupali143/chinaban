<?php

use Illuminate\Database\Seeder;
use App\Model\AdminUser;

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
             'username'=>'Admin',
             'password'=> bcrypt('admin123'),
             'created_at'=>'2020-04-17 04:42:08',
             'updated_at'=>'2020-04-17 04:42:08'
            ],
            [
             'username'=>'Expert',
             'password'=> bcrypt('expert123'),
             'created_at'=>'2020-04-17 04:42:08',
             'updated_at'=>'2020-04-17 04:42:08'
            ],
            [
             'username'=>'Vendor',
             'password'=> bcrypt('vendor123'),
             'created_at'=>'2020-04-17 04:42:08',
             'updated_at'=>'2020-04-17 04:42:08'
            ]
        ];

       AdminUser::insert($adminUsers);
    }
}
