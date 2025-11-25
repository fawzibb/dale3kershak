<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\MealAdminController;
use App\Models\Category;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Setting;
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
    return view('comingsoon');
});

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {

    Route::get('/', fn() => view('admin.dashboard'));

    Route::resource('categories', App\Http\Controllers\Admin\CategoryAdminController::class);
    Route::resource('meals', App\Http\Controllers\Admin\MealAdminController::class);
    Route::resource('orders', App\Http\Controllers\Admin\OrderAdminController::class);
    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

});



Route::get('/menu', function () {
    $categories = Category::with('meals')->get();

    return view('menu', [
        'categories' => $categories
    ]);
});
Route::get('/cart', function () {
    return view('cart', ['cart' => session()->get('cart', [])]);
});

Route::post('/cart/add-ajax', function (Request $request) {
    $meal = Meal::with('category')->find($request->id);

    if (!$meal) {
        return response()->json(['success' => false], 404);
    }

    $cart = session()->get('cart', []);

    if (!isset($cart[$meal->id])) {
        $cart[$meal->id] = [
            'name' => $meal->name,
            'category' => $meal->category->name,
            'price' => $meal->price,
            'quantity' => 1
        ];
    } else {
        $cart[$meal->id]['quantity']++;
    }

    session()->put('cart', $cart);

    return response()->json([
        'success' => true,
        'cart_count' => array_sum(array_column($cart, 'quantity'))
    ]);
});

Route::get('/checkout', fn()=> view('checkout'));


Route::post('/order', function (Request $request) {

    $cart = session()->get('cart', []);

    // 🛑 Check if cart is empty
    if (!$cart || count($cart) == 0) {
        return redirect('/cart')->with('error', 'Please add items to your order before checkout.');
    }

    $message = "📦 Order Details:\n\n";

    foreach ($cart as $item) {
        $message .= "🍽 " . $item['name'] . " (" . $item['category'] . ") x" . $item['quantity'] . "\n";
    }

    $total = array_sum(array_map(fn($i)=>$i['price'] * $i['quantity'], $cart));
    
    // 🛑 Secondary check: quantity zero
    if ($total == 0) {
        return redirect('/cart')->with('error', 'Please add valid items before placing the order.');
    }

    $message .= "\n💵 Total: $" . $total;
    $message .= "\n👤 Name: " . $request->customer_name;
    $message .= "\n📞 Phone: " . $request->phone;
    $message .= "\n📍 Address: " . $request->address;

    $encodedMessage = urlencode($message);

    $phone = config('app.whatsapp_number');

    session()->forget('cart');

    return redirect("https://wa.me/$phone?text=$encodedMessage");
});


Route::post('/cart/update-ajax/{id}', function ($id, Request $request) {

    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        $cart[$id]['quantity'] = max(1, (int)$request->quantity);
        session()->put('cart', $cart);

        // عدّاد السلة
        $cartCount = array_sum(array_column($cart, 'quantity'));

        $rate = \App\Models\Setting::first()->exchange_rate ?? 90000;

        $item_total = $cart[$id]['price'] * $cart[$id]['quantity'];
        $item_total_ll = $item_total * $rate;

        $cart_total = array_sum(array_map(fn($i)=>$i['price'] * $i['quantity'], $cart));
        $cart_total_ll = $cart_total * $rate;

        return response()->json([
            'success' => true,
            'item_total' => $item_total,
            'item_total_ll' => number_format($item_total_ll),
            'cart_total' => $cart_total,
            'cart_total_ll' => number_format($cart_total_ll),
            'cart_count' => $cartCount
        ]);
    }

    return response()->json(['success' => false]);
});


Route::post('/cart/remove/{id}', function ($id) {
    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        unset($cart[$id]);
    }

    session()->put('cart', $cart);

    return back();
});
Route::patch('/meals/{meal}/toggle', [MealAdminController::class, 'toggleAvailability'])->name('meals.toggle');

Route::resource('categories', CategoryAdminController::class);



require __DIR__.'/auth.php';
