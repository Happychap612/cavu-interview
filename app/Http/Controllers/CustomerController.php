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

    /**
     * Returns booking without the ID
     *
     * @param Request $request
     * @return Customer
     */
    function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:customers,email|max:75',
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
        ]);

        $customer = Customer::create($validated);

        // No need to hide the ID here as this is a new customer
        return $customer;
    }
}
