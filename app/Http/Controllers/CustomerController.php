<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function topSpender()
    {
        $topSpender = Customer::with(['orders.orderDetails'])
        ->get()
        ->map(function ($customer) {
            // Calculate total spending for each customer
            $customer->total_spent = $customer->orders->reduce(function ($carry, $order) {
                // For each order, add the total amount spent on that order
                $orderTotal = $order->orderDetails->reduce(function ($orderCarry, $detail) {
                    return $orderCarry + ($detail->priceEach * $detail->quantityOrdered);
                }, 0);
                return $carry + $orderTotal;
            }, 0);

            return $customer;
        })
        ->sortByDesc('total_spent')
        ->first();
    
            return "The customer who spent the most is: " . $topSpender->customerName . " with a total spending of $" . number_format($topSpender->total_spent, 2) . ".";
    }

    public function topOrderer()
    {
        $topOrderer = Customer::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->first();

        return "The customer with the highest number of orders is: " . $topOrderer->customerName . " with " . $topOrderer->orders_count . " orders.";
    }
}
