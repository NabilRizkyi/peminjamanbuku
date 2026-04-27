<?php

namespace App\Services\Borrowing;

interface BorrowingInterface
{
    public function getAllWithRelations();
    public function getByUserId(string $userId);
    public function countByStatus(string $status): int;
    public function findById(string $id);
    public function createBorrowing(string $userId, string $bookId, int $durasi);
    public function approveBorrowing(string $id): array;
    public function cancelBorrowing(string $id): void;
    public function returnBorrowing(string $id): array;
    public function validateToken(string $token): array;
}
