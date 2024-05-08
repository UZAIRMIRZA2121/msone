<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\Models\Category;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


Route::get('subcategories', function(Request $request) {
    // Fetch subcategories based on the main category ID from the request
    $subcategories = Category::where('main_category_id', $request->query('mainCategoryId'))->get();
    
    return response()->json($subcategories);
})->name('subcategories');

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/category/{category?}', [FrontendController::class, 'category'])->name('category');
Route::get('/product/{product?}', [FrontendController::class, 'product'])->name('product');
Route::get('/nurse/{nurse?}', [FrontendController::class, 'nurse'])->name('nurse');
Route::get('/contactus', [FrontendController::class, 'contactus'])->name('contactus');
// Define route for submitting the contact form
Route::post('/contact/store', [FrontendController::class, 'store'])->name('contact.store');
Route::get('/aboutus', [FrontendController::class, 'aboutus'])->name('aboutus');
Route::get('/returnpolicy', [FrontendController::class, 'returnpolicy'])->name('returnpolicy');
Route::get('/termcondition', [FrontendController::class, 'termcondition'])->name('termcondition');
Route::get('/privacy', [FrontendController::class, 'privacy'])->name('privacy');
Route::post('/product-search', [FrontendController::class, 'productsearch'])->name('productsearch');



Route::get('/verify/{token}', [UserController::class, 'verify'])->name('verification.verify');
Route::post('/register', [UserController::class, 'store'])->name('register.user');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role == 'admin' ) {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role == 'user' ) {
            return redirect()->route('user.dashboard');
        } else {
            return redirect()->route('not.verify');
        }
    })->name('dashboard');

    Route::prefix('admin')->middleware('CheckUserRole:admin')->group(function () {
        Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::delete('/users/{user}',  [AdminController::class, 'userdestroy'])->name('users.destroy');

        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/contactus/show', [AdminController::class, 'contactus'])->name('contactus.show');
        Route::delete('/contacts/{id}', [AdminController::class, 'contactusdestroy'])->name('contacts.destroy');
        // categories Route 
        Route::get('/maincategories', [CategoryController::class, 'maincategories_index'])->name('maincategories.index');
        Route::post('/maincategories/store', [CategoryController::class, 'maincategories_store'])->name('maincategories.store');




        Route::resource('/categories', CategoryController::class);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::delete('/maincategories/{category}', [CategoryController::class, 'maincategorydestroy'])->name('maincategories.destroy');
        Route::PUT('/maincategories/{category}/update', [CategoryController::class, 'maincategoryupdate'])->name('maincategories.update');
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
        // products Route 
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}',)->name('products.destroy');

        Route::get('/categories/getByMainCategory/{mainCategoryId}', [ProductController::class, 'getByMainCategory']);
        // nurse Route
        Route::get('/nurses', [NurseController::class, 'index'])->name('nurses.index');
        Route::get('/nurses/create', [NurseController::class, 'create'])->name('nurses.create');
        Route::post('/nurses', [NurseController::class, 'store'])->name('nurses.store');
        Route::get('/nurses/{id}', [NurseController::class, 'show'])->name('nurses.show');
        Route::get('/nurses/{id}/edit', [NurseController::class, 'edit'])->name('nurses.edit');
        Route::put('/nurses/{id}', [NurseController::class, 'update'])->name('nurses.update');
        Route::delete('/nurses/{id}', [NurseController::class, 'destroy'])->name('nurses.destroy');
        Route::get('/nurses/{id}/toggle-availability', [NurseController::class, 'toggleAvailability'])->name('nurses.toggleAvailability');
        Route::get('/nurse/req', [NurseController::class, 'nursesrequest'])->name('nursesrequest');
        Route::get('/nurses/request/{id}/accept', [NurseController::class, 'acceptRequest'])->name('nurses.request.accept');
        Route::get('/nurses/request/{id}/reject', [NurseController::class, 'rejectRequest'])->name('nurses.request.reject');
        Route::get('/nurses/request/{id}/complete', [NurseController::class, 'completeRequest'])->name('nurses.request.complete');
        // Prescription Route
        Route::get('/prescription', [AdminController::class, 'prescription_request'])->name('pres.index');
        Route::post('/update-prescription-status', [AdminController::class, 'updateStatus'])->name('presc.update');
        // Prescription Route
        Route::get('/all/user', [AdminController::class, 'alluser'])->name('all.user');

        // order request accept
        Route::get('/order/request/{id}/accept', [OrderController::class, 'acceptRequest'])->name('order.request.accept');
        Route::get('/order/request/{id}/reject', [OrderController::class, 'rejectRequest'])->name('order.request.reject');
    });




    // Define the routes with the 'student' prefix and apply the middleware
    Route::prefix('user')->middleware('CheckUserRole:user')->group(function () {
        // Route::get('/index', [UserController::class, 'user_dashboard'])
        //     ->name('user.dashboard');
        Route::get('/home', function () {
            return redirect()->route('home');
        })->name('user.dashboard');
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard.index');
        Route::get('/dashboard/edit', [UserController::class, 'edit'])->name('dashboard.edit');
        Route::post('/dashboard/update', [UserController::class, 'update'])->name('dashboard.update');

        Route::get('/dashboard/order', [UserController::class, 'order_dashboard'])->name('dashboard.order');

        Route::get('/dashboard/nurse', [UserController::class, 'nurse_dashboard'])->name('dashboard.nurse');


        // Add product to cart
        Route::put('/cart/add', [CartController::class, 'addProductToCart'])->name('cart.add');
        // View cart
        Route::get('/cart/show', [CartController::class, 'showCart'])->name('cart.show');
        // Remove product from cart
        Route::delete('/cart/remove', [CartController::class, 'removeProductFromCart'])->name('cart.remove');
        Route::get('/cart/chackout', [CartController::class, 'checkout'])->name('checkout');
        // increase or decrease product from cart
        Route::post('/update-product-quantity', [CartController::class, 'updateProductQuantity'])->name('update.product.quantity');
        Route::post('/prescription/request', [FrontendController::class, 'prescriptionrequest'])->name('prescription.request');
        // Order Route
        Route::post('/order/create', [OrderController::class, 'create'])->name('order.create');
        Route::get('/order/request', [OrderController::class, 'showOrderRequestForm'])->name('showOrderRequestForm');
        Route::post('/order/request', [OrderController::class, 'request'])->name('order.request');
        Route::post('checkout', [OrderController::class, 'afterpayment'])->name('checkout.credit-card');
        // Nurse Hire Route
        Route::get('/nurse/hire/{id}', [NurseController::class, 'hire'])->name('nurse.hire');
        Route::match(['get', 'post'], '/nurses/request/{id}/comment', [NurseController::class, 'commentRequest'])->name('nurses.request.comment');
    });
});
