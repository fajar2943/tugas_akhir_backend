<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\VariantCollection;
use App\Models\Detail;
use App\Models\Order;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index(Request $request){
        if($request->category){
            $products = Product::whereCategoryId($request->category)->whereStatus('1')->paginate(10);
        }elseif($request->search){
            $products = Product::whereStatus('1')->where('name', 'LIKE', '%' . $request->search . '%')->paginate(10);
        }else{
            $products = Product::whereStatus('1')->paginate(10);
        }
        return response()->json(new ProductCollection($products), Response::HTTP_OK);
    }
    public function show($id){
        $product = Product::find($id);
        return response()->json(['product' => new ProductResource($product), 'variants' => new VariantCollection($product->variants->where('status', '1'))], Response::HTTP_OK);
    }
    public function carts(Request $request){
        $variants = Variant::whereStatus('1')->whereIn('id', $request->carts)->get();
        return response()->json(new VariantCollection($variants), Response::HTTP_OK);
    }
    public function favorites(Request $request){
        $products = Product::whereStatus('1')->whereIn('id', $request->favorites)->get();
        return response()->json(new ProductCollection($products), Response::HTTP_OK);
    }
}
