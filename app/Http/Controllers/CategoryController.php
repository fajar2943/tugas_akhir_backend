<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(){
        return view('pages.categories.index');
    }
    public function form(Category $categories){
        $title = $categories->exists ? 'Edit Data' : 'Tambah Data';
        return view('pages.categories.form', [
            'title' => $title,
            'data' => $categories,
        ]);
    }
    public function data()
    {
        $categories = Category::where('status','1')->get();
        $data = DataTables::of($categories);
        $data->addIndexColumn();
        $data->addColumn('action', function($data) {
            return '<div class="btn-group">
                <a class="btn btn-primary btn-xs" href="' . url("categories/$data->id/product") . '"><i class="fas fa-list"></i></a>
                <a class="btn btn-warning btn-xs btn-edit" href="' . url("categories/form/$data->id") . '"><i class="fa fa-edit"></i></a>
                <a class="btn btn-danger btn-xs btn-delete" data-name="'.$data->name.'" data-id= "'.$data->id.'"><i class="fa fa-trash"></i></a>
            </div>';
        });
        return $data->make();
    }
    public function save(Request $request){
        $id = $request->id;

        if($id){
            $data = Category::find($id);
        }else{
            $data = new Category();
        }
        $data->name = $request->name;
        $data->save();
        return redirect()->intended('categories');
  
    }
    public function delete($id){
        $produk = Product::where('category_id',$id)->where('status','1')->get();
        if (count($produk) == 0 ) {
            Category::find($id)->update(['status' => 0]);
            Product::where('category_id',$id)->update(['status' => 0]);
            return ['status' => true];
        }else{
            return ['status' => false, 'message' => 'Didalam kategori ini terdapat beberapa produk,<br>Jika ingin menghapus kategori ini, bisa hapus terlebih dulu semua data produk'];
        }
    }
}
