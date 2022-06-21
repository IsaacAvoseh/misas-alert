<?php

use App\Http\Controllers\ToastrController;
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

Route::get('/', [ToastrController::class, 'index'])->name('home');
Route::get('/check', [ToastrController::class, 'checkBilling'])->name('check');
Route::get('/billings', [ToastrController::class, 'billingRequest'])->name('billings');
Route::get('/approved', [ToastrController::class, 'checkApproved'])->name('approved');
Route::get('/dispensed', [ToastrController::class, 'checkDispensed'])->name('dispensed');
Route::get('/patient', [ToastrController::class, 'newPatient'])->name('patient');
Route::get('/message', [ToastrController::class, 'newMessage'])->name('message');
Route::get('/result', [ToastrController::class, 'patientResult'])->name('result');
Route::get('/prescription', [ToastrController::class, 'prescriptionAlert'])->name('prescription');
