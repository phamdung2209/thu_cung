<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MeasurementPoint;
use App\Http\Requests\MeasurementPointRequest;

class MeasurementPointsController extends Controller
{
    public function __construct() {
        // Staff Permission Check
        $this->middleware(['permission:view_measurement_points'])->only('index');
        $this->middleware(['permission:edit_measurement_points'])->only('get_measurement_point');
        $this->middleware(['permission:delete_measurement_points'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $measurementPoints = MeasurementPoint::orderBy('created_at', 'desc')->paginate(15);
        return view('backend.product.measurementPoints.index', compact('measurementPoints'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeasurementPointRequest $request)
    {
        MeasurementPoint::create($request->only([
            'name'
        ]));

        flash(translate('Measurement Point has been inserted successfully'))->success();
        return redirect()->route('measurement-points.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MeasurementPoint $measurementPoint)
    {
        return $measurementPoint->name;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MeasurementPointRequest $request, MeasurementPoint $measurementPoint)
    {
        $measurementPoint->update($request->only([
            'name'
        ]));

        flash(translate('Measurement Point has been updated successfully'))->success();
        return redirect()->route('measurement-points.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MeasurementPoint::destroy($id);
        flash(translate('Measurement Point has been deleted successfully'))->success();
        return redirect()->route('measurement-points.index');
    }
}
