<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use App\Models\Notification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::wherestatus('1')->get();
        return response()->json([
            'status' => 'Success',
            'unreadNotif' => Notification::whereUserId(auth()->user()->id)->whereStatus('Sended')->count(),
            'data' => new CategoryCollection($categories)
        ], Response::HTTP_OK);
    }
}
