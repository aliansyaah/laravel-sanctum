<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FormController;
use App\Http\Controllers\API\ScoreController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Endpoint pada group ini jika diakses harus melewati auth sanctum
// Route::middleware(['auth:sanctum'])->group(function() {      // sama
Route::group(['middleware' => 'auth:sanctum'], function() {     // sama
    // CRUD student
    Route::post('/create', [FormController::class, 'create']);
    Route::get('/edit/{id}', [FormController::class, 'edit']);
    Route::post('/edit/{id}', [FormController::class, 'update']);
    Route::get('/delete/{id}', [FormController::class, 'delete']);

    // CRUD score related to student
    Route::post('create-student-score', [ScoreController::class, 'create']);
    Route::get('data-student/{id}', [ScoreController::class, 'getStudent']);
    Route::post('data-student/{id}', [ScoreController::class, 'update']);

    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('/', function () {
    return view('welcome');
})->name('login');  // sementara bikin route name 'login' utk redirect ketika unauthorized

// Test generate token
Route::get('test-token', function () {
    // Generate token dengan all abilities
    return User::find(1)->createToken('mytoken')->plainTextToken;

    // Generate token dengan ability update
    // return User::find(1)->createToken('mytoken', ['allow:update'])->plainTextToken;
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('access', function () {
        // Cek apakah user yg login memiliki akses untuk update
        if (auth()->user()->tokenCan('allow:update')) {
            return 'Boleh';
        } else {
            return 'Tidak boleh';
        }
    });
});
