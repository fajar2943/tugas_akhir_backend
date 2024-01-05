<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $data['order'] = Order::get();
        $data['dalam_proses'] = Order::whereNotIn('status',['DONE','CANCEL'])->get();
        $data['selesai'] = Order::where('status','Done')->get();
        $data['user'] = User::where('role','Customer')->get();

        $data['penjualan'] = DB::table('orders')
        ->selectRaw('details.variant_id as variant_id,variants.name as variant_name, products.name as product_name,SUM(details.qty) as total_orders')
        ->leftJoin('details', 'details.order_id', '=', 'orders.id')
        ->leftJoin('variants', 'details.variant_id', '=', 'variants.id')
        ->leftJoin('products', 'variants.product_id', '=', 'products.id')
        ->where('orders.status','Done')
        ->groupBy('variant_id','variants.name','products.name')
        ->orderByDesc('total_orders')->limit(6)
        ->get();

        $data['penjualan_total'] = DB::table('orders')
        ->selectRaw('MONTH(orders.created_at) as month,YEAR(orders.created_at) as year, SUM(details.qty) as total_orders')
        ->leftJoin('details', 'details.order_id', '=', 'orders.id')
        ->groupBy('month')
        ->groupBy('year')
        ->where('orders.status','Done')
        ->get();
        
        return view('pages.dashboard.index',$data);
    }
    
}
