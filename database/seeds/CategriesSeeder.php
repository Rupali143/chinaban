<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
        DB::table('categries')->insert([
        	// 'id' =>1,
            'en_name' => 'Electronics',
            // 'parent_category' => 1,
            'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s"),
            
        ]);
        DB::table('categries')->insert([
        	// 'id' =>1,
            'en_name' => 'Computer & Laptop',
            // 'parent_category' => 1,
            'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('categries')->insert([
        	// 'id' =>2,
            'en_name' => 'Dell Laptop',
            // 'parent_category' => 1,
            'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
