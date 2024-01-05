<?php

namespace App\Http\Controllers;

use App\Events\OrderNotification;
use App\Jobs\PushNotificationOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\Variant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Optimus\Optimus;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index(){
        return view('pages.order.index');
    }
    public function done_order(){
        return view('pages.order.done_order.index');
    }
    public function form(Order $order){
        $title = $order->exists ? 'Edit Data' : 'Tambah Data';
        $data = $order::with(['promos','users','detail','detail.variant.product','detail.variant.discount'])->where('id',$order->id)->first();
        $data_detail = $data->detail;
        foreach ($data->detail as $data->detail) {
            $media[] = $data->detail->variant->getMedia('variant-image');
        }
        return view('pages.order.form', [
            'title' => $title,
            'data' => $data,
            'data_detail' => $data_detail,
            'media' => $media,
        ]);
    }
    public function data()
    {
        // dd(Order::with(['promos','users','detail','detail.variant'])->get());
        $order = Order::with(['promos','users'])->where('status','!=','DONE');
        // dd($order);
        $data = DataTables::of($order);
        $data->addIndexColumn();
        $data->addColumn('action', function($data) {
            return '<div class="btn-group">
            <a class="btn btn-warning btn-xs" href="' . url("order/form/$data->id") . '"><i class="fa fa-edit"></i></a>
            </div>';
        });
        return $data->make();
    }
    public function done_order_data()
    {
        // dd(Order::with(['promos','users','detail','detail.variant'])->get());
        $order = Order::with(['promos','users','detail.variant'])->where('status','=','DONE')->get();
        $data = DataTables::of($order);
        $data->addIndexColumn();
        $data->addColumn('action', function($data) {
            return '<div class="btn-group">
            <a class="btn btn-warning btn-xs" href="' . url("order/form/$data->id") . '"><i class="fa fa-edit"></i></a>
            </div>';
        });
        return $data->make();
    }
    public function save(Request $request){
        $id = $request->id;
        $order = Order::find($id);
        $order->update([
            'updated_by' => Auth::user()->id,
            'status' => $request->status
        ]);
        event(new OrderNotification(count(Order::where('status','Pending')->get())));
        PushNotificationOrder::dispatch($order);
        return redirect()->intended('order');
    }
    public function cetakLaporan()
    {
        $year = Carbon::now()->format('Y');
        $order = Order::with(['promos','users','detail.variant.product'])->whereYear('created_at',$year)->get();
        // $order = \DB::table('orders')
        // ->selectRaw('details.variant_id as variant_id,variants.name as variant_name, products.name as product_name, SUM(details.qty) as total_orders , SUM(details.subtotal) as subtotals , SUM(details.discount) as total_discount ,SUM(details.total) as totals')
        // ->leftJoin('details', 'details.order_id', '=', 'orders.id')
        // ->leftJoin('variants', 'details.variant_id', '=', 'variants.id')
        // ->leftJoin('products', 'variants.product_id', '=', 'products.id')
        // ->where('orders.status','Done')
        // ->groupBy('variant_id','variants.name')
        // ->get();
 
    	$pdf = \PDF::loadView('pdf.laporan_order', ['order' => $order]);
        // return view('pdf.laporan_order', ['order' => $order]);

        // return $pdf->stream('Laporan-Penjualan-MyPackaging.pdf');
        return $pdf->setPaper('A4', 'landscape')->stream("Laporan-Penjualan-MyPackaging.pdf");
        
    }
}
