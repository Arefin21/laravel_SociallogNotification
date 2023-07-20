<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use OpenAI\Laravel\Facades\OpenAI;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('login/facebook',[SocialController::class,'facebookRedirect']);
Route::get('login/facebook/callback',[SocialController::class,'loginWithFacebook']);

Route::get('/send-notification',function(){
    //$user=User::find(1);
   // $user->notify(new EmailNotification());
   // Notification::send($user, new EmailNotification());
   $users=User::all();
   foreach($users as $user){
    Notification::send($user, new EmailNotification('Arefin','Email'));
   }
    return redirect()->back();
});


Route::get('/openai',function(){

    $result = OpenAI::completions()->create([
        'model' => 'text-davinci-003',
        'prompt' => 'PHP is',
]);

echo $result['choices'][0]['text'];

});