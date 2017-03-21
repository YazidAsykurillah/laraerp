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

    function list_transaction($key)
    {
        $list_transaction = \DB::table('transaction_chart_accounts')->where([['sub_chart_account_id',$key]])->sum('amount');

        return $list_transaction;
    }
