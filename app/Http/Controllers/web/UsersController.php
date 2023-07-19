<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Validator;
use App\Models\Userdetail;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Hub;
use App\Models\Pod;
use App\Models\PodMaster;
use App\Models\Locations;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Hash;
use DB;


class UsersController extends Controller
{

     public function searchuser(Request $request){

      $output="";
      $searchdata=Userdetail::where('firstname','LIKE','%'.$request->search.'%')
                             ->orWhere('email','LIKE','%'.$request->search.'%')
                             ->orWhere('mobile','LIKE','%'.$request->search.'%')
                             ->orWhere('address','LIKE','%'.$request->search.'%')
                             ->orWhere('hub_id','LIKE','%'.$request->search.'%')->get();

      foreach ($searchdata as $key=> $searchdata) 
      
          {
            $id=$key+1;
            $output.=

            '<tr> 
              <td> '.$id.'</td>
              <td> '.$searchdata->firstname.' '.$searchdata->lastname.' </td>
              <td> '.$searchdata->email.' </td>
              <td> '.$searchdata->mobile.' </td>
              <td> '.$searchdata->address.' </td>
              <td> '.$searchdata->hub_id.' </td>
               <td>
                
             </td>
               <td> raise ticket</td>
               <td> </td>
               <td> </td>
  
            </tr>';

          }                       

       return response($output);

    }

    public function index()
    {
        
        $userData=Userdetail::paginate(50);
        
        return view('user/users',compact('userData'));
    }

    
    public function view($id)
    {

       
        $pods_list=Pod::where('user_id',$id)->get();
        $user_detail=Userdetail::where('id',$id)->get();
        $podMaster=PodMaster::all();

        $locations=Locations::all();
        
        return view('user/user_details',compact('pods_list' , 'user_detail' ,'podMaster', 'locations'));


    }


    public function store(Request $request)
    {

         if($request->action == 'cancel')
       {
         return redirect()->route('show_users');
       }
       else 
       {

       $validator = Validator::make($request->all(), [
            'firstname' => 'required|min:3',
            'mobile' => 'required|min:10|unique:userdetails',
            'email' => 'required|email|unique:userdetails',
            'location' => 'required',
            'address' => 'required',
            'hub_id' => 'required|unique:userdetails',
        ]);


       if ($validator->fails()) {
            return redirect()->route('show_add_user_form')
                        ->withErrors($validator)
                        ->withInput();
        }
    
      else{

      

       $hint='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $password='SYS'.substr(str_shuffle($hint), 0, 9);
       $encrypted_password=Hash::make($password);

       $user=new  User();
         $user->name=$request->firstname." ".$request->lastname;
         $user->email=$request->email;
         $user->role_id="3";
         $user->password=Hash::make($password);
       

      /* $logindata=User::create([
        'name'=>$request->firstname." ".$request->lastname,
        'email'=>$request->email,
        'password'=>Hash::make($password),
        'role_id',"3"]);
*/
       if($user->save())
       {
        $user_login_details=User::where('email',$request->email)->first();
        $user_id=$user_login_details->id;

        $request->request->add(['user_id'=>$user_id]);
 
        $data = $request->all();

        
    
        $insert=Userdetail::create($data);

       

        $user=Userdetail::where('mobile',$request->mobile)->first();

      

        $hubdata=Hub::create([
              'hub_id'=>$user->hub_id,
              'user_id'=>$user->id,
              'hub_name'=>$user->hub_id,
              'hub_location'=>$user->location,
              'pods_count'=>'0',
              'status'=>'active'

            ]);

    
         if($hubdata)
         { 
            $path = public_path('uploads');
            $filename = $path.'/'."Hydrolore Crop Maintaincance Guide.pdf";
            $url = url('/');
         
         Mail::to($user->email)->send(new WelcomeMail($user ,$filename , $password , $url ));

         }

        }
        else
        {
            return redirect()->route('Something went wrong')
                        ->withInput();

        }

        return redirect()->route('show_users');

     }

    }

    }

    
    public function show()
    {
        $hint='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $hubid='HUB'.substr(str_shuffle($hint), 0, 9);
        
        return view('user/add_users',compact('hubid'));

    }


    public function edit($id)
    {
        $pods="";
       $userdetail=Userdetail::where('id','=',$id)->get();
       $pods=Pod::where('user_id',$id)->get();

       return view('user/edit_user',compact('userdetail','pods'));

       
    }

   
    public function update(Request $request, $id)
    {

      if($request->pod_id)
      {
 
          $validator = Validator::make($request->all(), [
            'pod_id' => 'required|unique:pods,pod_id',
            'pod_name' => 'required'
        ]);


       if ($validator->fails()) {

            return redirect()->route('edituser',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
      }
       
       if($request->action == 'cancel')
       {
         return redirect()->route('show_users');
       }
       else if($request->action == 'Update') {


       $update=Userdetail::where('id', $id)
                             ->update(['firstname' => $request->firstname ,
                                     'lastname' => $request->lastname,
                                     'mobile' => $request->mobile,
                                     'email' => $request->email,
                                     'location' => $request->location,
                                     'address' => $request->address,
                                     'hub_id' => $request->hub_id
                                 ]);
       

       if($update)
       {

        $userdetailsdata=Userdetail::where('id',$id)->first();

        $user_id=$userdetailsdata->user_id;

      //  print_r($user_id);die();

        $update_user_login=User::where('id',$user_id)
                           ->update(['name' => $request->firstname,
                                     'email'=> $request->email
                                    ]);


        if($request->pod_id)
        {
        $Insert_pod=Pod::insert(['user_id'=>$id,
                                'pod_id'=>$request->pod_id,
                                'pod_name'=>$request->pod_name,
                                'hub_id'=>$request->hub_id,
                                'status'=>'active',
                                "created_at" =>  \Carbon\Carbon::now(),
                                "updated_at" => \Carbon\Carbon::now(), 
                            ]);
        }
         
         return redirect()->route('show_users');
       }

        }

        else {

        }

     }

   
    public function destroy($id)
    {

        $check_pods=Pod::where('user_id',$id)->get();

        if(sizeof($check_pods)>0)
        {
           return redirect()->route('edituser',compact('id'))->with('message', 'Please delete PODs associated with the user and then try delete');

        }
        else{

            $user_detail=Userdetail::where('id',$id)->first();

            $user_id=$user_detail->user_id;

         
         $delete=Userdetail::where('id',$id)
         ->delete();

         if($delete)
         {
         $deleteUserlogindata=User::where('id',$user_id)
         ->delete();

         $deleteHub=Hub::where('user_id',$user_id)
         ->delete();

        
         }

          return $this->index();
        }

       


    }

    public function autocomplete_user(Request $request){

      //  $data = User::select('name' , 'id')->where('name', 'LIKE',$request->get('search'))->get();
        $data = DB::table('userdetails')
            ->select(
                    DB::raw("CONCAT(firstname) AS value"),
                    'user_id',
                    'id'
                )
                    ->where('firstname', 'LIKE', '%'. $request->get('search'). '%')
                   
                    ->get(); 

        return response()->json($data);


    }
}
