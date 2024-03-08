<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
        private $rules = [
        'document' => 'required|integer|max:99999999999999999999|min:1',
        'name' => 'required|string|max:80|min:3',
        'especiality' => 'string|max:50|min:3',
        'phone' => 'string|max:30'
    ];

    private $traductionAttributes = array(
        'document' => 'documento',
        'name' => 'nombre',
        'especiality' => 'especialidad',
        'phone' => 'teléfono'
    );

    public function applyValidator(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);
        $data = [];
        if($validator->fails())
        {
            $data = response()->json([
                'errors' => $validator->errors(),
                'data' => $request ->all()
            ],Response::HTTP_BAD_REQUEST);
        }
        return $data;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        $orders->load([$orders,Response::HTTP_OK]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request $request, Order $order)
    {
        $data = $this->applyValidator($request);
        if(!empty($data))
        {
            return $data;
        }

        $order = Order::create($request->all());
        $respone =[
            'message' => 'registro creado exitosamente',
            'causal' => $order
        ];
        return response()->json($respone,Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['technician','type_activity']);
        return response()->json($order,Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $order-> delete();
        $respone =[
            'message' => 'registro eliminado exitosamente',
            'causal' => $order->id
        ];
        return response()->json($respone,Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order-> delete();
        $respone =[
            'message' => 'registro eliminado exitosamente',
            'causal' => $order->id
        ];
        return response()->json($respone,Response::HTTP_OK);
    }




    public function add_activity(Order $order, Activity $activity)

    {
        $order->activities()->attach($activity->id);
        $respone =[
            'message' => 'actividad agregada exitosamente',
            'causal' => $order->activities
        ];
        return response()->json($respone,Response::HTTP_OK);


    }

    public function remove_activity(Order $order, Activity $activity)

    {
        $order->activities()->attach($activity->id);
        $respone =[
            'message' => 'actividad eliminada exitosamente',
            'causal' => $order->activities
        ];
        return response()->json($respone,Response::HTTP_OK);

    }

}
