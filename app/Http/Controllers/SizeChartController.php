<?php

namespace App\Http\Controllers;

use App\Http\Requests\SizeChartRequest;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\SizeChart;
use Illuminate\Http\Request;
use App\Models\MeasurementPoint;
use App\Models\SizeChartDetail;

class SizeChartController extends Controller
{
    public function __construct() {
        // Staff Permission Check
        $this->middleware(['permission:view_measurement_points'])->only('index');
        $this->middleware(['permission:edit_size_charts'])->only('edit');
        $this->middleware(['permission:delete_size_charts'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizeCharts = SizeChart::orderBy('created_at', 'desc')->paginate(15);
        return view('backend.product.sizeCharts.index', compact('sizeCharts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        
        $measurementPoints = MeasurementPoint::orderBy('created_at', 'asc')->paginate(15);
        $sizeOptions = AttributeValue::selectRaw('id,value')->orderBy('created_at', 'asc')->get();

        return view('backend.product.sizeCharts.create', compact('categories', 'measurementPoints', 'sizeOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SizeChartRequest $request)
    {
        $size_chart = SizeChart::create($request->except([
            'size_chart_values'
        ]));

        $this->storeSizeChartDetail($size_chart->id, $request->only([
            'measurement_option',
            'measurement_points',
            'size_options',
            'size_chart_values',
        ]));

        flash(translate('Size Chart has been created successfully'))->success();
        return redirect()->route('size-charts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $size_chart = SizeChart::findOrFail($id);
        
        $measurement_options = json_decode($size_chart->measurement_option);
        $measurement_option_inch = in_array("inch", $measurement_options) ? 1 : 0;
        $measurement_option_cen = in_array("cen", $measurement_options) ? 1 : 0;

        $measurementPoints = MeasurementPoint::whereIn('id', json_decode($size_chart->measurement_points, true))->get();
        $size_options = AttributeValue::selectRaw('id,value')->whereIn('id', json_decode($size_chart->size_options, true))->get();

        $data = array();
        foreach ($size_chart->sizeChartDetails as $sizeChartDetail) {
            $data['inch'][$sizeChartDetail->measurement_point_id][$sizeChartDetail->attribute_value_id] =  $sizeChartDetail->inch_value;
            $data['cen'][$sizeChartDetail->measurement_point_id][$sizeChartDetail->attribute_value_id] =  $sizeChartDetail->cen_value;
        }

        return view('backend.product.sizeCharts.show', compact('measurementPoints', 'size_options', 'measurement_option_inch', 'measurement_option_cen', 'size_chart', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SizeChart $size_chart)
    {
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        
        $measurementPoints = MeasurementPoint::orderBy('created_at', 'asc')->paginate(15);
        $sizeOptions = AttributeValue::selectRaw('id,value')->orderBy('created_at', 'asc')->get();

        $data = array();
        foreach ($size_chart->sizeChartDetails as $sizeChartDetail) {
            $data['inch'][$sizeChartDetail->measurement_point_id][$sizeChartDetail->attribute_value_id] =  $sizeChartDetail->inch_value;
            $data['cen'][$sizeChartDetail->measurement_point_id][$sizeChartDetail->attribute_value_id] =  $sizeChartDetail->cen_value;
        }

        return view('backend.product.sizeCharts.edit', compact('categories', 'measurementPoints', 'sizeOptions', 'size_chart', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SizeChartRequest $request, SizeChart $size_chart)
    {
        $size_chart->update($request->except([
            'size_chart_values'
        ]));
        $size_chart->sizeChartDetails()->delete();

        $this->storeSizeChartDetail($size_chart->id, $request->only([
            'measurement_option',
            'measurement_points',
            'size_options',
            'size_chart_values',
        ]));

        flash(translate('Size Chart has been updated successfully'))->success();
        return redirect()->route('size-charts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $size_chart = SizeChart::findOrFail($id);
        $size_chart->delete();
        $size_chart->sizeChartDetails()->delete();
        
        flash(translate('Size Chart has been deleted successfully'))->success();
        return redirect()->route('size-charts.index');
    }

    public function get_combination(Request $request)
    {
        $measurement_option_inch = $request->measurement_option_inch;
        $measurement_option_cen = $request->measurement_option_cen;
        $measurementPoints = MeasurementPoint::whereIn('id', $request->measurement_points)->get();
        $size_options = AttributeValue::selectRaw('id,value')->whereIn('id', $request->size_options)->get();
        
        return view('backend.product.sizeCharts.size_combination', compact('measurementPoints', 'size_options', 'measurement_option_inch', 'measurement_option_cen'));
    }

    public function storeSizeChartDetail($size_chart_id, $request)
    {
        $measurement_options = json_decode($request['measurement_option']);
        $data = array();
        $i = 0;
        foreach (json_decode($request['measurement_points']) as $measurement_point) {
            foreach (json_decode($request['size_options']) as $size_option) {
                $data[$i]['size_chart_id'] = $size_chart_id;
                $data[$i]['measurement_point_id'] = $measurement_point;
                $data[$i]['attribute_value_id'] = $size_option;
                $data[$i]['inch_value'] = in_array("inch", $measurement_options) ? $request['size_chart_values'][$measurement_point][$size_option]['inch'] : null;
                $data[$i]['cen_value'] = in_array("cen", $measurement_options) ? $request['size_chart_values'][$measurement_point][$size_option]['cen'] : null;
                $i += 1;
            }
        }

        SizeChartDetail::insert($data);
    }
}
