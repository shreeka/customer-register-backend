<?php

namespace App\Repository;

use App\Helper\JsonResponse;
use App\Model\Customer;
use App\Model\CustomerAddress;
use PDO;
use PDOException;

final class CustomerRepository implements CustomerRepositoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function insertCustomer(Customer $customer): string
    {
        $query = "INSERT INTO customers (first_name, last_name, dob, email) VALUES (?,?,?,?)";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$customer->getFirstName(), $customer->getLastName(), $customer->getDob(), $customer->getEmail()]);

            //return last inserted id for customer address insertion
            return $this->pdo->lastInsertId();
        } catch (PDOException $exception) {
            JsonResponse::send(['status' => 'error', 'message' => 'Failure inserting into customers table: ' . $exception->getMessage()], 500);
            return false;
        }

    }

    public function insertCustomerAddress(CustomerAddress $customerAddress): void
    {
        $query = "INSERT INTO customer_addresses (customer_id, street_name, house_number, postal_code, city_name) VALUES (?,?,?,?,?)";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$customerAddress->getCustomerId(), $customerAddress->getStreetName(), $customerAddress->getHouseNumber(), $customerAddress->getPostalCode(), $customerAddress->getCityName()]);

            // Success message after customer and customer addresses entered successfully
            JsonResponse::send(['status' => 'success', 'message' => 'Customer registered successfully']);
        } catch (PDOException $exception) {
            JsonResponse::send(['status' => 'error', 'message' => 'Failure inserting into customer_addresses table: ' . $exception->getMessage()], 500);
        }

    }

    public function getAllCustomers(): array|bool
    {
        $query = "SELECT c.id, c.first_name, c.last_name, c.dob, c.email, 
                    a.street_name, a.house_number, a.postal_code, a.city_name 
                    from customers c LEFT JOIN customer_addresses a 
                    on c.id = a.customer_id";
        try {
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            JsonResponse::send(['status' => 'error', 'message' => 'Failure fetching customers: ' . $exception->getMessage()], 500);
            return false;
        }
    }


}