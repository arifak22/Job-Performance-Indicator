<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Sideveloper;
use Auth;
use Request;
use DB;
use URL;
use Hash;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function getIndex(){
        return view('login');
        // print_r(Auth::check());
    }

    public function postAuth(){
        $credentials = Request::only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $res['api_status']  = 1;
            $res['api_message'] = 'Berhasil Login';
            Request::session()->put('menus', Sideveloper::getMenu(Auth::user()->id_privilege));
            Request::session()->put('access', Sideveloper::getAccess(Auth::user()->id_privilege));
            $res['url']         = Request::session()->get('last_url') ? Request::session()->get('last_url') : url('home');
        }else{
            $res['api_status']  = 0;
            $res['api_message'] = 'Maaf, Username dan Password tidak sesuai';
        }
        return response()->json($res);

    }
}
