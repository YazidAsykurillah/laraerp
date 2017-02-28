<?php

use Illuminate\Database\Seeder;

class AclTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Block table roles
	    DB::table('roles')->delete();
        $roles = [
        	['id'=>1, 'code'=>'SUP', 'name'=>'Super Admin', 'label'=>'User with this role will have full access to apllication'],
        	['id'=>2, 'code'=>'ADM', 'name'=>'Administrator', 'label'=>'User with this role will have semi-full access to apllication'],
        	['id'=>3, 'code'=>'FIN', 'name'=>'Finance', 'label'=>'User with this role will have full access to finance'],
        	['id'=>4, 'code'=>'WRH', 'name'=>'Warehouse', 'label'=>'User with this role will have full access to warehouse'],
            ['id'=>5, 'code'=>'MKT', 'name'=>'Marketing', 'label'=>'User with this role will have full access to marketing'],
        ];
        DB::table('roles')->insert($roles);
	    //ENDBlock table roles

        //Block table role_user
	    DB::table('role_user')->delete();
        $role_user = [
        	['role_id'=>1, 'user_id'=>1],
        	['role_id'=>2, 'user_id'=>2],
            ['role_id'=>3, 'user_id'=>3],
        	['role_id'=>4, 'user_id'=>4],
        ];
        DB::table('role_user')->insert($role_user);
        //ENDBlock table role_user

        //Block table permissions
        DB::table('permissions')->delete();
        $permissions = [
            //Purchase Order Modules
            ['id'=>1, 'slug'=>'purchase-order-module', 'description'=>''],
            ['id'=>2, 'slug'=>'purchase-order-invoice-module', 'description'=>''],
            ['id'=>3, 'slug'=>'purchase-return', 'description'=>''],

            //Sales Order Modules
            ['id'=>4, 'slug'=>'sales-order-module', 'description'=>''],
            ['id'=>5, 'slug'=>'sales-order-invoice-module', 'description'=>''],
            ['id'=>6, 'slug'=>'sales-return', 'description'=>''],

            //Inventory Modules
            ['id'=>7, 'slug'=>'product-module', 'description'=>''],
            ['id'=>8, 'slug'=>'stock-balance-module', 'description'=>''],
            ['id'=>9, 'slug'=>'product-category-module', 'description'=>''],
            ['id'=>10, 'slug'=>'product-unit-module', 'description'=>''],

            //Finance Modules
            ['id'=>11, 'slug'=>'bank-module', 'description'=>''],
        	


        ];
        DB::table('permissions')->insert($permissions);
        //ENDBlock table permissions

        //Block table permission_role
        DB::table('permission_role')->delete();
        $permission_role = [
        	//Administrator privilleges
        	['permission_id'=>1, 'role_id'=>2],
        	['permission_id'=>2, 'role_id'=>2],
        	['permission_id'=>3, 'role_id'=>2],
        	['permission_id'=>4, 'role_id'=>2],
            ['permission_id'=>5, 'role_id'=>2],
            ['permission_id'=>6, 'role_id'=>2],
            ['permission_id'=>7, 'role_id'=>2],
            ['permission_id'=>8, 'role_id'=>2],
            ['permission_id'=>9, 'role_id'=>2],

            //Finance Privillages
            ['permission_id'=>1, 'role_id'=>3],
            ['permission_id'=>2, 'role_id'=>3],
            ['permission_id'=>3, 'role_id'=>3],
            ['permission_id'=>4, 'role_id'=>3],
            ['permission_id'=>5, 'role_id'=>3],
            ['permission_id'=>6, 'role_id'=>3],

        ];
        DB::table('permission_role')->insert($permission_role);
        //ENDBlock table permission_role

        

    }
}
