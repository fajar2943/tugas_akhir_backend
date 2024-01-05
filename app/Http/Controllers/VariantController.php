<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Variant;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VariantController extends Controller
{
    public function index($id_categories,$id_product){
        return view('pages.product.variant.index',['id_categories' => $id_categories,'id_product' => $id_product]);
    }
    public function form($id_categories, $id_product, Variant $variant){
        $media = $variant->getMedia('variant-image');
        $discount = Discount::where('status','ON')->get();
        $title = $variant->exists ? 'Edit Data' : 'Tambah Data';
        return view('pages.product.variant.form', [
            'title' => $title,
            'data' => $variant,
            'media' => $media,
            'discount' => $discount,
            'id_product' => $id_product,
            'id_categories' => $id_categories,
        ]);
    }
    public function data($id_categories,$id_product)
    {
        $variant = Variant::with(['discount'])->where('product_id',$id_product)->where('status','1')->get();
        $data = DataTables::of($variant);
        $data->addIndexColumn();
        $data->addColumn('action', function($data) use ($id_categories,$id_product) {
            return '<div class="btn-group">
            <a class="btn btn-warning btn-xs" href="' . url("categories/$id_categories/product/$id_product/variant/form/$data->id") . '"><i class="fa fa-edit"></i></a>
            <a class="btn btn-danger btn-xs btn-delete" data-name="'.$data->name.'" data-id= "'.$data->id.'"><i class="fa fa-trash"></i></a>
            </div>';
        })->addColumn('image', function ($model) {
            $media = $model->getMedia('variant-image')->first();
            if ($media) {
                return '<img src="' . $media->getUrl() . '" alt="Image" style="max-width: ' . '60'. 'px;max-height: ' . '60'. 'px;" />';
            }

            return '';
        })->rawColumns(['image','action']);;
        return $data->make();
    }
    public function save(Request $request){
        $id = $request->id;
        if($id){
            $data = Variant::find($id);
        }else{
            $data = new Variant();
        }
        $data->product_id = $request->product_id; 
        $data->discount_id = $request->discount_id; 
        $data->name = $request->name; 
        $data->price = filter_number($request->price); 
        $data->stock = $request->stock; 
        $data->save();
        if ($request->hasFile('image')) {
            $data->clearMediaCollection('variant-image');
            $data->addMediaFromRequest('image')->toMediaCollection('variant-image');
        }
        return redirect('categories/'.$request->category_id.'/product/'.$request->product_id.'/variant');

  
    }
    public function delete($id_categories,$id_product,$id){
        Variant::find($id)->update(['status' => 0]);
        return ['status' => true];
    }
}
