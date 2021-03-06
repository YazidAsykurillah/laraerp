<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateSubChartAccountRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|unique:sub_chart_accounts,name',
            'account_number'=>'required|unique:sub_chart_accounts,account_number',
            'level'=>'required',
        ];
    }
}
