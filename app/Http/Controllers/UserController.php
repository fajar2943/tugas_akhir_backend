<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(){
        return view('pages.user.index');
    }
    public function data()
    {
        if (Auth::user()->role == 'Superadmin') {
            $user = User::get();
        }else{
            $user = User::where('role','Customer')->get();
        }
        $data = DataTables::of($user);
        $data->addIndexColumn();
        $data->addColumn('action', function($data) {
            return '<div class="btn-group">
                <a class="'.($data->status == 'Banned' ? "btn btn-info btn-xs btn-unbanned" : "btn btn-info btn-xs btn-unbanned d-none").'" data-name="'.$data->name.'" data-id= "'.$data->id.'"><i class="fas fa-unlock"></i></a>
                <a class="'.($data->status == 'Banned' ? "btn btn-danger btn-xs btn-banned d-none" : "btn btn-danger btn-xs btn-banned").'" data-name="'.$data->name.'" data-id= "'.$data->id.'"><i class="fas fa-ban"></i></a>
                
            </div>';
        });
        return $data->make();
    }
    public function form(){
        $title = 'Tambah Data';
        return view('pages.user.form', [
            'title' => $title,
        ]);
    }

    public function save(Request $request){
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'max:25',
            ],
            'email' => 'required|max:50|email|unique:users', 
        ], [
            'password.min'       => 'Isian kata sandi minimal 8 karakter.',
            'password.max'       => 'Isian kata sandi maksimal 25 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'Admin',
            'status' => 'Active'
        ]);

        return redirect()->intended('user');

    }

    public function banned($id){
        User::find($id)->update(['status' => 'Banned']);
        return ['status' => true];
    }
    public function unbanned($id){
        User::find($id)->update(['status' => 'Active']);
        return ['status' => true];
    }
}
