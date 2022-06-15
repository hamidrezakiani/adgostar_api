<?php

use App\Http\Controllers\PaymentController;
use App\Services\Payment\CreateTransaction;
use Illuminate\Support\Facades\Route;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

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
Route::get('payment/pay',[PaymentController::class,'create']);

Route::post('payment/verify',[PaymentController::class,'verify']);

Route::get('persian-next-month-data',function(Request $request){
    // $verta = new Verta();
    // $verta->year(1400);
    // $verta->month(5);
    // $verta->day(2);
    // $verta->hour(17);
    // $verta->minute(0);
    // $verta->second(0);
    // return $verta->timestamp;
    // $verta->timestamp(time());
    // $time = (object)[];
    // $time->year = $verta->year;
    // $time->month = $verta->month;
    // $time->day = $verta->day;

    if($request->month == 12)
    {
        $month = 1;
        $year = $request->year+1;
    }
    else
    {
        $month = $request->month + 1;
        $year = $request->year;
    }
    $v = Verta();
    $v->year($year);
    $v->month($month);
    $monthData = (object)[];
    $monthData->year = $v->year;
    $monthData->month = $v->month;
    $monthData->dayOfWeek = $v->dayOfWeek;
    $monthData->daysInMonth = $v->daysInMonth;
    return response()->json(['data' => $monthData],200);
});
Route::get('persian-time',function(Request $request){
   $verta = new Verta();
   $verta->timestamp(time());
   $time = (object)[];
   $time->year = $verta->year;
   $time->month = $verta->month;
   $time->day = $verta->day;
   $time->dayOfWeek = $verta->dayOfWeek;
   $time->daysInMonth = $verta->daysInMonth;
   return response()->json(['data' => $time], 200);
});



