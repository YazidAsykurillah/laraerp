<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;

use App\Unit;

class UnitController extends Controller
{
    public function index()
    {
    	return view('unit.index');
    }

    public function create()
    {
    	return view('unit.create');
    }

    public function store(StoreUnitRequest $request)
    {
    	$unit = new Unit;
    	$unit->name = $request->name;
    	$unit->save();
    	return redirect('unit');
    }

    public function destroy(Request $request)
    {
        $unit = Unit::findOrFail($request->unit_id);
        //count products
        $products = $unit->products->count();
        if($products > 0){
        	return redirect('unit')
        		->with('errorMessage', "$unit->name can not be deleted since there are product related with it");
        }
        else{
        	$unit->delete();
	        return redirect('unit')
	            ->with('successMessage', "$unit->name has been deleted");
        }
    }

    public function edit($id)
    {
    	$unit = Unit::findOrFail($id);
    	return view('unit.edit')
    		->with('unit', $unit);
    }

    public function update(UpdateUnitRequest $request, $id)
    {
    	$unit = Unit::findOrFail($id);
    	$unit->name = $request->name;
    	$unit->save();
    	return redirect('unit')
    		->with('successMessage', "Product unit has been successfully updated");
    }
}
