<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Facades\Auth;
use Session;

class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCompanysales($id){
        return view('admin_sales_page',['id'=>$id]);
    }


    public function index(Request $request)
    {
        // $user_comp_id = Auth::user()->comp_id;
        // $user = \Auth::user();
        // if(!empty($user->getRoleNames())){
        //         foreach($user->getRoleNames() as $v){
        //             if($v == "Admin" || $v == "Purchase Department"){
        //                 $data = User::orderBy('id','DESC')
        //                 // ->where(['is_active'=>0,])
        //                 ->get();
        //             }
        //             else{
        //                 $data = User::orderBy('id','DESC')->where(['is_active'=>0,'comp_id'=>$user_comp_id])->get();
        //             }
        //         }
        // }
        $data = User::orderBy('id','DESC')->get();
        return view('users.index',compact('data'));
         //   ->with('i', ($request->input('page', 1) - 1) * 5);
     //   return view('users.index',['data'=>$data]);
            //->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function mobileValidate($id) {
        $id = trim($id);
        if (\App\User::where(['mobile_no'=>$id,'is_active'=>0])->exists()) {
            echo "Mobile No Already exists!";
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        // $branch_details = \App\BranchDetails::orderBy('id','asc')->get();
        $branch_details = \App\Location::orderBy('loc_id','asc')->get();
      //  $depart_details = \App\DepartmentDetails::orderBy('id','asc')->get();
        $company_det = \App\Company::select('company_id','company_name')->get();
        return view('users.create',compact('roles'),['branch_details'=>$branch_details,'company_det'=>$company_det]);
    }

    public function getDept($id){
        $detail = \App\DepartmentDetails::select('id','depart_name')->where(['comp_id'=>$id,'is_active'=>0])->get();
        $data = "";
        $data = "<option value=''>-- Select Department --</option>";
        foreach($detail as $row){
            $data .= "<option value='".$row->depart_name."'>".$row->depart_name."</option>";
        }
        echo $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'mobile_no'=>'required'
        ]);
        
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

     //   $input = $request->all();
     //   echo "<pre>";print_r($input);exit;
     //   $input['password'] = Hash::make($input['password']);
      
    
//          if (\App\User::where(['mobile_no'=>$input['mobile_no'],'is_active'=>0])->exists()) {
// 			Session::flash('alert-danger', 'Mobile No Already exists!');
// 			return redirect()->route('users.index');
//         }else{
//         $user = User::create($input);
//         $user->assignRole($input['roles']);


        return redirect()->route('users.index')
                        ->with('success','User created successfully1');
//         }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
     //   $branch_details = \App\BranchDetails::orderBy('id','asc')->get();
        $branch_details = \App\Location::orderBy('loc_id','asc')->get();
        $depart_details = \App\DepartmentDetails::orderBy('id','asc')->where(['comp_id'=>$user->comp_id,'is_active'=>0])->get();
        $company_det = \App\Company::select('company_id','company_name')->get();
        $userRole = $user->roles->pluck('name','name')->all();


        return view('users.edit',['roles'=>compact('roles'),'user'=>$user,'userRole'=>$userRole,'branch_details'=>$branch_details,'depart_details'=>$depart_details,'company_det'=>$company_det]);//compact('user','roles','userRole','branch_details','depart_details'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));    
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query= \App\User::where('id', $id)->update(['is_active' => 1]);
       
       // User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}