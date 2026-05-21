<?php

namespace App\Services;

class LogisticService
{
    /**
     * Dummy method to simulate pincode verification.
     */
    public function verify($pincode)
    {
        // Simulate a valid response from the logistic partner
        return json_encode([
            'status' => 200,
            'data' => [
                'available_courier_companies' => [
                    [
                        'etd' => '3-5 Working Days'
                    ]
                ]
            ]
        ]);
    }

    /**
     * Dummy method to simulate order creation.
     */
    public function OrderCreation($order, $user, $payment_mode)
    {
        return [
            'shipment_id' => 'SHP' . rand(100000, 999999),
            'order_id' => 'ORD' . rand(100000, 999999),
        ];
    }

    /**
     * Dummy method to simulate order tracking.
     */
    public function trackOrder($shipment_id)
    {
        return json_encode([
            'tracking_data' => [
                'error' => 'Tracking not available in dummy mode.'
            ]
        ]);
    }

    /**
     * Dummy method to simulate canceling an order.
     */
    public function cancelOrder($shipment_order_id)
    {
        return json_encode([
            'status_code' => 200
        ]);
    }

    /**
     * Dummy method to simulate label generation.
     */
    public function generateLabel($order)
    {
        return json_encode([
            'status' => 200,
            'label_url' => '#'
        ]);
    }
}
