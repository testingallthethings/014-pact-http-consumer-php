<?php
declare(strict_types=1);

namespace Braddle;

class Person
{
    private $firstName;
    private $lastName;
    private $alias;

    public function __construct(
        string $firstName,
        string $lastName,
        string $alias
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->alias = $alias;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }
}