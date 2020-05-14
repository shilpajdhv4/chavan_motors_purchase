<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PurchaseLoginController extends Controller
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
        return view('auth.purchase_login');
    }
    
    public function login(Request $request) {
//        echo "<pre>";print_r($request->all());exit;
        if (Auth::attempt ( array (
                'mobile_no' => $request->get ( 'mobile_no' ),
                'password' => $request->get ( 'password' ),
                'is_active'=>0,
        ) )) {
             $user = \Auth::user();
           //  $user = \App\user::where(['is_active'=>0,'mobile_no'=>$request->get ('mobile_no')])->orderBy('id','desc')->first();
            // echo "<pre>";print_r($users);exit;
             if(!empty($user->getRoleNames()))
                foreach($user->getRoleNames() as $v){
                  if($v == "Purchase Department"){
                       session ( [ 
                                'mobile_no' => $request->get ( 'mobile_no' ) 
                        ] );
                        return redirect('home');
                  }else{
                      Auth::logout();
                      Session::flash ( 'message', "Invalid Credentials , Please try again." );
                      return redirect('purchase-login');
                  }
                }           
        } else {
            Session::flash ( 'message', "Invalid Credentials , Please try again." );
            return redirect('purchase-login');
        }
    }
}
