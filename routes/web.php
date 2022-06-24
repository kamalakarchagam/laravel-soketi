<?php

use App\Models\Group;
use App\Events\FeatureAdded;
use App\Events\JoinedGroup;
use Illuminate\Http\Request;
use App\Events\OrderDispatched;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/color', function () {
    return view('color-picker');
});
Route::post('/fireEvent', function () {
    FeatureAdded::dispatch(request()->color);
})->name('fire.public.event');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get(
        '/private/fireEvent',
        function () {
            // faking file upload
            sleep(3);
            OrderDispatched::dispatch('Your cv has been uploaded');
        }
    )->name('fire.private.event');


    Route::get(
        '/dashboard',
        function () {
            $group = Group::where('id', auth()->user()->group_id)->first();
            return view('dashboard', compact('group'));
        }
    )->name('dashboard');

    Route::get(
        '/dashboard/{group}',
        function (Request $request, Group $group) {

            abort_unless($request->user()->canJoinGroup($group->id), 401);
            return view('group', compact('group'));
        }
    )->name('group');

    Route::get('/presence/fireEvent/{message}', fn () => JoinedGroup::dispatch())->name('fire.presence.event');
});

require __DIR__.'/auth.php';
