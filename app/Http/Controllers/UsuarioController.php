<?php

namespace App\Http\Controllers;

use App\Logica\LogicaUsuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function __construct(){
        $this->middleware('cors');
        $this->middleware('jwt.auth', ['except' => ['Authenticate', 'CrearUsuarios']]);
    }

    public function Authenticate(Request $request){
        $logica = new LogicaUsuario();
        return response()->json($logica->Authenticate($request));
    }

    public function CrearUsuarios(Request $request){
        $logica = new LogicaUsuario();
        return response()->json($logica->CrearUsuarios($request));
    }
}
