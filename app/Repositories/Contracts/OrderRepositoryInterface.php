<?php

namespace App\Repositories\Contracts;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function createWithItems(array $orderData, array $items);

    public function findByCode(string $code): ?object;

    public function getByCustomer(int $customerId, int $perPage = 10);

    public function updateStatus(int $orderId, string $status): bool;
}
