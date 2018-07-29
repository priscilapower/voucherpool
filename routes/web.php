<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', 'VoucherCodesController@index');
$router->post('/generate-voucher', 'VoucherCodesController@generateVoucher');
$router->post('/validate-voucher', 'VoucherCodesController@validateVoucher');
$router->post('/recipient-vouchers', 'VoucherCodesController@getVoucherByRecipientEmail');