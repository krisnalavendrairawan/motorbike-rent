<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BikeReportController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CustomerPageController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonthlyReportController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WeeklyReportController;
use App\Http\Controllers\YearlyReportController;
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

Route::get('/', [CustomerPageController::class, 'index'])->name('landing.index');
// Route::get('/landing-page', [CustomerPageController::class, 'index'])->name('landing.index');



Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register-customer', [AuthController::class, 'showRegisterFormCustomer'])->name('customer.register');
    Route::post('register-customer', [AuthController::class, 'registerCustomer'])->name('customer.register.create');
    Route::get('/login-customer', [AuthController::class, 'showLoginFormCustomer'])->name('customer.login.index');
    Route::post('login-customer', [AuthController::class, 'loginCustomer'])->name('customer.login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout-customer', [AuthController::class, 'logoutCustomer'])->name('customer.logout');

Route::middleware(['customer', 'role:customer'])->group(function () {
    Route::get('/customer/profile', [CustomerController::class, 'editProfile'])->name('customer.profile');
    Route::put('/customer/profile', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');

    Route::get('/catalog', [CustomerPageController::class, 'catalog'])->name('catalog.index');
    Route::get('/catalog/{id}', [CustomerPageController::class, 'show'])->name('catalog.detail');

    Route::get('/customer/rental/{id}', [CustomerPageController::class, 'createRental'])->name('customer.rental');
    Route::post('/customer/rental', [CustomerPageController::class, 'store'])->name('customer.rental.store');
    // Route::post('/rental/confirm-payment', [RentalController::class, 'confirmPayment'])->name('rental.confirm-payment');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::post('payments/notification', [TransactionController::class, 'notification'])->name('transaction.notification');
    Route::post('/transaction/{orderId}/update-status', [TransactionController::class, 'updatePaymentStatus'])->name('transaction.update-status');
    Route::get('/transaction/detail/{transaction}', [TransactionController::class, 'detailTransaction'])->name('transaction.detail');


});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('user', UserController::class)->except(['show']);
    Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('user/datatable', [UserController::class, 'datatable'])->name('user.datatable');
    Route::get('profile', [UserController::class, 'editProfile'])->name('user.profile');
    Route::put('profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('change-password', [UserController::class, 'editPassword'])->name('user.password');
    Route::put('change-password', [UserController::class, 'updatePassword'])->name('user.password.update');

    Route::resource('customer', CustomerController::class);
    Route::delete('customer/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');
    Route::post('customer/datatable', [CustomerController::class, 'datatable'])->name('customer.datatable');

    Route::resource('brand', BrandController::class);
    Route::delete('brand/{brand}', [BrandController::class, 'destroy'])->name('brand.destroy');
    Route::post('brand/datatable', [BrandController::class, 'datatable'])->name('brand.datatable');

    Route::resource('service', ServiceController::class)->except('show');
    Route::delete('service/{service}', [ServiceController::class, 'destroy'])->name('service.destroy');
    Route::post('service/datatable', [ServiceController::class, 'datatable'])->name('service.datatable');
    Route::post('/service/{id}/complete', [ServiceController::class, 'complete'])->name('service.complete');

    Route::resource('bike', MotorController::class);
    Route::get('/bike/edit/{id}', [MotorController::class, 'edit'])->name('bike.edit');
    Route::delete('/bike/destroy/{id}', [MotorController::class, 'destroy'])->name('bike.destroy');
    Route::put('/motor/{motor}', [MotorController::class, 'update'])->name('motor.update');
    Route::get('/bike/{id}', [MotorController::class, 'show'])->name('bike.show');
    Route::get('/bike/{id}/export-pdf', [MotorController::class, 'exportPdf'])->name('bike.export-pdf');

    Route::resource('rental', RentalController::class);
    Route::get('rental/create/{motor}', [RentalController::class, 'create'])->name('rental.create');
    Route::get('list-rental', [RentalController::class, 'showListRental'])->name('list.rental');
    Route::post('rental/datatable', [RentalController::class, 'datatable'])->name('rental.datatable');
    Route::post('/rental/confirm-payment', [RentalController::class, 'confirmPayment'])->name('rental.confirm-payment');


    Route::resource('return', ReturnController::class);
    Route::post('return/datatable', [ReturnController::class, 'datatable'])->name('return.datatable');
    Route::get('admin/return/export-pdf', [ReturnController::class, 'exportPdf'])->name('return.export-pdf');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payments/datatable', [PaymentController::class, 'datatable'])->name('payment.datatable');
    Route::post('/payments/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');

    Route::get('/weekly-report', [WeeklyReportController::class, 'weeklyReport'])->name('weekly-report.index');

    Route::get('/weekly-report/transaction-pagination', [WeeklyReportController::class, 'weeklyTransactionPagination'])
        ->name('weekly-report.transaction-pagination');

    Route::get('/weekly-report/service-pagination', [WeeklyReportController::class, 'weeklyServicePagination'])
        ->name('weekly-report.service-pagination');

    Route::get('/weekly-report/export-pdf', [WeeklyReportController::class, 'exportWeeklyPDF'])
        ->name('weekly-report.export-pdf');

    Route::get('/api/weeks', [WeeklyReportController::class, 'getWeeks']);

    Route::get('/report/transactions', [MonthlyReportController::class, 'transactionReport'])->name('monthly-report.index');
    Route::get('/monthly-report/transaction-pagination', [MonthlyReportController::class, 'transactionPagination'])->name('monthly-report.transaction-pagination');
    Route::get('/monthly-report/service-pagination', [MonthlyReportController::class, 'servicePagination'])->name('monthly-report.service-pagination');
    Route::get('/monthly-report/export-pdf', [MonthlyReportController::class, 'exportPDF'])->name('monthly-report.export-pdf');

    Route::get('/bike-report', [BikeReportController::class, 'index'])->name('bike-report');

    Route::get('/yearly-report', [YearlyReportController::class, 'yearlyReport'])->name('yearly-report.index');
    Route::get('/yearly-report/transaction-pagination', [YearlyReportController::class, 'transactionPagination'])->name('yearly-report.transaction-pagination');
    Route::get('/yearly-report/service-pagination', [YearlyReportController::class, 'servicePagination'])->name('yearly-report.service-pagination');
    Route::get('/yearly-report/export-pdf', [YearlyReportController::class, 'exportPDF'])->name('yearly-report.export-pdf');
});
