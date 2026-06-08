<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$s = App\Model\MapColorSize::where('stock', '>', 5)->first();
if ($s) {
    $p = App\Model\TxnProduct::find($s->product_id);
    echo "USE THIS PRODUCT: " . $p->title . " (Stock: " . $s->stock . ")\n";
} else {
    echo "No product found with stock > 5\n";
}
