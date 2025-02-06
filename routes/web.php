<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/zoho-crm', function () {
    return view('zoho-crm');
});

Route::get('/account-form', function () {
    return view('account.create-form');
});
Route::get('/deal-form', function () {
    return view('deal.create-form');
});
