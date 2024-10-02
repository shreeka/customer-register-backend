<?php

namespace App\Repository;

use App\Model\Customer;
use App\Model\CustomerAddress;

interface CustomerRepositoryInterface
{
    public function insertCustomer(Customer $customer):string;
    public function insertCustomerAddress(CustomerAddress $customerAddress):void;
    public function getAllCustomers(): array|bool;

}