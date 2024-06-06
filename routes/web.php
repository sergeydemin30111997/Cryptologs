<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Referral;

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
Route::get('/', function () {
    return view('welcome');
})->name('main');
Route::get('ref/{id}', function ($partner_id) {
    $partner_id = User::find($partner_id);
    if ($partner_id) {
        Referral::setCookie($partner_id->id);
    }
    return view('welcome');
})->name('ref_link');
Route::get('setlocale/{locale}', function ($locale) {

    if (in_array($locale, Config::get('app.locales'))) {
        Session::put('locale', $locale);
    }

    return back();

})->name('set_locale');
Route::get('faq', [App\Http\Controllers\MainController::class, 'faq'])->name('faq');
Route::get('auth/login', [App\Http\Controllers\AuthTelegram\LoginController::class, 'loginTelegram']);
Route::middleware(['auth', 'confirm'])->group(function () {
    Route::get('dashboard/{all}', [App\Http\Controllers\AuthTelegram\LoginController::class, 'test1'])->name('dashboard.all');
    Route::get('dashboard', [App\Http\Controllers\AuthTelegram\LoginController::class, 'test1'])->name('dashboard');
    Route::get('profile', [App\Http\Controllers\User\ProfileController::class, 'profileUser'])->name('profile');
    Route::get('profile/history', [App\Http\Controllers\User\ProfileController::class, 'historyUser'])->name('profile.history');
    Route::get('project_logs/{all}', [App\Http\Controllers\ProjectLogs\LogsController::class, 'index'])->name('project_logs.all');
    Route::resource('project_logs', App\Http\Controllers\ProjectLogs\LogsController::class)->names('project_logs');
    Route::resource('confirm_users', App\Http\Controllers\User\ConfirmationController::class)->names('confirm_users');
    Route::get('user_list', [App\Http\Controllers\User\UserController::class, 'index'])->name('user_list');
    Route::resource('user', App\Http\Controllers\User\UserController::class)->except('index')->names('user_data');
    Route::resource('payments_request', App\Http\Controllers\User\PaymentsRequestController::class)->names('payments_request');
    Route::resource('demo_project', App\Http\Controllers\DemoProject\DemoProjectController::class)->names('demo_project');
    Route::resource('request_demo_project', App\Http\Controllers\DemoProject\RequestDemoProjectController::class)->names('request_demo_project');
    Route::resource('alerts', App\Http\Controllers\User\AlertsController::class)->names('alerts');
    Route::resource('referrals', App\Http\Controllers\User\ReferralController::class)->names('referrals');
    Route::get('charges/{user_id}', [App\Http\Controllers\User\ChargesController::class, 'index'])->name('charges.user_id');
    Route::resource('charges', App\Http\Controllers\User\ChargesController::class)->names('charges');
});
