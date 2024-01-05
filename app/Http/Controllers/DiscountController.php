<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DiscountController extends Controller
{
    public function index(){
        return view('pages.discount.index');
    }
    public function form(Discount $discount){
        $title = $discount->exists ? 'Edit Data' : 'Tambah Data';
        return view('pages.discount.form', [
            'title' => $title,
            'data' => $discount,
        ]);
    }
    public function data()
    {
        $discount = Discount::where('status','ON')->get();
        $data = DataTables::of($discount);
        $data->addIndexColumn();
        $data->addColumn('action', function($data) {
            return '<div class="btn-group">
                <a class="btn btn-warning btn-xs" href="' . url("discount/form/$data->id") . '"><i class="fa fa-edit"></i></a>
                <a class="'.($data->id == 1 ? "btn btn-danger btn-xs btn-delete disabled" : "btn btn-danger btn-xs btn-delete").'" data-name="'.$data->name.'" data-id= "'.$data->id.'"><i class="fa fa-trash"></i></a>

            </div>';
        });
        return $data->make();
    }
    public function save(Request $request){
        $id = $request->id;

        if($id){
            $data = Discount::find($id);
        }else{
            $data = new Discount();
        }
        $data->name = $request->name;
        $data->value = filter_number($request->value);
        $data->type = $request->type;
        $data->save();
        return redirect()->intended('discount');
  
    }
    public function delete($id){
        Discount::find($id)->update(['status'=>'OFF']);
        return ['status' => true];
    }
}
