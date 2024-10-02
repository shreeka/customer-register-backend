<?php

namespace App\Model;

final class CustomerAddress
{
    private string $id;
    private string $customerId;
    private string $streetName;
    private string $houseNumber;
    private string $postalCode;
    private string $cityName;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function getStreetName(): string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): void
    {
        $this->streetName = $streetName;
    }

    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    public function setHouseNumber(string $houseNumber): void
    {
        $this->houseNumber = $houseNumber;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getCityName(): string
    {
        return $this->cityName;
    }

    public function setCityName(string $cityName): void
    {
        $this->cityName = $cityName;
    }
    public function fromArray(array $data): CustomerAddress
    {
        $id = $data['id'] ?? '';
        $customerId = $data['customer_id'] ?? '';
        $streetName = $data['street_name'] ?? '';
        $houseNumber = $data['house_number'] ?? '';
        $postalCode = $data['postal_code'] ?? '';
        $cityName = $data['city_name'] ?? '';

        $this->setId($id);
        $this->setCustomerId($customerId);
        $this->setStreetName($streetName);
        $this->setHouseNumber($houseNumber);
        $this->setPostalCode($postalCode);
        $this->setCityName($cityName);

        return $this;
    }


}