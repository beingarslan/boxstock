<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\OrderAdminMail;
use App\Mail\OrderUserMail;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return response()->json([
            'orders' => $orders,
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $variants = $request->all();
        $productId = '';
        $variant_arr = '';
        $totalPrice = $variants['totalPriceData'];
        $productId = $variants['productId'];
        foreach ($variants as $variant) {
            $variant_array = gettype($variant);
            if($variant_array === 'array') {
                $variant_arr = $variant;
            }
        }

        $user = Auth::user();

        $last_id = Order::orderBy('created_at', 'DESC')->first();
        $order = new Order();
        $order->product_id = $productId;
        $order->status = 0;
        $order->user_id = $user->id;
        $order->total_price = $totalPrice;
        $order->order_id = str_pad($last_id->id + 1, 9, "0", STR_PAD_LEFT);
        $order->order_date = date("Y-m-d");
        $order->delivery_method = 'DHL verzonden';
        $order->save();

        $order_status = 'Hold';
        foreach ($variant_arr as $single_var) {
            $product_order = new OrderProduct();
            $variant_id = $single_var['id'];
            $qty = $single_var['qty'];
            $variant = Variant::find($variant_id);

            if($variant) {
                $product_order->order_id = $order->id;
                $product_order->variant_id = $variant_id;
                $product_order->amount = $single_var['price'];
                $product_order->qty = $qty;
                $product_order->save();

                if($variant->stock > $qty) {
                    $variant->stock = $variant->stock - intval($qty);
                    $variant->save();
                } else {
                    $variant->stock = 0;
                    $order_status = 'Back order';
                    $variant->save();
                }
            }
        }

        Mail::to($user->email)->send(new OrderUserMail($order));
        Mail::to(env('ADMIN_EMAIL'))->send(new OrderAdminMail($order));

        return response()->json([
            'message' => 'Order created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $orders = Order::orderBy('created_at', 'desc')->where('user_id', '=', $id)->get();

        return response()->json([
            'orders' => $orders,
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $order = Order::find($id)->first();
        return response()->json([
            'order' => $order,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $order             = Order::find($id);
        $user = User::find($order->user_id)->first();
        $order->status     = $request->status;
        $order->delivery_method     = $request->delivery_method;
        $order->save();

        Mail::to($user->email)->send(new OrderUserMail($order));

        return response()->json([
            'status'=>200,
            'message'=> 'Order Updated Successfully!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if($order)
        {
            $order->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'Order Deleted Successfully!',
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=> 'Order not found!',
            ]);
        }
    }
}
