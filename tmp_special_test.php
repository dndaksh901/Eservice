<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$vendor = App\Models\Vendor::first();
if (! $vendor) {
    echo 'NO_VENDOR';
    exit(1);
}

Illuminate\Support\Facades\Auth::guard('vendor')->login($vendor);
$request = Illuminate\Http\Request::create('/vendor/business-hours', 'POST', [
    'weekly' => [
        0 => [
            'slots' => [
                0 => [
                    'open_time' => '09:00',
                    'close_time' => '17:00',
                    'capacity' => 1,
                ],
            ],
            'is_closed' => 0,
        ],
    ],
    'special' => [
        0 => [
            'specific_date' => '2026-08-10',
            'slots' => [
                0 => [
                    'open_time' => '10:00',
                    'close_time' => '14:00',
                    'capacity' => 2,
                ],
            ],
            'is_closed' => 0,
        ],
    ],
]);
$app->instance('request', $request);
$controller = app()->make(App\Http\Controllers\Vendor\VendorController::class);
$response = app()->call([$controller, 'businessHours'], ['request' => $request]);

if (is_object($response)) {
    echo get_class($response) . "\n";
} else {
    var_export($response);
}

$inserted = App\Models\BusinessHour::where('vendor_id', $vendor->id)->whereNotNull('specific_date')->get();
foreach ($inserted as $hour) {
    echo "SAVED: {$hour->id} {$hour->specific_date} {$hour->open_time} {$hour->close_time} {$hour->slot_capacity} {$hour->is_closed}\n";
}
