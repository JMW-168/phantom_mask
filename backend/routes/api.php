<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\UserStatController;
use App\Http\Controllers\TransactionStatController;

Route::get('/pharmacies/open', [PharmacyController::class, 'getOpenPharmacies']);
Route::get('/pharmacies/{id}/masks', [PharmacyController::class, 'getMasks']);
Route::get('/pharmacies/filter', [PharmacyController::class, 'filterByMaskCount']);

Route::get('/users/top', [UserStatController::class, 'topUsers']);
Route::get('/transactions/summary', [TransactionStatController::class, 'summary']);