<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PromoController extends Controller
{
    public function index(){
        return view('pages.promo.index');
    }
    public function form(Promo $promo){
        $title = $promo->exists ? 'Edit Data' : 'Tambah Data';
        $media = $promo->getMedia('promo-banner');
        return view('pages.promo.form', [
            'title' => $title,
            'data' => $promo,
            'media' => $media
        ]);
    }
    public function data()
    {
        $promo = Promo::where('status','ON')->get();
        $data = DataTables::of($promo);
        $data->addIndexColumn();
        $data->addColumn('action', function($data) {
            return '<div class="btn-group">
                <a class="btn btn-warning btn-xs btn-edit" href="' . url("promo/form/$data->id") . '"><i class="fa fa-edit"></i></a>
                <a class="btn btn-danger btn-xs btn-delete" data-name="'.$data->name.'" data-id= "'.$data->id.'"><i class="fa fa-trash"></i></a>
            </div>';
        });
        return $data->make();
    }
    public function save(Request $request){
        $id = $request->id;

        if($id){
            $data = Promo::find($id);
            $data->used = $request->used;
        }else{
            $data = new Promo();
            $data->used = 0;
        }
        $data->name = $request->name;
        $data->code = $request->code;
        $data->value = filter_number($request->value);
        $data->type = $request->type;
        $data->min_price = filter_number($request->min_price);
        $data->max_discount = filter_number($request->max_discount);
        $data->max_used = $request->max_used;
        $data->start_date = $request->start_date;
        $data->finish_date = $request->finish_date;
        $data->save();
        if ($request->hasFile('image')) {
            $data->clearMediaCollection('promo-banner');
            $data->addMediaFromRequest('image')->toMediaCollection('promo-banner');
        }
        return redirect()->intended('promo');
  
    }
    public function delete($id){
        Promo::find($id)->update(['status'=>'OFF']);
        return ['status' => true];
    }
}
