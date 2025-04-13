<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PharmacyController;

Route::get('/pharmacies/open', [PharmacyController::class, 'getOpenPharmacies']);
Route::get('/pharmacies/{id}/masks', [PharmacyController::class, 'getMasks']);
Route::get('/pharmacies/filter', [PharmacyController::class, 'filterByMaskCount']);
