<?php

use Illuminate\Database\Seeder;

class PurchaseOrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('purchase_orders')->delete();
        $data = [
        	['id'=>1, 'code'=>'PO-001', 'supplier_id'=>1, 'creator'=>1, 'status'=>'posted'],
        	['id'=>2, 'code'=>'PO-002', 'supplier_id'=>1, 'creator'=>1, 'status'=>'posted'],
        	['id'=>3, 'code'=>'PO-003', 'supplier_id'=>2, 'creator'=>1, 'status'=>'posted'],
        ];

        \DB::table('purchase_orders')->insert($data);
    }
}
