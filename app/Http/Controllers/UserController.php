<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $req){
        return user::all();
    }

    public function get($user){
        $result = user::find($user);
        //$result = DB::table('user')->where('user', '=', $user)->get();
        if($result)
            return $result;
        else
            return response()->json(['status'=>'failed'], 404);
    }

    public function create(Request $req){
        $this->validate($req, [
            'user'=>'required', 
            'nombre'=>'required',
            'pass'=>'required',
            'rol'=>'required']);

        $datos = new user;
        // $datos->user = $req->user;
        $datos->pass = Hash::make($req->pass);
        // $datos->nombre = $req->nombre;
        // $datos->rol = $req->rol;
        // $datos->save();
        $result = $datos->fill($req->all())->save();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }

    public function update(Request $req, $user){
        $this->validate($req, [
            'user'=>'filled', 
            'nombre'=>'filled',
            'pass'=>'filled',
            'rol'=>'filled']);

        $datos = user::find($user);
        //$datos->pass = $req->pass;
        $result = $datos->fill($req->all())->save();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }

    public function destroy($user){
        
        $datos = user::find($user);
        if(!$datos) return response()->json(['status'=>'failed'], 404);
        $result = $datos->delete();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }

}