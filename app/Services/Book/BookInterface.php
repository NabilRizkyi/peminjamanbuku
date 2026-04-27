<?php

namespace App\Services\Book;

interface BookInterface
{
    public function getAll();
    public function getRecent(int $limit = 5);
    public function countTotal(): int;
    public function findById(string $id);
    public function createBook(array $data);
    public function updateBook(string $id, array $data);
    public function deleteBook(string $id): void;
    public function searchBooks(?string $query);
}
