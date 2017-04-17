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
            //Purchases
                # Purchase Order
                ['id'=>1, 'slug'=>'purchase-order-module', 'description'=>''],
                ['id'=>2, 'slug'=>'create-purchase-order-module', 'description'=>''],
                ['id'=>3, 'slug'=>'edit-purchase-order-module', 'description'=>''],
                ['id'=>4, 'slug'=>'delete-purchase-order-module', 'description'=>''],
                # Purchase Order Invoice
                ['id'=>5, 'slug'=>'purchase-order-invoice-module', 'description'=>''],
                ['id'=>6, 'slug'=>'create-purchase-order-invoice-module', 'description'=>''],
                ['id'=>7, 'slug'=>'edit-purchase-order-invoice-module', 'description'=>''],
                ['id'=>8, 'slug'=>'delete-purchase-order-invoice-module', 'description'=>''],
                # Purchase Order Return
                ['id'=>9, 'slug'=>'purchase-order-return-module', 'description'=>''],
                ['id'=>10, 'slug'=>'create-purchase-order-return-module', 'description'=>''],
                ['id'=>11, 'slug'=>'edit-purchase-order-return-module', 'description'=>''],
                ['id'=>12, 'slug'=>'delete-purchase-order-return-module', 'description'=>''],

            //Sales
                # Sales Order
                ['id'=>13, 'slug'=>'sales-order-module', 'description'=>''],
                ['id'=>14, 'slug'=>'create-sales-order-module', 'description'=>''],
                ['id'=>15, 'slug'=>'edit-sales-order-module', 'description'=>''],
                ['id'=>16, 'slug'=>'delete-sales-order-module', 'description'=>''],
                # Sales Order Invoice
                ['id'=>17, 'slug'=>'sales-order-invoice-module', 'description'=>''],
                ['id'=>18, 'slug'=>'create-sales-order-invoice-module', 'description'=>''],
                ['id'=>19, 'slug'=>'edit-sales-order-invoice-module', 'description'=>''],
                ['id'=>20, 'slug'=>'delete-sales-order-invoice-module', 'description'=>''],
                # Sales Order Return
                ['id'=>21, 'slug'=>'sales-order-return-module', 'description'=>''],
                ['id'=>22, 'slug'=>'create-sales-order-return-module', 'description'=>''],
                ['id'=>23, 'slug'=>'edit-sales-order-return-module', 'description'=>''],
                ['id'=>24, 'slug'=>'delete-sales-order-return-module', 'description'=>''],

            //Inventory
                #List Product Available
                ['id'=>25, 'slug'=>'product-available', 'description'=>''],
                #List Product (All)
                ['id'=>26, 'slug'=>'product-all', 'description'=>''],

                #Main Product
                ['id'=>27, 'slug'=>'main-product-module', 'description'=>''],
                ['id'=>28, 'slug'=>'create-main-product-module', 'description'=>''],
                ['id'=>29, 'slug'=>'edit-main-product-module', 'description'=>''],
                ['id'=>30, 'slug'=>'delete-main-product-module', 'description'=>''],

                #Product Family
                ['id'=>31, 'slug'=>'family-module', 'description'=>''],
                ['id'=>32, 'slug'=>'create-family-module', 'description'=>''],
                ['id'=>33, 'slug'=>'edit-family-module', 'description'=>''],
                ['id'=>34, 'slug'=>'delete-family-module', 'description'=>''],
                #Product Category
                ['id'=>35, 'slug'=>'category-module', 'description'=>''],
                ['id'=>36, 'slug'=>'create-category-module', 'description'=>''],
                ['id'=>37, 'slug'=>'edit-category-module', 'description'=>''],
                ['id'=>38, 'slug'=>'delete-category-module', 'description'=>''],
                #Product Unit
                ['id'=>39, 'slug'=>'unit-module', 'description'=>''],
                ['id'=>40, 'slug'=>'create-unit-module', 'description'=>''],
                ['id'=>41, 'slug'=>'edit-unit-module', 'description'=>''],
                ['id'=>42, 'slug'=>'delete-unit-module', 'description'=>''],
                #Stock Balance
                ['id'=>43, 'slug'=>'stock-balance-module', 'description'=>''],
                ['id'=>44, 'slug'=>'create-stock-balance-module', 'description'=>''],
                ['id'=>45, 'slug'=>'edit-stock-balance-module', 'description'=>''],
                ['id'=>46, 'slug'=>'delete-stock-balance-module', 'description'=>''],
            
            //Finance
                #Bank
                ['id'=>47, 'slug'=>'bank-module', 'description'=>''],
                ['id'=>48, 'slug'=>'create-bank-module', 'description'=>''],
                ['id'=>49, 'slug'=>'edit-bank-module', 'description'=>''],
                ['id'=>50, 'slug'=>'delete-bank-module', 'description'=>''],

                #Cash
                ['id'=>51, 'slug'=>'cash-module', 'description'=>''],
                ['id'=>52, 'slug'=>'create-cash-module', 'description'=>''],
                ['id'=>53, 'slug'=>'edit-cash-module', 'description'=>''],
                ['id'=>54, 'slug'=>'delete-cash-module', 'description'=>''],
                #Chart Account
                ['id'=>55, 'slug'=>'chart-account-module', 'description'=>''],
                ['id'=>56, 'slug'=>'create-chart-account-module', 'description'=>''],
                ['id'=>57, 'slug'=>'edit-chart-account-module', 'description'=>''],
                ['id'=>58, 'slug'=>'delete-chart-account-module', 'description'=>''],
                #Kas Kecil
                ['id'=>59, 'slug'=>'kas-kecil-module', 'description'=>''],
                ['id'=>60, 'slug'=>'create-kas-kecil-module', 'description'=>''],
                ['id'=>61, 'slug'=>'edit-kas-kecil-module', 'description'=>''],
                ['id'=>62, 'slug'=>'delete-kas-kecil-module', 'description'=>''],
                #Lost & Profit
                ['id'=>63, 'slug'=>'lost-profit-module', 'description'=>''],
                ['id'=>64, 'slug'=>'print-lost-profit-module', 'description'=>''],
                #List Hutang
                ['id'=>65, 'slug'=>'list-hutang-module', 'description'=>''],
                #List Piutang
                ['id'=>66, 'slug'=>'list-piutang-module', 'description'=>''],
                #Neraca
                ['id'=>67, 'slug'=>'neraca-module', 'description'=>''],
                ['id'=>68, 'slug'=>'print-neraca-module', 'description'=>''],
                #Report
                ['id'=>69, 'slug'=>'report-module', 'description'=>''],
                ['id'=>70, 'slug'=>'print-report-module', 'description'=>''],
                #Supplier
                ['id'=>71, 'slug'=>'supplier-module', 'description'=>''],
                ['id'=>72, 'slug'=>'create-supplier-module', 'description'=>''],
                ['id'=>73, 'slug'=>'edit-supplier-module', 'description'=>''],
                ['id'=>74, 'slug'=>'delete-supplier-module', 'description'=>''],
                #Customer
                ['id'=>75, 'slug'=>'customer-module', 'description'=>''],
                ['id'=>76, 'slug'=>'create-customer-module', 'description'=>''],
                ['id'=>77, 'slug'=>'edit-customer-module', 'description'=>''],
                ['id'=>78, 'slug'=>'delete-customer-module', 'description'=>''],
                #Invoice Term
                ['id'=>79, 'slug'=>'invoice-term-module', 'description'=>''],
                ['id'=>80, 'slug'=>'create-invoice-term-module', 'description'=>''],
                ['id'=>81, 'slug'=>'edit-invoice-term-module', 'description'=>''],
                ['id'=>82, 'slug'=>'delete-invoice-term-module', 'description'=>''],
                #Driver Term
                ['id'=>83, 'slug'=>'driver-module', 'description'=>''],
                ['id'=>84, 'slug'=>'create-driver-module', 'description'=>''],
                ['id'=>85, 'slug'=>'edit-driver-module', 'description'=>''],
                ['id'=>86, 'slug'=>'delete-driver-module', 'description'=>''],
                #Vehicle Term
                ['id'=>87, 'slug'=>'vehicle-module', 'description'=>''],
                ['id'=>88, 'slug'=>'create-vehicle-module', 'description'=>''],
                ['id'=>89, 'slug'=>'edit-vehicle-module', 'description'=>''],
                ['id'=>90, 'slug'=>'delete-vehicle-module', 'description'=>''],

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
            

        ];
        DB::table('permission_role')->insert($permission_role);
        //ENDBlock table permission_role

        

    }
}
