<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Returns booking without the ID
     *
     * @param Customer $customer
     * @return Customer
     */
    function show(Customer $customer)
    {
        return $customer->load('bookings')->makeHidden('id');
    }
}
