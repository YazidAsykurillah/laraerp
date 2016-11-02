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
        	['id'=>1, 'code'=>'P-01', 'name'=>'Product 1', 'category_id'=>1, 'unit_id'=>1],
        	['id'=>2, 'code'=>'P-02', 'name'=>'Product 2', 'category_id'=>1, 'unit_id'=>2],
        ];

       \DB::table('products')->insert($data);
    }
}
