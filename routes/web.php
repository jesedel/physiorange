<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Onboarding');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/monthlyPlan', function () {
    return Inertia::render('MonthlyPlanSelection');
})->name('monthlyPlan');


Route::middleware(['auth:sanctum', 'verified'])->get('/createSubscription', function (Request $request) {
    $user = $request->user();

    $item = new \Laravel\Cashier\Charge\ChargeItemBuilder($user);
    $item->unitPrice(money(100,'EUR')); //1 EUR
    $item->description('Test Item 1');
    $chargeItem = $item->make();

    $item2 = new \Laravel\Cashier\Charge\ChargeItemBuilder($user);
    $item2->unitPrice(money(200,'EUR'));
    $item2->description('Test Item 2');
    $chargeItem2 = $item2->make();

    $result = $user->newCharge()
        ->addItem($chargeItem)
        ->addItem($chargeItem2)
        ->create();

    if(is_a($result, \Laravel\Cashier\Http\RedirectToCheckoutResponse::class)) {
        return $result;
    }

    return back()->with('status', 'Thank you.');
})->name('createPayment');


Route::middleware(['auth:sanctum', 'verified'])->get('/createPayment/{plan}', function (Request $request, $plan) {

        $user = $request->user();


        $name = ucfirst($plan) . ' membership';

        if(!$user->subscribed($name, $plan)) {
            dump($user->subscribed($name, $plan));
            $result = $user->newSubscription($name, $plan)->create();


            if(is_a($result, RedirectToCheckoutResponse::class)) {
                return $result; // Redirect to Mollie checkout
            }

            return back()->with('status', 'Welcome to the ' . $plan . ' plan');
        }

        return back()->with('status', 'You are already on the ' . $plan . ' plan');
})->name('createPayment');
