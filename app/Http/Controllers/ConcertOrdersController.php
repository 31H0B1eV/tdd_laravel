<?php

namespace App\Http\Controllers;

use App\Concert;
use App\Billing\PaymentGateway;
use Illuminate\Http\Request;

class ConcertOrdersController extends Controller
{
    private $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function store($concertId)
    {
        $concert = Concert::find($concertId);
        $tiketQuantity = request('ticket_quantity');
        $amount = $tiketQuantity * $concert->ticket_price;
        $token = request('payment_token');
        $this->paymentGateway->charge($amount, $token);

        $order = $concert->orders()->create([
            'email' => request('email'),
        ]);

        foreach (range(1, $tiketQuantity) as $i) {
            $order->tickets()->create([]);
        }

        return response()->json([], 201);
    }
}
