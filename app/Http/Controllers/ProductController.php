<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(){
        return view('pages.product.index');
    }
    public function form($id_categories, Product $product){
        $media = $product->getMedia('product-image');
        $categories = Category::get();
        $title = $product->exists ? 'Edit Data' : 'Tambah Data';
        return view('pages.product.form', [
            'title' => $title,
            'id_categories' => $id_categories,
            'data' => $product,
            'categories' => $categories,
            'media' => $media
        ]);
    }
    public function data($id_categories)
    {
        $product = Product::with(['categories'])->where('category_id',$id_categories)->where('status','1')->get();
        $data = DataTables::of($product);
        $data->addIndexColumn();
        $data->addColumn('action', function($data) use ($id_categories) {
            return '<div class="btn-group">
            <a class="btn btn-primary btn-xs" href="' . url("categories/$id_categories/product/$data->id/variant") . '"><i class="fas fa-list"></i></a>
            <a class="btn btn-warning btn-xs" href="' . url("categories/$id_categories/product/form/$data->id") . '"><i class="fa fa-edit"></i></a>
            <a class="btn btn-danger btn-xs btn-delete" data-name="'.$data->name.'" data-id= "'.$data->id.'"><i class="fa fa-trash"></i></a>
            </div>';
        })->addColumn('image', function ($model) {
            $media = $model->getMedia('product-image')->first();
            if ($media) {
                return '<img src="' . $media->getUrl() . '" alt="Image" style="max-width: ' . '100'. 'px;max-height: ' . '100'. 'px;" />';
            }

            return '';
        })->rawColumns(['image','action']);
        return $data->make(true);
    }
    public function save(Request $request){
        $id = $request->id;

        if($id){
            $data = Product::find($id);
        }else{
            $data = new Product();
        }
        $data->name = $request->name;
        $data->category_id = $request->category_id;
        $data->description = $request->description;
        $data->save();
        if ($request->hasFile('image')) {
            $data->clearMediaCollection('product-image');
            $data->addMediaFromRequest('image')->toMediaCollection('product-image');
        }
        return redirect('categories/'.$request->category_id.'/product');
  
    }
    public function delete($id_categories, $id){
        $variant = Variant::where('product_id',$id)->where('status','1')->get();
        if (count($variant) == 0 ) {
            Product::find($id)->update(['status' => 0]);
            Variant::where('product_id',$id)->update(['status' => 0]);
            return ['status' => true];
        }else{
            return ['status' => false, 'message' => 'Didalam produk ini terdapat beberapa variant,<br>Jika ingin menghapus produk ini, bisa hapus terlebih dahulu semua data variant'];
        }
    }
}
