<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$cart = \Cart::getContent()->first();
if ($cart) {
    echo "Cart Item ID: " . $cart->id . "\n";
    echo "Quantity: " . $cart->quantity . "\n";
} else {
    echo "Cart is empty\n";
}
