<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TemaController extends Controller
{
    public function index(Request $req){
        return tema::all();
    }

    public function get($tema){
        $result = tema::find($tema);
        //$result = DB::table('tema')->where('tema', '=', $tema)->get();
        if($result)
            return $result;
        else
            return response()->json(['status'=>'failed'], 404);
    }

    public function create(Request $req){
        $this->validate($req, [
            'id'=>'required', 
            'tema'=>'required']);

        $datos = new tema;
        // $datos->tema = $req->tema;
        // $datos->nombre = $req->nombre;
        // $datos->rol = $req->rol;
        // $datos->save();
        $result = $datos->fill($req->all())->save();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }

    public function update(Request $req, $tema){
        $this->validate($req, [
            'id'=>'filled', 
            'tema'=>'filled']);

        $datos = tema::find($tema);
        //$datos->pass = $req->pass;
        $result = $datos->fill($req->all())->save();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }

    public function destroy($tema){
        
        $datos = tema::find($tema);
        if(!$datos) return response()->json(['status'=>'failed'], 404);
        $result = $datos->delete();
        if($result)
            return response()->json(['status'=>'success'], 200);
        else
            return response()->json(['status'=>'failed'], 404);
    }

}