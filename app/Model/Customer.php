<?php

namespace App\Model;
final class Customer
{
    private string $id;
    private string $firstName;
    private string $lastName;
    private string $dob;
    private string $email;


    public function getFirstName():string
    {
        return $this->firstName;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName():string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }


    public function getDob():string
    {
        return $this->dob;
    }


    public function setDob(string $dob): void
    {
        $this->dob = $dob;
    }


    public function getEmail():string
    {
        return $this->email;
    }


    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function fromArray(array $data): Customer
    {
        $id = $data['id'] ?? '';
        $firstName = $data['first_name'] ?? '';
        $lastName = $data['last_name'] ?? '';
        $dob = $data['dob'] ?? '';
        $email = $data['email'] ?? '';

        $this->setId($id);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setDob($dob);
        $this->setEmail($email);

        return $this;
    }



}