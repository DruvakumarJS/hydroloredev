<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\CustomerController;
use App\Http\Controllers\web\UsersController;
use App\Http\Controllers\web\AdminController;
use App\Http\Controllers\web\SettingsController;
use App\Http\Controllers\web\TicketsController;
use App\Http\Controllers\web\EmailController;
use App\Http\Controllers\web\HubController;
use App\Http\Controllers\web\PODController;

use App\Http\Controllers\web\FirebaseNotificationController; 

use App\Http\Controllers\web\QuestionsController;
use App\Http\Controllers\web\LocationController;
use App\Http\Controllers\Api\AlertController;

use App\Http\Controllers\CropController;
use App\Http\Controllers\CultivationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SensorNotificationController;
use App\Http\Controllers\ActivityController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     // User is authentication and has admin role
//     echo 'Admin';
// });

// Route::middleware(['auth', 'role:customer'])->group(function () {
//     // User is authentication and has admin role
//     echo 'Customer';
// });

Route::get('/', function () {
   // return view('welcome');
    return redirect(route('login'));    
});

// Route::group(['middleware' => ['admin']], function () {
//     echo 'COMSHHH';
// });

Auth::routes();

// Route::middleware(['auth','isAdmin'])->group(function () {
//    // return 'Admin';
//     Route::get('/home', [HomeController::class, 'index'])->name('home');
//     Route::get("logout",[HomeController::class,"destroy"])->name("logout");
//     Route::get('hub_details', [HubController::class,'show'])->name('hub_detail');
// }); 
Route::middleware('auth:web')->group(function () {
            Route::get("logout",[HomeController::class,"destroy"])->name("logout");
            
        //       //pods
        //       Route::post('add_pods',[PODController::class,'store'])->name('add_pods');
        //       Route::get('deletepod/{id}',[PODController::class,'destroy'])->name('deletepod');
        //       Route::get('view_pod/{id}',[PODController::class,'edit'])->name('view_pod');
        //       Route::post('update_pods/{id}',[PODController::class,'update'])->name('update_pods');
        //       Route::get('pods',[PODController::class,'index'])->name('pods');
        //       Route::get('POD_History/{id}'$QgIcsnU8QNnJ7&AA1,[PODController::class,'show'])->name('pod_history');
           
     Route::middleware(['auth','isAdmin'])->group(function () {
            //dashboad  
           
           
           Route::get('/home', [HomeController::class, 'index'])->name('home');
           Route::get('hubs', [HubController::class, 'search'])->name('hub_serach');

           Route::get('tickets',[TicketsController::class,'index'])->name('show_tickets');
           Route::get('tickets/{id}',[TicketsController::class,'search'])->name('search_ticket');

            // users
            Route::get('users',[UsersController::class,'index'])->name('show_users');
            Route::post('create_user',[UsersController::class,'store'])->name('create_new_users');
            Route::get('add_new_users',[UsersController::class,'show'])->name('show_add_user_form');
            Route::get('edituser/{id}',[UsersController::class,'edit'])->name('edituser');
            Route::get('deleteuser/{id}',[UsersController::class,'destroy'])->name('deleteuser');
            Route::post('updateuser/{id}',[UsersController::class,'update'])->name('updateuser');
            Route::get('user_details/{id}',[UsersController::class,'view'])->name('view_user_details');
            Route::get('autocomplete_user',[UsersController::class,'autocomplete_user'])->name('autocomplete_user');
          //Route::get('search', [UsersController::class,'search']);


            Route::get('/notification', [FirebaseNotificationController::class, 'index'])->name('notification');
            Route::post('/save-token', [FirebaseNotificationController::class, 'store'])->name('save-token');
            Route::post('/send-notification', [FirebaseNotificationController::class, 'show'])->name('send.notification');

            //ticket
            // Route::get('tickets',[TicketsController::class,'index'])->name('show_tickets');
            // Route::get('tickets/{id}',[TicketsController::class,'search'])->name('search_ticket');

            Route::get('view_ticket/{id}',[TicketsController::class,'edit'])->name('view_ticket');
            Route::post('update_status',[TicketsController::class,'modify'])->name('update_status');
            Route::get('delete_ticket/{id}',[TicketsController::class,'destroy'])->name('delete_ticket');

            Route::get('ticket_generate_form',[TicketsController::class,'show'])->name('add_tickets');
            Route::get('ticket_generate_form/{email}',[TicketsController::class,'show'])->name('raise_tickets');
            Route::get('redirect_add_tickets',[TicketsController::class,'show'])->name('redirect_add_tickets');
            Route::post('genarate_tickets',[TicketsController::class,'store'])->name('genarate_tickets');
            Route::post('genarate_tickets',[TicketsController::class,'store'])->name('genarate_tickets');
            Route::post('modify_status',[TicketsController::class,'update'])->name('modify_status');
            /*Route::post('search_tickets',[TicketsController::class,'search'])->name('search_tickets');*/


            //pods
            Route::post('add_pods',[PODController::class,'store'])->name('add_pods');
            Route::get('deletepod/{podid}',[PODController::class,'destroy'])->name('deletepod');
            Route::get('view_pod/{id}',[PODController::class,'edit'])->name('view_pod');
            Route::post('update_pods/{id}',[PODController::class,'update'])->name('update_pods');
            Route::get('pods',[PODController::class,'index'])->name('pods');
            Route::get('sensor_status/{id}',[PODController::class,'show'])->name('sensor_status');
            Route::get('pod_history/{id}',[PODController::class,'history'])->name('pod_history');
            Route::get('searchpod', [PODController::class,'searchpod']);
            Route::post('filter', [PODController::class,'filter'])->name('filter_history');
            Route::post('export',[PODController::class,'export'])->name('exportdata');
            // Route::post('exportdata', 'PODController@export');



            //Alerts
            Route::get('alerts',[AlertController::class,'index'])->name('alerts');
            Route::get('alert/{id}',[AlertController::class,'search'])->name('search_alert');
            Route::post('update', [AlertController::class,'update'])->name('modify_alert_status');


            // Question 
            Route::get('questions',[QuestionsController::class, 'index'])->name('questions');
            Route::get('add_question',[QuestionsController::class, 'create'])->name('add_question');
            Route::post('save_question',[QuestionsController::class, 'store'])->name('save_question');
            Route::get('edit_question/{id}',[QuestionsController::class, 'edit'])->name('edit_question');
            Route::post('update_question/{id}',[QuestionsController::class, 'update'])->name('question.update');
            Route::get('deleteQuestion/{id}',[QuestionsController::class,'destroy'])->name('deleteQuestion');

            // Location
            Route::get('locations', [LocationController::class, 'index'])->name('locations');
            Route::get('add-locations', [LocationController::class, 'create'])->name('add-location');
            Route::post('save-location', [LocationController::class, 'store'])->name('save-location');
            Route::get('edit-location/{id}', [LocationController::class, 'edit'])->name('edit-location');
            Route::post('update-location/{id}',[LocationController::class, 'update'])->name('location.update');
            Route::get('deletelocation/{id}',[LocationController::class,'destroy'])->name('deletelocation');


            // others
            Route::get('settings',[SettingsController::class,'index'])->name('show_settings');
            Route::get('hub_details', [HubController::class,'show'])->name('hub_detail');

            Route::get('admins', [AdminController::class, 'index'])->name('admins');
            Route::get('add_admin',[AdminController::class, 'add_admin'])->name('add_admin');
            Route::post('save_admin',[AdminController::class, 'store'])->name('create_new_admin');
            Route::get('delete/{id}',[AdminController::class, 'destroy'])->name('delete_admin');
            Route::get('resetpassword',[AdminController::class, 'resetPassword'])->name('resetpassword');
            Route::post('update_admin_password',[AdminController::class, 'update'])->name('update_admin_password');

            //crops
            Route::get('add_crops/{id}',[CultivationController::class,'create'])->name('add_crops');
            Route::get('getcrops',[CultivationController::class,'getcrops'])->name('getcrops');
            Route::post('save_channel',[CultivationController::class,'store'])->name('save_channel');
            Route::put('update-channel/{id}',[CultivationController::class,'update'])->name('update_channel');
            Route::get('remove-channel/{id}',[CultivationController::class,'destroy'])->name('remove_channel');
            Route::post('save-harvest-data',[CultivationController::class,'save_harvest_data'])->name('save_harvesting_data');
            Route::get('channel-details/{id}',[ActivityController::class,'index'])->name('channel_details');

            Route::get('reports',[CultivationController::class,'report'])->name('reports');
            Route::get('download/{id}',[CultivationController::class,'download'])->name('download');

            Route::get('Category-master',[CategoryController::class,'index'])->name('Category_master');
            Route::post('save-category',[CategoryController::class,'store'])->name('save_category');
            Route::put('update-category/{id}',[CategoryController::class,'update'])->name('update_category');
            Route::get('delete-category/{id}',[CategoryController::class,'destroy'])->name('delete_category');

            Route::get('Crop-master',[CropController::class,'index'])->name('Crop_master');
            Route::post('save-crop',[CropController::class,'store'])->name('save_crop');
            Route::post('search-crop',[CropController::class,'search'])->name('search_crop');
            Route::put('update-crop/{id}',[CropController::class,'update'])->name('update_crop');
            Route::get('delete-crop/{id}',[CropController::class,'destroy'])->name('delete_crop');

            Route::get('sensor-notification_master',[SensorNotificationController::class,'index'])->name('sensor_master');
            Route::post('save_sensor_solution',[SensorNotificationController::class,'store'])->name('save_sensor_solution');
            Route::get('delete-solution/{id}',[SensorNotificationController::class,'destroy'])->name('delete_solution');
            Route::put('update-solution/{id}',[SensorNotificationController::class,'update'])->name('update_sensor_solution');

 
        }); 
        Route::middleware(['auth','isCustomer'])->group(function () {
                
                Route::get('/customer-dashboard', [CustomerController::class, 'index'])->name('customer-dashboard');
                Route::get('mypods',[CustomerController::class,'mypods'])->name('my_pods');
                Route::get('myhubs',[CustomerController::class,'myhubs'])->name('my_hubs');
                Route::get('mytickets',[CustomerController::class,'mytickets'])->name('my_tickets');
                Route::get('raiseticket',[CustomerController::class,'raiseticket'])->name('raise_ticket');
                Route::post('saveticket',[CustomerController::class,'saveticket'])->name('save_ticket');
                Route::get('reset_password',[CustomerController::class,'reset_password'])->name('reset_password');
                Route::post('update_password',[CustomerController::class,'update_password'])->name('update_password');
               
        });
});