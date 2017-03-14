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
