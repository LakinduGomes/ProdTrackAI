<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function getAllCustomers()
    {
        return Customer::all();
    }

    public function getCustomerById($id)
    {
        return Customer::find($id);
    }

    public function createCustomer($data)
    {
        return Customer::create($data);
    }

    public function updateCustomer($id, $data)
    {
        return Customer::where('id', $id)->update($data);
    }

    public function deleteCustomer($id)
    {
        return Customer::destroy($id);
    }
}
