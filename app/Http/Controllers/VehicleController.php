<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Vehicle;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vehicle.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicle_category = ['Truck','Pick Up','Motorcycle'];
        return view('vehicle.create')
            ->with('vehicle_cat',$vehicle_category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vehicle = new Vehicle;
        $vehicle->code = $request->code;
        $category = $request->vehicle_category;
        $update_category;
        if($category == 0){
            $update_category = "truck";
        }elseif ($category == 1) {
            $update_category = "pick_up";
        }elseif ($category == 2){
            $update_category = "motorcycle";
        }
        $vehicle->category = $update_category;
        $vehicle->number_of_vehicle = $request->number_of_vehicle;
        $vehicle->save();
        return redirect('vehicle')
            ->with('successMessage','Vehicle has been created'.$update_category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('vehicle.show')
            ->with('vehicle',$vehicle);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle_category = ['truck'=>'Truck','pick_up'=>'Pick Up','motorcycle'=>'Motorcycle'];
        return view('vehicle.edit')
            ->with('vehicle',$vehicle)
            ->with('vehicle_cat',$vehicle_category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->code = $request->code;
        $vehicle->category = $request->category;
        $vehicle->number_of_vehicle = $request->number_of_vehicle;
        $vehicle->save();
        return redirect('vehicle')
            ->with('successMessage', "$vehicle->code has been updated".$request->category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $vehicle->delete();
        return redirect('vehicle')
            ->with('successMessage',"$vehicle->code has been deleted");
    }
}
