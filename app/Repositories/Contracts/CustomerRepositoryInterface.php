<?php

namespace App\Repositories\Contracts;

interface CustomerRepositoryInterface extends RepositoryInterface
{
    public function findByEmail(string $email): ?object;
}
