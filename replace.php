<?php
$files = [
    'resources/views/backend/admin/invoices/show.blade.php',
    'resources/views/backend/admin/invoices/download.blade.php',
    'resources/views/backend/admin/invoices/empty.blade.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $c = file_get_contents($file);
        $c = str_replace('{{ $invoice->id }}', '{{ $invoice->order_number }}', $c);
        file_put_contents($file, $c);
    }
}
echo "Done";
