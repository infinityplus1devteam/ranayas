<?php

namespace App\Services;

class LogisticService
{
    /**
     * Verify pincode using postalpincode.in API.
     */
    public function verify($pincode)
    {
        try {
            if (empty($pincode) || !preg_match('/^[0-9]{6}$/', $pincode)) {
                return json_encode([
                    'status' => 404,
                    'error' => 'Enter correct pincode'
                ]);
            }

            $client = new \GuzzleHttp\Client([
                'http_errors' => false,
                'timeout' => 10,
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'application/json'
                ]
            ]);
            $response = $client->get('https://api.postalpincode.in/pincode/' . $pincode);
            
            if ($response->getStatusCode() == 200) {
                $content = $response->getBody()->getContents();
                $data = json_decode($content, true);
                
                if (is_array($data) && !empty($data[0]) && isset($data[0]['Status']) && strcasecmp($data[0]['Status'], 'Success') === 0 && !empty($data[0]['PostOffice'])) {
                    return json_encode([
                        'status' => 200,
                        'data' => [
                            'post_offices' => $data[0]['PostOffice'],
                            'available_courier_companies' => [
                                [
                                    'etd' => '3-5 Working Days'
                                ]
                            ]
                        ]
                    ]);
                }
            }
            return json_encode([
                'status' => 404,
                'error' => 'Enter correct pincode'
            ]);
        } catch (\Exception $ex) {
            \Log::error('Pincode verification error: ' . $ex->getMessage());
            return json_encode([
                'status' => 404,
                'error' => 'Enter correct pincode'
            ]);
        }
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
