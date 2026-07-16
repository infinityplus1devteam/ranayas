<?php

namespace App\Model;

use GuzzleHttp\Client;

class Delivery
{
    public static function verify($pincode)
    {
        try {
            if (empty($pincode) || !preg_match('/^[0-9]{6}$/', $pincode)) {
                return json_encode(['status' => 404, 'error' => 'Enter correct pincode']);
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
            $res = $client->get('https://api.postalpincode.in/pincode/' . $pincode);
            if ($res->getStatusCode() == 200) {
                $content = $res->getBody()->getContents();
                $data = json_decode($content, true);
                if (is_array($data) && !empty($data[0]) && isset($data[0]['Status']) && strcasecmp($data[0]['Status'], 'Success') === 0 && !empty($data[0]['PostOffice'])) {
                    return json_encode(['status' => 200, 'data' => $data[0]['PostOffice']]);
                }
            }
            return json_encode(['status' => 404, 'error' => 'Enter correct pincode']);
        } catch (\Exception $ex) {
            \Log::info('Error : ' . $ex->getMessage());
            return json_encode(['status' => 404, 'error' => 'Enter correct pincode']);
        }
    }

    public static function orderTrack($order)
    {
        try {

            $baseUrl = env('LOGISTIC_BASE_URL').'/api/packages/json/?ref_nos=' . $order . '&verbose=1&token=' . env('LOGISTIC_API_TOKEN');

            $client = new \GuzzleHttp\Client([
                'http_errors' => false,
            ]);
            $res  = $client->get($baseUrl);
            $json = $res->getBody()->getContents();
            if ($res->getStatusCode() == 200) {
                return $json;
            }
        } catch (\Exception $ex) {
            \Log::info('Error : ' . $ex->getMessage());
            return;
        }
    }

    public static function orderCreation($order, $user)
    {
        $original_array = array(
            array(
                "city"         => $order->city,
                "name"         => $order->user_name,
                "pin"          => $order->pincode,
                "country"      => "India",
                "phone"        => $user->mobile,
                "add"          => $order->address,
                "payment_mode" => "Prepaid",
                "client"       => env('LOGISTIC_CLIENT_ID'),
                "order"        => $order->id,
            ));

        $pickup = array(
            "city"    => "Thane",
            "name"    => env('LOGISTIC_PICKUP'),
            "pin"     => "421302",
            "country" => "India",
            "phone"   => "9619614785",
            "add"     => "Unit no.112, 1st Floor, Bldg no.A6,Harihar Complex, Dapode,Thane",
        );

        $data = json_encode(array("shipments" => $original_array, "pickup_location" => $pickup));
        // dd('format=json&data=' . $data);

        $curl = curl_init(env('LOGISTIC_BASE_URL').'/api/cmu/create.json');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'format=json&data=' . $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Accept: application/json",
            "Authorization: Token " . env('LOGISTIC_API_TOKEN'),
            "Content-Type: application/json",
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);

        if ($err) {
            \Log::info('Error : ' . $err);
            return;
        } else {
            \Log::info($response);
            return;
        }
    }

    public static function codOrderCreation($order, $user)
    {
        $original_array = array(
            array(
                "city"                 => $order->city,
                "name"                 => $order->user_name,
                "pin"                  => $order->pincode,
                "country"              => "India",
                "phone"                => $user->mobile,
                "add"                  => $order->address,
                "payment_mode"         => "COD",
                "client"               => env('LOGISTIC_CLIENT_ID'),
                "order"                => $order->id,
                'consignee_gst_amount' => $order->tax,
                'cod_amount'           => $order->total,
                'total_amount'         => $order->total,
            ));

        $pickup = array(
            "city"    => "Thane",
            "name"    => env('LOGISTIC_PICKUP'),
            "pin"     => "421302",
            "country" => "India",
            "phone"   => "9619614785",
            "add"     => "Unit no.112, 1st Floor, Bldg no.A6,Harihar Complex, Dapode,Thane",
        );

        $data = json_encode(array("shipments" => $original_array, "pickup_location" => $pickup));
        // dd('format=json&data=' . $data);

        $curl = curl_init(env('LOGISTIC_BASE_URL').'/api/cmu/create.json');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'format=json&data=' . $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Accept: application/json",
            "Authorization: Token " . env('LOGISTIC_API_TOKEN'),
            "Content-Type: application/json",
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);

        if ($err) {
            \Log::info('Error : ' . $err);
            return;
        } else {
            \Log::info($response);
            return;
        }
    }

    public static function cancelOrder($order_id)
    {
        try {

            $details = array(
                'cancellation' => 'true',
                'waybill'      => trim($order_id),
            );

            $data = json_encode($details);

            $curl = curl_init(env('LOGISTIC_BASE_URL').'/api/p/edit');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_ENCODING, '');
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Accept: application/json",
                "Authorization: Token " . env('LOGISTIC_API_TOKEN'),
                "Content-Type: application/json",
            ));

            $response = curl_exec($curl);
            $err      = curl_error($curl);

            curl_close($curl);

            if ($err) {
                \Log::info('Error : ' . $err);
                return;
            } else {
                \Log::info($response);
                return $response;
            }

        } catch (\Exception $ex) {
            \Log::info('Cancel Order Error : ' . $ex->getMessage());
            return;
        }

    }
}
