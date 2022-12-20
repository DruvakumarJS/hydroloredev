<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Userdetail;
use App\Models\Questions;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChatVerificationOtp;
use App\Mail\FirstEmail;
use App\Mail\NewInquiry;
use App\Mail\GenerateTicket;
use App\Models\Ticket;


class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function newInquiry(Request $request){
        $user= json_decode($request->getContent(), true);
        $mail = Mail::to($user['email'])->send(new NewInquiry($user));
        return response()->json([
            'status' => 1,
            'message' => 'Mail Sent Successfully',
        ],200);
    }

    public function verifyOtp(Request $request){
        $data= json_decode($request->getContent(), true);
        $user = Userdetail::where('email',$data['email'])->where('otp',$data['otp'])->first();
        if($user){
            return response()->json([
                'status' => 1,
                'name' => $user->firstname.' '.$user->lastname,
                'message' => 'success',
            ],200);
        }
        return response()->json([
            'status' => 0,
            'message' => 'failed',
        ],200);
        

    }
    public function validateUser(Request $request){

        $data= json_decode($request->getContent(), true);
        $user = Userdetail::where('email',$data['email'])->first();
       
        if($user){
            $randomOtp = rand(1000, 9999); 
            $user->otp = $randomOtp;
            $user->save();
            // Mail::send('emails.chatVerificationOtp', ['content' => 'foo'], function (Message $message) {
            //     $message
            //         ->subject('Hydrolore')
            //         ->to($data['email'], 'foo_name')
            //         ->from('noreply@netiapps.com', 'bar_name')
            //         ->embedData([
            //             'custom_args' => [
            //                 'OTP' => $user->otp// Make sure this is a string value
            //             ],
            //             'template_id' => 'd-5765a561d0204427a884f172fd9349b1'
            //         ], 'sendgrid/x-smtpapi');
            // });
            // $this->template_id = "your sendgrid template id";
            $this->to = $data['email'];
            $this->subject = "Hydrolore";
            Mail::to($data['email'])->send(new ChatVerificationOTP($user));
            return response()->json([
                'status' => 1,
                'otp' => $user->otp,
                'message' => 'Mail Sent Successfully',
            ],200);
        }
        return response()->json([
            'status' => 0,
            'message' => 'No user found for this email '. $data['email'],
        ],200);
    }

    // public function sendOtp($user){
    //   $user['email'] = $request->email;
    //   $user['otp'] = $request->otp;
    //   Mail::to('janagiraman@netiapps.com')->send(new ChatVerificationOTP($request));
    // }

    public function getQuestions(){
         $questions =  Questions::all();
         if($questions){
            return response()->json([
                'status' => 1,
                'questions' => $questions
            ],200);
         }

    }

    public function generateTicket(Request $request){
        $data= json_decode($request->getContent(), true);
        $user = UserDetail::where('email',$data['email'])->first();
        $problems = ltrim(implode('$',$data['problems']),'$');

        $hint='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $sr_no='UR'.substr(str_shuffle($hint), 0, 8);
        $date = date('Y-m-d');
        $isExist=Ticket::where('user_id',$user->id)
                                         ->Where('created_at', 'like', $date.'%')
                                        ->first();
                
        if($isExist){
           // Mail::to($data['email'])->send(new GenerateTicket($user, $sr_no));
            return response()->json([
                'status' => 0,
                'message' => 'Your ticket has been already generated, Our executive will contact you.'
            ],200);
        }

        $ticket = new Ticket();

        $ticket->user_id = $user->id;
        $ticket->subject = $problems;
        $ticket->sr_no = $sr_no;
        $ticket->status = 1;
        $ticket->hub_id = $user->hub_id;
        $ticket->pod_id = $user->hub_id;
        if($ticket->save()){
            Mail::to($data['email'])->send(new GenerateTicket($user, $sr_no,$problems));
            return response()->json([
                'status' => 1,
                'message' => 'success'
            ],200);
        }
        return response()->json([
            'status' => 0,
            'message' => 'failed'
        ],200);

    }
}
