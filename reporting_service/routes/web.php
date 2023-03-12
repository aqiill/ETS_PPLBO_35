<?php


/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Cache;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/products', function () use ($router) {
    $url = 'http://localhost:8000/api/v1/products/';
    $response = json_decode(file_get_contents($url), true);
    return $response;
});

$router->get('/orders', function () use ($router) {
    $url = 'http://localhost:8001/api/v1/orders/';
    $response = json_decode(file_get_contents($url), true);
    return $response;
});

$router->get('/payment', function () use ($router) {
    $url = 'http://localhost:8002/api/v1/payment/';
    $response = json_decode(file_get_contents($url), true);
    return $response;
});

$router->get('/sales-report', function () use ($router) {


    $paymentsUrl = 'http://localhost:8002/api/v1/payment/';
    $payments = Cache::remember('payments', 3600, function () use ($paymentsUrl) {
        return json_decode(file_get_contents($paymentsUrl), true);
    });

    $data = [];
    $total = 0;

    foreach ($payments['data'] as $payment) {
        $data[] = [
            'payment_id' => $payment['id'],
            'payment_number' => $payment['payment_number'],
            'total' => $payment['total'],
        ];
        $total += $payment['total'];
    }

    return [
        'data' => $data,
        'total' => $total
    ];
});


$router->get('/sales-report/{id_payment}', function ($id_payment) use ($router) {

    $productsUrl = 'http://localhost:8000/api/v1/products/';
    $ordersUrl = 'http://localhost:8001/api/v1/orders/';
    $paymentsUrl = 'http://localhost:8002/api/v1/payment/';

    // $products = json_decode(file_get_contents($productsUrl), true);
    // $orders = json_decode(file_get_contents($ordersUrl), true);
    // $payments = json_decode(file_get_contents($paymentsUrl), true);
    try {
        $products = Cache::remember('products', 3600, function () use ($productsUrl) {
            return json_decode(file_get_contents($productsUrl), true);
        });

        $orders = Cache::remember('orders', 3600, function () use ($ordersUrl) {
            return json_decode(file_get_contents($ordersUrl), true);
        });

        $payments = Cache::remember('payments', 3600, function () use ($paymentsUrl) {
            return json_decode(file_get_contents($paymentsUrl), true);
        });
    } catch (\Exception $e) {
        // Jika salah satu service mati, tampilkan pesan error
        return ['error' => 'Error accessing one or more services.'];
    }
    $data = [];
    $total = 0;

    foreach ($orders['data'] as $order) {

        if ($order['id_payment'] == $id_payment) {
            $product = collect($products['data'])->firstWhere('id', $order['id_product']);

            if ($product) {
                $data[] = [
                    'order_id' => $order['id'],
                    'payment_id' => $order['id_payment'],
                    'product_id' => $product['id'],
                    'product_name' => $product['name_product'],
                    'product_price' => $product['price'],
                    'quantity' => $order['qty']
                ];
            }
        }
    }

    $payment = collect($payments['data'])->firstWhere('id', $id_payment);
    if ($payment) {
        $total += $payment['total'];
    }
    return [
        'data' => $data,
        'total' => $total
    ];
});
