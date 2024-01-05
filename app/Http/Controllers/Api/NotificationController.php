<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationCollection;
use App\Models\Notification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    public function index(){
        $notif = Notification::whereUserId(auth()->user()->id)->whereNotIn('status', ['Trash'])->latest()->paginate(10);
        Notification::whereUserId(auth()->user()->id)->whereStatus('Sended')->update(['status' => 'Seen']);
        return response()->json(new NotificationCollection($notif), Response::HTTP_OK);
    }

    public function update(Request $request){
        Notification::find($request->id)->update(['status' => $request->status]);
        return response()->json('updated', Response::HTTP_OK);
    }
}
