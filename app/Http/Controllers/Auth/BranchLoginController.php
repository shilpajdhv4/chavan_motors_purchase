<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BranchLoginController extends Controller
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
        return view('auth.branch_admin_login');
    }
    
    public function login(Request $request) {
//        echo "<pre>";print_r($request->all());exit;
        if (Auth::attempt ( array (
                'mobile_no' => $request->get ( 'mobile_no' ),
                'password' => $request->get ( 'password' ) 
        ) )) {
             $user = \Auth::user();
             if(!empty($user->getRoleNames()))
                foreach($user->getRoleNames() as $v){
                  if($v == "Branch Admin"){
                       session ( [ 
                                'mobile_no' => $request->get ( 'mobile_no' ) 
                        ] );
                        return redirect('home');
                  }else{
                      Auth::logout();
                      return redirect('branch-login');
                  }
                }           
        } else {
            Session::flash ( 'message', "Invalid Credentials , Please try again." );
            return redirect('branch-login');
        }
    }
}
