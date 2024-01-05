<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\Email;
use App\Models\User;
use App\Models\Verification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class VerificationController extends Controller
{ 
    public function directOtp(Request $request){//send otp without login (directly)
        $this->validate($request,[
            'type' => 'required|max:255',
            'send_via' => 'required|max:255',
            'param' => 'required|max:255',
        ]);       
        
        if($request->send_via == 'Email'){
            $user = User::whereEmail($request->param)->first();
        }

        if(!$user){
            return response()->json([
                'message' => 'Email Belum Terdaftar',
                'status_code' => 422,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $count = Verification::whereUserId($user->id)->whereDate('created_at',now())->count();
        if($count > 5){
            return response()->json([
                'message' => 'Pengiriman OTP melampaui batas, coba lagi besok!',
                'status_code' => 422,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if($request->send_via == 'Email'){
            Mail::to($user->email)->queue(new Email($this->_generateOtp($request->type, $user)));
        }  
        return response()->json([
            'message' => 'Success',
            'status' => 'ResetPassword',
            'user_id' => $user->id
        ], Response::HTTP_CREATED);
    }
    public function sendOtp(Request $request){//need login (for Register verify)
        $this->validate($request,[
            'type' => 'required|max:255',
            'send_via' => 'required|max:255'
        ]);       
        
        $count = Verification::whereUserId(auth()->user()->id)->whereDate('created_at',now())->count();
        if($count > 5){
            return response()->json([
                'message' => 'Pengiriman OTP melampaui batas, coba lagi besok!',
                'status_code' => 422,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if($request->send_via == 'Email'){
            Mail::to(auth()->user()->email)->queue(new Email($this->_generateOtp($request->type, auth()->user())));
        }  
        return response()->json([
            'message' => 'Success',
            'status_code' => 201,
        ], Response::HTTP_CREATED);
    }

    public function verify(Request $request){
        $this->validate($request, [
            'user_id' => 'required|numeric|max:200000000',
            'otp' => 'required|max:6',
            'type' => 'required|max:20',
        ]);
        return $this->_otpValidation($request->otp, $request->type, $request->user_id);
    }

    private function _generateOtp($type, $user){
        Verification::whereUserId($user->id)->whereType($type)->whereStatus('Created')->update(['status' => 'Expired']);
        $otp = rand(100000, 999999);
        Verification::create(['user_id' => $user->id, 'otp' => md5($otp), 'status' => 'Created', 'expired_at' => Carbon::tomorrow(), 'type' => $type]);
        return $otp;
    }

    private function _otpValidation($otp, $type, $user_id){
        $verification = Verification::whereUserId($user_id)->whereType($type)->whereOtp(md5($otp))->whereStatus('Created')->whereDate('created_at', now())->first();
        if(!$verification){
            Verification::whereUserId($user_id)->whereType($type)->whereStatus('Created')->update(['status' => 'Expired']);
            return response()->json([
                'message' => 'Your OTP is Wrong or Expired.',
                'type' => $type,
                'status_code' => 500,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $verification->update(['status' => 'Valid']);
        if($verification->type == 'ResetPassword'){
            return response()->json([
                'message' => 'Validasi OTP berhasil, silahkan ubah password anda!',
                'status' => 'SetPassword',
                'verification_id' => $verification->id,
                'hash' => $verification->otp,
                'user_id' => $user_id,
            ], Response::HTTP_OK);
        }
        $user = User::find($user_id);
        $user->update(['status' => 'Active']);
        return response()->json([
            'message' => 'Success',
            'status' => $user->status,
            'status_code' => 200,
        ], Response::HTTP_OK);
    }
}
