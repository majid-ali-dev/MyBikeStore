<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController
{
    public function index()
    {
        return view('customer.dashboard');
    }
}
