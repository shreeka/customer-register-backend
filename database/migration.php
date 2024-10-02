<?php

require 'config.php';

try {
    $pdo = new PDO(DB_DSN,DB_USER,DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    echo "Starting migration.. \n ";

    //Create customers table
    $customersTable = "
    CREATE TABLE IF NOT EXISTS customers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        dob DATE NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin
    ";

    $pdo->exec($customersTable);
    echo "customers table created successfully. \n ";

    //Create customer_addresses table
    $customerAddressTable = "
    CREATE TABLE IF NOT EXISTS customer_addresses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        customer_id INT NOT NULL,
        street_name VARCHAR(255) NOT NULL,
        house_number INT NOT NULL,
        postal_code INT NOT NULL,
        city_name VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY(customer_id) REFERENCES customers(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin
    ";

    $pdo->exec($customerAddressTable);
    echo "customer_addresses table created successfully. \n ";


}catch (PDOException $e) {
    echo "DB migration error: ".$e->getMessage();
}