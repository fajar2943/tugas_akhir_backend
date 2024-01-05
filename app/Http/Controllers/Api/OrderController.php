<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderNotification;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\OrderCollection;
use App\Models\Detail;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Variant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::whereUserId(auth()->user()->id)->latest()->paginate(10);
        return response()->json(new OrderCollection($orders), Response::HTTP_OK);
    }
    public function show($id){
        $order = Order::find($id);
        return response()->json(new InvoiceResource($order), Response::HTTP_OK);
    }
    public function pdf($id, $token){
        $order = Order::find($id);
        if(!$order or $token != md5($order->id.'MP'.$order->user_id.'MP'.$order->total_price.'MP'.$order->created_at)){
            return 'Invoice Not Found';
        }
        return view('pdf.invoice', compact('order'));
    }
    public function checkouts(Request $request){
        return response()->json($this->_checkout_info($request), Response::HTTP_OK);
    }
    public function orders(Request $request){
        $checkout_info = $this->_checkout_info($request);
        if(count($checkout_info['invalid']) or count($checkout_info['out_of_stock'])){
            $checkout_info['is_failed'] = true;
            return response()->json($checkout_info, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $order = Order::create([
            'user_id' => auth()->user()->id, 'promo_id' => null, 'subtotals' => 0, 
            'total_price' => 0, 'status' => 'Pending',
        ]);
        $subtotals = 0;
        $total_price = 0;
        $details = [];
        foreach($request->checkouts as $checkout){                 
            $qty = ($checkout['qty'] < 1) ? 1 : $checkout['qty'];
            $variant = Variant::find($checkout['id']);
            $subtotal = $qty * $variant->price;
            $discount = $qty * discount($variant->discount->value, $variant->discount->type, $variant->price);
            $total_price += $subtotal - $discount;
            $subtotals += $subtotal - $discount;   
            $variant->update(['stock' => $variant->stock - $qty]);     
            $details[] = [
                'order_id' => $order->id, 'variant_id' => $checkout['id'], 'qty' => $qty, 'price' => $variant->price,
                'discount' => $discount, 'subtotal' => $subtotal, 'total' => $subtotal - $discount, 'created_at' => now()
            ];
        }
        Detail::insert($details);
        $promo = $this->_promo($request->promo_code, $total_price);
        $order->update(['subtotals' => $subtotals, 'promo_id' => $promo['id'], 'discount_promo' => $promo['discount'], 'total_price' => $total_price - $promo['discount']]);
        event(new OrderNotification(Order::where('status','Pending')->count()));
        return response()->json(['is_failed' => false, 'order_id' => $order->id], Response::HTTP_OK);
    }
    
    private function _checkout_info(Request $request){
        $variants = $this->_getVariantsById($request->checkouts);
        $checkouts = [];
        $invalid = [];
        $out_of_stock = [];
        $total_price = 0;
        foreach($request->checkouts as $checkout){
            $isValid = false;
            $qty = ($checkout['qty'] < 1) ? 1 : $checkout['qty'];
            foreach($variants as $variant){
                $price = $variant->price - discount($variant->discount->value, $variant->discount->type, $variant->price);
                if($checkout['id'] == $variant->id && $variant->stock >= $qty){
                    $checkouts[] = [
                        'id' => $variant->id, 'product_name' => $checkout['product_name'], 'name' => $variant->name, 'real_price' => $variant->price, 'is_discount' => ($variant->discount->value == 0 or $variant->discount->status == 'OFF') ? false : true,
                        'discount' => discount($variant->discount->value, $variant->discount->type), 'price' => $price, 'qty' => $qty, 'subtotal' => $qty * $price
                    ];
                    $total_price += ($qty * $price);
                    $isValid = true;
                }elseif($checkout['id'] == $variant->id && $variant->stock < $qty){
                    $isValid = true;
                    $out_of_stock[] = [
                        'id' => $variant->id, 'product_name' => $checkout['product_name'], 'name' => $variant->name, 'real_price' => $variant->price,  'is_discount' => ($variant->discount->value == 0 or $variant->discount->status == 'OFF') ? false : true,
                        'price' => $price, 'qty' => $qty, 'subtotal' => $qty * $price, 'available_stock' => $variant->stock
                    ];
                }
            }
            if(!$isValid){
                $invalid[] = ['id' => $checkout['id'], 'product_name' => $checkout['product_name'], 'name' => $checkout['name']];
            }
        }
        $promo = $this->_promo($request->promo_code, $total_price);

        return ['total_price' => rupiah($total_price - $promo['discount']), 'out_of_stock' => $out_of_stock, 'invalid' => $invalid, 'checkouts' => $checkouts, 'promo' => $promo];
    }
    private function _getVariantsById($params){
        $variants_id = [];
        foreach($params as $param){
            $variants_id[] = $param['id'];
        }
        return Variant::whereIn('id', $variants_id)->get();
    }
    private function _promo($promo_code, $total_price){
        $id = null;
        $name = '0%';
        $discount = 0;
        $promo = Promo::whereCode($promo_code)->whereStatus('ON')->where('start_date', '<', now())->where('finish_date', '>', now())->first();
        if($promo && $promo->used < $promo->max_used){
            $id = $promo->id;
            $name = discount($promo->value, $promo->type);
            $discount = discount($promo->value, $promo->type, $total_price);
        }
        return ['id' => $id, 'name' => $name, 'discount' => $discount];
    }
}
