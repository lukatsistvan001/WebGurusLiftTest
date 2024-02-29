<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Building;

class LiftController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function moveLift(Request $request)
    {
        return response()->json(['currentFloor' => $request->targetFloor]);
    }

    public function callNearestLift(Request $request)
    {
        $building = new Building($request->liftACurrentFloor, $request->liftBCurrentFloor);
        $lift = $building->callNearestLift($request->destinationFloor);
        $liftCurrentFloor = $lift->getCurrentFloor();
        $lift->moveToFloor($request->destinationFloor);

        return response()->json([
            'liftName' => $lift->getName(),
            'currentFloor' => $liftCurrentFloor,
            'destinationFloor' => $request->destinationFloor,
        ]);
    }
}
