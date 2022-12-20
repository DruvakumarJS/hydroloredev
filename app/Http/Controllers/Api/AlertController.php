<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;
use App\Http\Controllers\web\FirebaseNotificationController;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alert_data=Alert::orderBy('id', 'DESC')->paginate(10);

     
        return view('alert.alerts',compact('alert_data'));
    }
    public function search($id)
    {
        $alert_data=Alert::where('sr_no',$id)->paginate(10);

     
        return view('alert.alerts',compact('alert_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        $input = $request;

      //  print_r($input);die();

        $hint='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $SR_NO='TR'.substr(str_shuffle($hint), 0, 9);
       
        $ticket_data=Alert::create([
                                    
                                     'issue'=>$input->subject,
                                     'status'=>'1',
                        
                                     'hub_id'=>$input->hub_id,
                                     'pod_id'=>$input->pod_id,
                                     'threshold_value'=>$input->threshold,
                                     'current_value'=>$input->current_value,
                                     'sr_no'=>$SR_NO]);

        //print_r("Data Inserted and Alert created ");

        $notification=new FirebaseNotificationController;

        $content = new Request
            ([
                'title'=>"Hydrolore",
                'body'=>$input->subject,
                   
            ]);

        $notification->show($content);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $action=$request->action;

       print_r($request->input());
     

       if($action=='save')
       {
          $status=$request->status;
          $srno=$request->sr_no;

          $update=Alert::Where('sr_no',$srno)
                        ->update(['status'=>$status]);

       }
      return redirect()->route('alerts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
