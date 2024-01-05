<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function update(Request $request){
        $this->validate($request, [
            'update' => 'required|max:10',
            'value' => 'required|max:255',
        ]);

        $user = User::find(auth()->user()->id);
        if($request->update == 'name'){
            $user->update(['name' => $request->value]);
            return response()->json(['message' => 'update success'], Response::HTTP_OK);
        }
    }
    public function changePassword(Request $request){
        $this->validate($request, [
            'password_lama' => 'required|min:8|max:255',
            'password_baru' => 'required|min:8|max:255',
            'konfirmasi_password' => 'required|min:8|max:255',
        ]);

        $user = User::find(auth()->user()->id);
             
        if(!Hash::check($request->password_lama, $user->password)){
            return response()->json(['message' => 'Password saat ini tidak sesuai.'],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if($request->password_baru != $request->konfirmasi_password){
            return response()->json(['message' => 'Konfirmasi password tidak sesuai.'],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->update(['password' => $request->password_baru]);
        return response()->json(['message' => 'Password berhasil di update.'], Response::HTTP_OK);
    }
    public function directSetPassword(Request $request){
        $this->validate($request, [
            'user_id' => 'required|max:255',
            'verification_id' => 'required|max:255',
            'hash' => 'required|max:255',
            'password_baru' => 'required|min:8|max:255',
            'konfirmasi_password' => 'required|min:8|max:255',
        ]);
        if($request->password_baru != $request->konfirmasi_password){
            return response()->json(['message' => 'Konfirmasi password tidak sesuai.'],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $verify = Verification::whereId($request->verification_id)->whereOtp($request->hash)->whereType('ResetPassword')->whereStatus('Valid')->where('expired_at', '>', now())->first();
        if(!$verify){
            return response()->json(['message' => 'Update password gagal, verifikasi tidak valid.'],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        User::find($request->user_id)->update(['password' => $request->password_baru]);
        return response()->json(['message' => 'Password berhasil di update.'], Response::HTTP_OK);
    }
}
