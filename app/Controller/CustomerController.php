<?php

namespace App\Controller;

use App\Model\Customer;
use App\Model\CustomerAddress;
use App\Repository\CustomerRepositoryInterface;

final class CustomerController
{
    public function __construct(private CustomerRepositoryInterface $customerRepository)
    {
    }

    public function registerCustomer(): void
    {
        // Get data from the POST request
        $customerData = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'dob' => $_POST['dob'],
            'email' => $_POST['email'],
        ];

        $customer = new Customer();
        $customer = $customer->fromArray($customerData);

        //Insert new customer
        $customerId = $this->customerRepository->insertCustomer($customer);

        $addressData = [
            'customer_id' => $customerId,
            'street_name' => $_POST['street_name'],
            'house_number' => $_POST['house_number'],
            'postal_code' => $_POST['postal_code'],
            'city_name' => $_POST['city_name'],
        ];

        $customerAddress = new CustomerAddress();
        $customerAddress = $customerAddress->fromArray($addressData);

        //Insert customer address
        $this->customerRepository->insertCustomerAddress($customerAddress);
    }

    public function downloadCustomersJSON(): void
    {
        $customers = $this->customerRepository->getAllCustomers();

        // Return JSON response
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="customers.json"');
        echo json_encode($customers);

    }
}