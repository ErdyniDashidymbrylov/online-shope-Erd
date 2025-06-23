<?php

namespace DTO;

use Model\User;

class OrderCreateDTO
{
    public function __construct(private string $name,
                                private string $phone,
                                private string $comment,
                                private string $address, private User $user)
    {


    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getName(): string
    {
        return $this->name;
    }


}