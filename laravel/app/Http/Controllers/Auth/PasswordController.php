<?php

namespace CuentasFacturas\Http\Controllers\Auth;

use CuentasFacturas\Http\Controllers\Controller;
use CuentasFacturas\Http\Requests\PasswordResetRequest;
use CuentasFacturas\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getReset()
    {
        return view('auth.reset_password');
    }

    public function postReset(PasswordResetRequest $request)
    {

        $cambio = false;

        $user = User::where('username', '=', $request['username'])->get();
        if($user->count())
        {
            $userEdit = User::find($user[0]->id);

            if($userEdit->id != Auth::user()->id)
            {
                $errors = array(
                    "0" => "Las credenciales no coinciden con el usuario autentificado actualmente!",
                );
                return $request->response($errors);
            }

            if($request['new_username'] != "")
            {
                $existe = User::where('username', '=', $request['new_username'])->where('id', '<>', $user->id )->get();
                if($existe->count() > 0){
                    $errors = array(
                        "0" => "El nombre de usuario ya est&#225; en uso!",
                    );
                    return $request->response($errors);
                }
                $userEdit->user = $request['new_username'];
                $cambio = true;
            }
            if($request['new_password'] != "")
            {
                $userEdit->password = bcrypt($request['new_password']);
                $cambio = true;
            }
            if(!$cambio){
                $errors = array(
                    "0" => "Ingrese su nuevo usuario o contrase&#241;a!",
                );
                return $request->response($errors);
            }
            $userEdit->save();
            //***//
            Auth::logout();
            return redirect()->route('login')->with('message','resetok');
        }
        else {
            $errors = array(
                "0" => "Usuario no identificado",
            );
            return $request->response($errors);
        }
    }
}
