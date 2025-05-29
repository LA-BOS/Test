<?php
namespace App\Controllers;
use App\Models\Customer;

class CustumerController{
    public function index(){
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }
}