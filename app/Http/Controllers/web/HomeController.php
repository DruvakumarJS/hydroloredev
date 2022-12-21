<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Hub;
use App\Models\Pod;
use App\Models\Alert;
use App\Models\Userdetail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $date=date('Y-m-d');
        
        //echo url('/'); die();
        
        
        $hubs=Hub::all();
        $hub_count=$hubs->count();

        $pods=Pod::all();
        $pods_count=$pods->count();

        $ticket=Ticket::all();
        $tickets_count=$ticket->count();

       
        $alerts=Alert::all();
        $alert_count=$alerts->count();


        $chart = Userdetail::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAY(created_at) as day"),\DB::raw('max(created_at) as createdAt'))
        ->whereYear('created_at', date('Y'))
        ->groupBy('day')
        ->orderBy('createdAt')
        ->get();

        $ticketschart = Ticket::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAY(created_at) as day"),\DB::raw('max(created_at) as createdAt'))
        ->whereYear('created_at', date('Y'))
        ->groupBy('day')
        ->orderBy('createdAt')
        ->get();

        $tickets_closed_chart = Ticket::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAY(updated_at) as day"),\DB::raw('max(updated_at) as updatedAt'))
        ->whereYear('created_at', date('Y'))
        ->groupBy('day')
        ->orderBy('updatedAt')
        ->get();


       $tickets=Ticket::where('status','!=','0')
                        ->where('created_at','LIKE','%'.$date.'%')->paginate(10);



       // print_r($data);die();

         return view('home',compact('tickets', 'pods_count' ,'hub_count','alert_count','chart','ticketschart','tickets_closed_chart','tickets_count'));
         
       }

    public function show()
    {

        print_r($date);exit();
       
    }
    public function destroy(){
         auth()->logout();
         return redirect()->route('login');
    }
}
