<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\JourneyController;
use App\Http\Controllers\Api\MarqueeItemController;
use App\Http\Controllers\Api\AboutSectionController;
use App\Http\Controllers\Api\HeroSectionController;

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

// TEMPORARY ADMIN PASSWORD RESET — REMOVE AFTER SUCCESSFUL USE.
Route::post('/admin-reset-once', function (Request $request) {
    $secret = (string) config('app.admin_reset_secret');
    $provided = (string) $request->header('X-Admin-Reset-Secret');

    if ($secret === '' || !hash_equals($secret, $provided)) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized.',
        ], 401);
    }

    $data = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string', 'min:12'],
    ]);

    $user = User::updateOrCreate(
        ['email' => $data['email']],
        [
            'name' => 'Vijay Admin',
            'password' => Hash::make($data['password']),
        ]
    );

    return response()->json([
        'success' => true,
        'message' => 'Admin credentials updated.',
        'email' => $user->email,
    ]);
})->middleware('throttle:3,1');

// Login: limit repeated login attempts.
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1');

// Public portfolio data.
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/skills', [SkillController::class, 'index']);
Route::get('/journeys', [JourneyController::class, 'index']);
Route::get('/marquee-items', [MarqueeItemController::class, 'index']);
Route::get('/about', [AboutSectionController::class, 'index']);
Route::get('/hero', [HeroSectionController::class, 'index']);

// Public contact form submission.
Route::post('/contact', [ContactMessageController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Protected API Routes
|--------------------------------------------------------------------------
| Every route inside this group requires a valid Sanctum token.
*/

Route::middleware('auth:sanctum')->group(function () {

    // Authentication
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Projects CRUD
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::patch('/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

    // Contact Messages
    Route::get(
        '/contact-messages',
        [ContactMessageController::class, 'index']
    );

    Route::patch(
        '/contact-messages/{id}/read-status',
        [ContactMessageController::class, 'updateReadStatus']
    );

    Route::delete(
        '/contact-messages/{id}',
        [ContactMessageController::class, 'destroy']
    );

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Journeys
    Route::apiResource('/journeys', JourneyController::class)
        ->except(['index']);

    // Marquee
    Route::get(
        '/marquee-items-admin',
        [MarqueeItemController::class, 'adminIndex']
    );

    Route::apiResource('/marquee-items', MarqueeItemController::class)
        ->except(['index']);

    // About
    Route::get(
        '/about-admin',
        [AboutSectionController::class, 'adminIndex']
    );

    Route::apiResource('/about-sections', AboutSectionController::class);

    // Hero
    Route::get(
        '/hero-admin',
        [HeroSectionController::class, 'adminIndex']
    );

    Route::apiResource('/hero-sections', HeroSectionController::class);

    // Skills CRUD
    Route::apiResource('/skills', SkillController::class)
        ->except(['index']);
});
