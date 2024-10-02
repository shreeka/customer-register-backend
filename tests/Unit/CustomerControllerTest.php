<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Controller\CustomerController;
use App\Repository\CustomerRepositoryInterface;

final class CustomerControllerTest extends TestCase
{
    private CustomerRepositoryInterface $customerRepositoryMock;
    private CustomerController $controller;

    protected function setUp(): void
    {
        $this->customerRepositoryMock = $this->createMock(CustomerRepositoryInterface::class);
        $this->controller = new CustomerController($this->customerRepositoryMock);
    }

    public function testRegisterCustomer(): void
    {
        // Arrange: Simulate POST data
        $_POST['first_name'] = 'John';
        $_POST['last_name'] = 'Doe';
        $_POST['dob'] = '1990-01-01';
        $_POST['email'] = 'john.doe@example.com';
        $_POST['street_name'] = 'Main St';
        $_POST['house_number'] = '123';
        $_POST['postal_code'] = '12345';
        $_POST['city_name'] = 'Test City';

        // Set up the expected behavior of the mock repository
        $this->customerRepositoryMock
            ->expects($this->once())
            ->method('insertCustomer')
            ->willReturn('1');  // Simulate returning a customer ID of 1

        $this->customerRepositoryMock
            ->expects($this->once())
            ->method('insertCustomerAddress');

        $this->controller->registerCustomer();
    }

    public function testDownloadCustomersJSON(): void
    {
        // Arrange: Simulate some customer data
        $customers = [
            [
                'id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'dob' => '1990-01-01',
                'email' => 'john.doe@example.com',
                'street_name' => 'Main St',
                'house_number' => '123',
                'postal_code' => '12345',
                'city_name' => 'Test City'
            ]
        ];

        // Mock the repository call to return the customers
        $this->customerRepositoryMock
            ->expects($this->once())
            ->method('getAllCustomers')
            ->willReturn($customers);

        $this->expectOutputString(json_encode($customers));
        $this->controller->downloadCustomersJSON();
    }
}
