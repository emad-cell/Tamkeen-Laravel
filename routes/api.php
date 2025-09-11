<?php

use App\Http\Controllers\Api\AssociationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\RegesterRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use function Ramsey\Uuid\v1;






Route::get('/settings', [SettingController::class,'index']);
Route::post('/user/{id}/active', [RegesterRequestController::class, 'active']);
Route::get('/allusers', [RegesterRequestController::class, 'getUsers']);
Route::get('/allPendusers', [RegesterRequestController::class, 'gePendtUsers']);
Route::get('/stats', [RegesterRequestController::class, 'stats']);


// Services
Route::resource('service', ServiceController::class);
// Associations
Route::resource('associations', AssociationController::class);

// Orders
Route::controller(AuthController::class)->group(function (){
Route::resource('orders', OrderController::class);
// Route::get('order/{id}', [OrderController::class, 'update']);
});
// Auth
Route::controller(AuthController::class)->group(function () {
    Route::post('/associationRegister', 'associationRegister');
    Route::post('/clientRegister', 'clientRegister');
    Route::post('/login', 'login');
});




















##---------------------Auth Module
// Route::controller(AuthCotroller::class)->group(function(){
//     Route::post('associationRegister', 'associationRegister');
//     Route::post('clientRegister', 'clientRegister');
//     Route::post('login', 'login');
// });
// Route::middleware(['auth:sanctum'])->group(function () {

//     Route::get('/admin/profile', function (Request $request) {
//         if (! $request->user()->tokenCan('access:admin')) {
//             return response()->json(['message' => 'غير مصرح لك'], 403);
//         }
//         return response()->json(['message' => 'مرحباً أيها المدير']);
//     });

//     Route::get('/client/home', function (Request $request) {
//         if (! $request->user()->tokenCan('access:client')) {
//             return response()->json(['message' => 'غير مصرح لك'], 403);
//         }
//         return response()->json(['message' => 'أهلاً بك أيها العميل']);
//     });

//     Route::get('/dashboard', function (Request $request) {
//         if (! $request->user()->tokenCan('access:association')) {
//             return response()->json(['message' => 'غير مصرح لك'], 403);
//         }
//         return response()->json(['message' => 'لوحة الجمعية']);
//     });
// });
##---------------------Setting module
// Route::get('/setting',SettingController::class);


// ##---------------------Service Module
// Route::controller(ServiceController::class)->group(function () {
//     Route::resource('service', ServiceController::class);
// });

// ##================
// Route::get('/orders', [OrderController::class, 'index']);
// Route::post('/orders', [OrderController::class, 'store']);
// Route::get('/orders/{id}', [OrderController::class, 'show']);
// // require __DIR__ . '/settings.php';
// require __DIR__ . '/auth.php';
