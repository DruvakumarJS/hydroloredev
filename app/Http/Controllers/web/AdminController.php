<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\auth;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Facades\Mail; 
use App\Mail\AdminCredenetialsEmail;


class AdminController extends Controller
{
    public function login()
    {
       
        return view('login');
    }

    public function register()
    {
        auth()->user()->tokens()->delete();
        return view('registerform');
    }
     
    public function login_validation(Request $request)
    {
        $login_credentials=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(auth()->attempt($login_credentials)){
           
            $user_login_token= auth()->user()->createToken('passport_token')->accessToken;
             return redirect()->route('dashboard');

        }
        else{
           
           // return view('login');
            return redirect()->route('login');
        }
    }

    public function index(){
         $admins=User::where('role_id',2)->get();
         return view('admin/admins',compact('admins'));
    }

    public function add_admin(){
        return view('admin/add_admin');
    }

    public function store(Request $request)
    { 
       /* $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:4',
        ]);
        $user= User::create([
            'name' =>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        
        return view('login');*/


//      print_r($request->input());die();
      

     if($request->action == 'save')
       {


         $hint='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $password=substr(str_shuffle($hint), 0, 9);
         

         $user=new  User();

         $user->name=$request->name;
         $user->email=$request->email;
         $user->role_id="2";
         $user->password=Hash::make($password);

         $url = url('/');

         Mail::to($request->email)->send(new AdminCredenetialsEmail($user , $password , $url));

         if($user->save())
         {
            return redirect()->route('admins');
         }


         
     }
       
}

public function destroy($id){

    $delete=User::where('id',$id)
         ->delete();

         return redirect()->route('admins');

}

public function logout()
    {
        auth()->user()->tokens()->delete();
        session()->flush();

        return redirect()->route('login');
    }

 public function authenticatedUserDetails(){
        //returns details
        return response()->json(['authenticated-user' => auth()->user()], 200);
    }

 public function resetPassword(){

    $email=auth()->user()->email;

    return view('admin/reset_admin_password',compact('email'));
 }  

 public function update(Request $request){


    $email=$request->email;
    $password=$request->password;
    $password_confirmation=$request->password_confirmation;

    if($password!=$password_confirmation){

         return redirect()->route('resetpassword')
                        ->with('message', 'password and confirm password do not match')
                        ->withInput();
    }
    else{
         $admin=User::where('email',$email)
                      ->update(['password'=>Hash::make($password)]);

                     return redirect()->route('show_settings');

    }

   
 }  

}
