<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

//Form requests
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;

use App\Driver;
class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('driver.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('driver.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDriverRequest $request)
    {
        //
        $driver = new Driver;
        $driver->code = preg_replace('/\s+/','',$request->code);
        $driver->name = $request->name;
        preg_replace('/\s+/',' ',$driver->name);
        echo ucwords($driver->name);
        $driver->contact_number = preg_replace('/\s+/',' ',$request->primary_phone_number);
        $driver->save();
        return redirect('driver');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $driver = Driver::findOrFail($id);
        return view('driver.show')
            ->with('driver', $driver);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $driver = Driver::findOrFail($id);
        return view('driver.edit')
            ->with('driver', $driver);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDriverRequest $request, $id)
    {
        //
        $driver = Driver::findOrFail($id);
        $driver->code = $request->code;
        //Helper::Ucwords($driver->name);
        $driver->name = preg_replace('/\s+/',' ',$request->name);
        $driver->contact_number = preg_replace('/\s+/','',$request->contact_number);
        $driver->save();
        return redirect('driver')
            ->with('successMessage', "$driver->code has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $driver = Driver::findOrFail($request->driver_id);
        $driver->delete();
        return redirect('driver')
            ->with('successMessage',"$driver->code has been deleted");
    }
}
