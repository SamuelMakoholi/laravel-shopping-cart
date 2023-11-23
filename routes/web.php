<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\DataTables\UsersDataTable;
use App\Helpers\ImageFilter;
use App\Http\Controllers\CartController;

use Intervention\Image\ImageManagerStatic;

use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('image', function(){
   $img= ImageManagerStatic::make('car.jpg');

   $img->filter( new ImageFilter(30));

//    $img->save('car1.jpg', 5);
    return $img->response();
});

Route::get('/edit/{id}', function($id){
    return $id;
})->name('edit.user');

Route::get('/dashboard', function (UsersDataTable $dataTable) {
    return $dataTable->render('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('/shop', [CartController::class, 'shop'])->name('shop');


Route::get('/cart', [CartController::class, 'cart'])->name('cart');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});








require __DIR__.'/auth.php';
