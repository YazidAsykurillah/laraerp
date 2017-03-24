<?php

    // My common functions
    function amount_sales_order_bank($reference,$chart_account_id)
    {
        // $bank_sales_invoice_payment = \DB::table('bank_sales_invoice_payment')->where('bank_id',$reference)->get();
        // $s_i_p = [];
        // foreach ($bank_sales_invoice_payment as $key) {
        //     $s_i_p[] = \DB::table('sales_invoice_payments')->where('id',$key->sales_invoice_payment_id)->sum('amount');
        //     print_r($s_i_p[]);
        // }
        //
        // return $s_i_p;
    }

    function main_product($key)
    {
        $main_product = \DB::table('products')->where('main_product_id',$key)->groupBy('main_product_id')->get();

        return $main_product;
    }

    function child_chart_account($key)
    {
        $child_chart_account = \DB::table('sub_chart_accounts')->where('parent_id',$key)->orderBy('account_number','asc')->get();

        return $child_chart_account;
    }

    function list_account_cash_bank($key)
    {
        $list_account_cash_bank = \DB::table('sub_chart_accounts')->where('chart_account_id',$key)->get();

        return $list_account_cash_bank;
    }

    function list_sub_cash_bank($key,$id)
    {
        $list_sub_cash_bank = \DB::table('sub_chart_accounts')->where([['level',$key],['parent_id',$id]])->get();

        return $list_sub_cash_bank;
    }

    function list_account_inventory($key)
    {
<<<<<<< HEAD
      $list_account_inventory = \DB::table('sub_chart_accounts')->where([['chart_account_id',$key]])->get();

      return $list_account_inventory;
=======
        $list_account_inventory = \DB::table('sub_chart_accounts')->where([['chart_account_id',$key]])->get();

        return $list_account_inventory;
>>>>>>> 49c54335c39a881f92028c13af4e2954b072b9b3
    }

    function list_sub_inventory($key,$id)
    {
<<<<<<< HEAD
      $list_sub_inventory = \DB::table('sub_chart_accounts')->where([['level',$key],['parent_id',$id]])->get();

      return $list_sub_inventory;
=======
        $list_sub_inventory = \DB::table('sub_chart_accounts')->where([['level',$key],['parent_id',$id]])->get();

        return $list_sub_inventory;
>>>>>>> 49c54335c39a881f92028c13af4e2954b072b9b3
    }

    function list_account_piutang($key)
    {
        $list_account_piutang = \DB::table('sub_chart_accounts')->where([['chart_account_id',$key]])->get();

        return $list_account_piutang;
    }

    function list_sub_piutang($key,$id)
    {
        $list_sub_piutang = \DB::table('sub_chart_accounts')->where([['level',$key],['parent_id',$id]])->get();

        return $list_sub_piutang;
    }

    function list_account_hutang($key)
    {
        $list_account_hutang = \DB::table('sub_chart_accounts')->where([['chart_account_id',$key]])->get();

        return $list_account_hutang;
    }

    function list_sub_hutang($key,$id)
    {
        $list_sub_hutang = \DB::table('sub_chart_accounts')->where([['level',$key],['parent_id',$id]])->get();

        return $list_sub_hutang;
    }

    function list_parent($key)
    {
        $list_parent = \DB::table('sub_chart_accounts')->where([['chart_account_id',$key]])->get();

        return $list_parent;
    }

    function list_child($key,$id)
    {
        $list_child = \DB::table('sub_chart_accounts')->where([['level',$key],['parent_id',$id]])->get();

        return $list_child;
    }

    function list_transaction_cash_bank($key,$date)
    {
        $list_transaction_k = \DB::table('transaction_chart_accounts')->where([['sub_chart_account_id',$key]])->where([['type','keluar']])->where('created_at','like',$date.'%')->sum('amount');
        $list_transaction_d = \DB::table('transaction_chart_accounts')->where([['sub_chart_account_id',$key]])->where([['type','masuk']])->where('created_at','like',$date.'%')->sum('amount');
        if(count($list_transaction_k) == 0){
             return $list_transaction_d;
         }
            return $list_transaction_d-$list_transaction_k;

    }

    function list_transaction_inventory($key,$date)
    {
        $list_transaction_purchase = \DB::table('transaction_chart_accounts')->where([['sub_chart_account_id',$key]])->where([['type','masuk']])->where('created_at','like',$date.'%')->sum('amount');
        $list_transaction_sales = \DB::table('transaction_chart_accounts')->where([['sub_chart_account_id',$key]])->where([['type','keluar']])->where('created_at','like',$date.'%')->sum('amount');
        return $list_transaction_purchase-$list_transaction_sales;
    }

    function list_transaction_hutang($key,$date)
    {
        $list_transaction_k = \DB::table('transaction_chart_accounts')->where([['sub_chart_account_id',$key]])->where([['type','keluar']])->where('created_at','like',$date.'%')->sum('amount');
        $list_transaction_d = \DB::table('transaction_chart_accounts')->where([['sub_chart_account_id',$key]])->where([['type','masuk']])->where('created_at','like',$date.'%')->sum('amount');
        if(count($list_transaction_k) == 0){
             return $list_transaction_d;
         }
            return $list_transaction_k-$list_transaction_d;
    }

    function list_transaction_piutang($key,$date)
    {
        $list_transaction_m = \DB::table('transaction_chart_accounts')->where([['sub_chart_account_id',$key]])->where([['type','masuk']])->where('created_at','like',$date.'%')->sum('amount');
        $list_transaction_k = \DB::table('transaction_chart_accounts')->where([['sub_chart_account_id',$key]])->where([['type','keluar']])->where('created_at','like',$date.'%')->sum('amount');
        if(count($list_transaction_k) == 0){
             return $list_transaction_m;
         }
            return $list_transaction_m-$list_transaction_k;
    }

    function list_transaction($key)
    {
        return '';
    }
