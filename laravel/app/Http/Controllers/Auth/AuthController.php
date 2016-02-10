<?php

namespace CuentasFacturas\Http\Controllers\Auth;

use CuentasFacturas\Http\Requests\EditUserRequest;
use CuentasFacturas\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use CuentasFacturas\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->middleware('guest', ['only' => 'getLogin']);
        $this->middleware('admin', ['only' => ['getRegister','getEdit']]);
        //$this->middleware('admin', ['except' => ['getLogin','postLogin','getLogout']]);
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'type' => $data['type'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getListUsers()
    {
        $users = User::orderBy('type')->orderBy('name')->paginate(10);

        return view('auth.listusers', compact('users'));
    }

    public  function getOutUser()
    {
        $users = User::onlyTrashed()->orderBy('type')->orderBy('name')->paginate(10);

        return view('auth.outusers', compact('users'));
    }

    public function getEdit($id=0)
    {
        if($id == 0)
        {
            return \Response::view('errors.500');
        }
        $user = User::find($id);
        return view('auth.edituser', compact('user'));
    }

    public function postEdit(EditUserRequest $request)
    {
        $user = User::find($request['id']);
        $user->fill($request->all());
        $user->save();
        return redirect()->route('user_list')->with('message', 'editok');
    }

    public function getCancel($id)
    {
        $user = User::find($id);
        if( $user->id == Auth::user()->id)
        {
            return response()->json([
                "mensaje" => "login",
            ]);
        }
        $user->delete();

        return response()->json([
            "mensaje" => "ok",
        ]);
    }

    public function getRestart($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();

        return response()->json([
            "mensaje" => "ok",
        ]);
    }
}
