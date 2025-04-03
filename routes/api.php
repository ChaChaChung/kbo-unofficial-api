<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test','TestController@index');
Route::get('/migrate/all_teams','TestController@Migrate_All_Teams');

Route::get('/get/all_teams','TeamController@Get_All_Teams');
Route::get('/get/team_past_events/{team_id}','TeamController@Get_Team_Past_Events');
Route::get('/get/team_next_events/{team_id}','TeamController@Get_Team_Next_Events');

Route::get('/get/league_next_events/{date}','EventController@Get_League_Events');
// Route::get('/get/league_last_events/{date}','EventController@Get_League_Last_Events');

Route::post('/get/schedule','ScheduleController@Get_Schedule');
Route::get('/get/schedule/2','ScheduleController@Get_Schedule2');
