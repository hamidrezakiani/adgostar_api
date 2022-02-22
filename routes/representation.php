<?php

use App\Http\Controllers\Representation\Agent\DetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('login', 'Auth\LoginController');
Route::get('representationDetail',[DetailController::class,'index']);
Route::group(['prefix' => 'agent','middleware' => 'auth:representation'], function () {
    Route::resource('detail','DetailController');
    Route::resource('users','Agent\UserController');
    Route::resource('subsets','Agent\SubsetController');
    Route::resource('userTickets','Agent\UserTicketController');
    Route::resource('userTickets.messages','Agent\UserTicketMessageController');
    Route::resource('subsetTickets','Agent\SubsetTicketController');
    Route::resource('subsetTickets.messages','Agent\SubsetTicketMessageController');
    Route::resource('tickets','Agent\TicketController');
    Route::resource('tickets.messages','Agent\TicketMessageController');
    Route::resource('products', 'Agent\ProductController');
    Route::resource('items.periods', 'Agent\ItemPeriodController')->shallow();
});
Route::group(['prefix' => 'user','middleware' => 'auth:user'], function () {
    Route::resource('detail','DetailController');
    Route::resource('tickets', 'User\TicketController');
    Route::resource('tickets.messages','User\TicketMessageController');
});
Route::resource('categories', 'CategoryController');
Route::resource('services', 'ServiceController');
Route::resource('orders','User\OrderController');
Route::resource('orders.times','User\OrderTimeController');
Route::get('instagram-validation',function(Request $request){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.instagram.com/'.$request->id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Cookie: mid=YIu8bwAEAAFX_l8XIylHTdFJI5aG; ig_did=8B04B930-A40E-416B-B9DE-06A16F856624; ig_nrcb=1; csrftoken=7v1Pmmxpva3FSrzzedhmDxxPcdSLcVhZ'
        ),
    ));

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    echo('https://www.instagram.com/' . $request->id);
    echo $httpcode;
});


Route::get('persian-next-month-data', function (Request $request) {
    if ($request->month == 12) {
        $month = 1;
        $year = $request->year + 1;
    } else {
        $month = $request->month + 1;
        $year = $request->year;
    }
    $v = Verta();
    $v->year($year);
    $v->month($month);
    $v->day(1);
    $monthData = (object)[];
    $monthData->year = $v->year;
    $monthData->month = $v->month;
    $monthData->dayOfWeek = $v->dayOfWeek;
    $monthData->daysInMonth = $v->daysInMonth;
    $monthData->holidays = [8,15,13,19];
    return response()->json(['data' => $monthData], 200);
});

Route::get('persian-previous-month-data', function (Request $request) {
    if ($request->month == 1) {
        $month = 12;
        $year = $request->year - 1;
    } else {
        $month = $request->month - 1;
        $year = $request->year;
    }
    $v = Verta();
    $v->year($year);
    $v->month($month);
    $v->day(1);
    $monthData = (object)[];
    $monthData->year = $v->year;
    $monthData->month = $v->month;
    $monthData->dayOfWeek = $v->dayOfWeek;
    $monthData->daysInMonth = $v->daysInMonth;
    $monthData->holidays = [16, 25, 1,19];
    return response()->json(['data' => $monthData], 200);
});

