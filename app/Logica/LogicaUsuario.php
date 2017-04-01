<?php
/**
 * Created by PhpStorm.
 * User: Ing. Adrian Vergara
 * Date: 1/4/2017
 * Time: 12:55
 */

namespace App\Logica;

use App\Entidades\Respuesta;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogicaUsuario
{
    public function Authenticate(Request $request){
        $respuesta = new Respuesta();

        $validarCampos = \Validator::make($request->all(), [
            'identificacion' => 'required',
            'password' => 'required|max:90'
        ]);

        if($validarCampos->fails()){
            $respuesta->error = true;
            $respuesta->mensaje = "Verifique que los campos hayan sido diligenciados o no excedan la cantidad de caracteres permitidos";
        }
        else{
            $respuesta->error = false;
            $respuesta->datos = $request->all();
        }
        return $respuesta;
    }

    private function ValidarCamposVacios(Request $request){
        $respuesta = new Respuesta();
        $validar = \Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'identificacion' => 'required',
            'password' => 'required'
        ]);
        if($validar->fails()){
            $respuesta->error = true;
            $respuesta->mensaje = "Verifique que haya diligenciado todos los campos";
        }
        else{
            $respuesta->error = false;
        }
        return $respuesta;
    }

    private function ValidarCantidadCaracteres(Request $request){
        $respuesta = new Respuesta();
        $validar = \Validator::make($request->all(), [
            'nombres' => 'max:60',
            'apellidos' => 'max:60',
            'identificacion' => 'max:11',
            'password' => 'max:90'
        ]);
        if($validar->fails()){
            $respuesta->error = true;
            $respuesta->mensaje = "Verifique que no haya excedido los limites en los caracteres de los campos";
        }
        else{
            $respuesta->error = false;
        }
        return $respuesta;
    }

    function ValidarCamposUnicos(Request $request){
        $respuesta = new Respuesta();
        $validar = \Validator::make($request->all(), [
            'identificacion' => 'unique:usuarios'
        ]);
        if($validar->fails()){
            $respuesta->error = true;
            $respuesta->mensaje = "La identificacion que desea registrar ya existe";
        }
        else{
            $respuesta->error = false;
        }
        return $respuesta;
    }

    public function CrearUsuarios(Request $request){
        $respuesta = new Respuesta();
        $validarCamposVacios = $this->ValidarCamposVacios($request);
        if($validarCamposVacios->error == false){
            $validarCantidadCaracteres = $this->ValidarCantidadCaracteres($request);
            if($validarCantidadCaracteres->error == false){
                $validarCamposUnicos = $this->ValidarCamposUnicos($request);
                if($validarCamposUnicos->error == false){
                    $usuario = new User();
                    $usuario->nombres = $request->get('nombres');
                    $usuario->apellidos = $request->get('apellidos');
                    $usuario->identificacion = $request->get('identificacion');
                    $usuario->password = Hash::make($request->get('password'));
                    if($usuario->save()){
                        $respuesta->error = false;
                        $respuesta->mensaje = "Datos almacenados exitosamente";
                        $respuesta->datos = $usuario;
                        $respuesta->token = JWTAuth::fromUser($usuario);
                    }
                    else{
                        $respuesta->error = true;
                        $respuesta->mensaje = "No se pudieron almacenar los datos, intente nuevamente";
                    }
                }
                else{
                    $respuesta->error = true;
                    $respuesta->mensaje = $validarCamposUnicos->mensaje;
                }
            }
            else{
                $respuesta->error = true;
                $respuesta->mensaje = $validarCantidadCaracteres->mensaje;
            }
        }
        else{
            $respuesta->error = true;
            $respuesta->mensaje = $validarCamposVacios->mensaje;
        }
        return $respuesta;
    }

}