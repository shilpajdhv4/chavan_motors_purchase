<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SalesExecutiveLogincontroller extends Controller
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

//    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function showLoginForm()
    {
        return view('auth.sales_executive_login');
    }
    
    public function login(Request $request) {
//        echo "<pre>";print_r($request->all());exit;
        if (Auth::attempt ( array (
                'mobile_no' => $request->get ( 'mobile_no' ),
                'password' => $request->get ( 'password' ) 
        ) )) {
                $user = \Auth::user();
//                $roles = $user->getRoleNames();
//                echo "<pre>"; print_r($roles);exit;
             if(!empty($user->getRoleNames()))
                foreach($user->getRoleNames() as $v){
                  if($v == "Sales Executive"){
                       session ( [ 
                                'mobile_no' => $request->get ( 'mobile_no' ) 
                        ] );
                        return redirect('home');
                  }else{
                      Auth::logout();
                      return redirect('sales-login');
                  }
                }           
        } else {
            Session::flash ( 'message', "Invalid Credentials , Please try again." );
            return redirect('sales-login');
        }
    }
}
