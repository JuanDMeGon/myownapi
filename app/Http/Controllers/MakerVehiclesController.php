<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Maker;
use App\Vehicle;

use App\Http\Requests\CreateVehicleRequest;

class MakerVehiclesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		$maker = Maker::find($id);

		if(!$maker)
		{
			return response()->json(['message' => 'This maker does not exist', 'code' => 404], 404);
		}

		return response()->json(['data' => $maker->vehicles], 200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateVehicleRequest $request, $makerId)
	{
		$maker = Maker::find($makerId);

		if(!$maker)
		{
			return response()->json(['message' => 'This maker does not exist', 'code' => 404], 404);
		}

		$values = $request->all();

		$maker->vehicles()->create($values);

		return response()->json(['message' => 'The vehicle associated was created'], 201);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, $vehicleId)
	{
		$maker = Maker::find($id);

		if(!$maker)
		{
			return response()->json(['message' => 'This maker does not exist', 'code' => 404], 404);
		}

		$vehicle = $maker->vehicles->find($vehicleId);

		if(!$vehicle)
		{
			return response()->json(['message' => 'This vehicle does not exist for this maker', 'code' => 404], 404);
		}

		return response()->json(['data' => $vehicle], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CreateVehicleRequest $request, $makerId, $vehicleId)
	{
		$maker = Maker::find($makerId);

		if(!$maker)
		{
			return response()->json(['message' => 'This maker does not exist', 'code' => 404], 404);
		}

		$vehicle = $maker->vehicles->find($vehicleId);

		if(!$vehicle)
		{
			return response()->json(['message' => 'This vehicle does not exist', 'code' => 404], 404);
		}


		$color = $request->get('color');
		$power = $request->get('power');
		$capacity = $request->get('capacity');
		$speed = $request->get('speed');

		$vehicle->color = $color;
		$vehicle->power = $power;
		$vehicle->capacity = $capacity;	
		$vehicle->speed = $speed;

		$vehicle->save();

		return response()->json(['message' => 'The vehicle has been updated'], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
