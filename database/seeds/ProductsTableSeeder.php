<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('products')->delete();
        $data = [
        	
            ['id'=>1, 'code'=>'CAT1-FAM1-1', 'name'=>'Product 1', 'category_id'=>1, 'unit_id'=>1, 'family_id'=>1],
        	['id'=>2, 'code'=>'CAT1-FAM1-2', 'name'=>'Product 2', 'category_id'=>1, 'unit_id'=>2, 'family_id'=>1],
        ];

       \DB::table('products')->insert($data);
    }
}
