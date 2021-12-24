<?php

use Illuminate\Support\Facades\Route;

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


/*
|--------------------------------------------------------------------------
| App Default Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Custom added Routes
|--------------------------------------------------------------------------
*/

// Privacy policy
Route::get('/privacy_policy', function () {
    return view('privacy_policy');
})->name('privacy.policy');

// Contacts
Route::get('/contacts', [App\Http\Controllers\ContactController::class, 'index'])->name('contacts.all');
Route::delete('/contacts/{contact}', [\App\Http\Controllers\ContactController::class, 'destroy'])->name('contacts.delete');

// Phone numbers
Route::delete('/contacts/{contact}/phone_numbers/{phone_number}', [App\Http\Controllers\PhoneNumberController::class, 'destroy'])->name('phone_numbers.delete');

//Route::delete('/contacts/{contact}/phone_numbers/{phone_number}', function () {
//    dd('hello');
//})->name('phone_numbers.delete');

// Test routs
