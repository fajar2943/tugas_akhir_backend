<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromoCollection;
use App\Models\Promo;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PromoController extends Controller
{
    public function index(){
        $promo = Promo::all();
        return response()->json(new PromoCollection($promo), Response::HTTP_OK);
    }
}
