<?php

namespace App\Services\Book;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookService implements BookInterface
{
    public function getAll()
    {
        return Book::latest()->get();
    }

    public function getRecent(int $limit = 5)
    {
        return Book::latest()->take($limit)->get();
    }

    public function countTotal(): int
    {
        return Book::count();
    }

    public function searchBooks(?string $search)
    {
        return Book::when($search, function ($query, $search) {
            $query->whereLike('judul', $search)
                  ->orWhereLike('penulis', $search);
        })->latest()->get();
    }

    public function findById(string $id)
    {
        return Book::findOrFail($id);
    }

    public function createBook(array $data)
    {
        return Book::create($data);
    }

    public function updateBook(string $id, array $data)
    {
        $book = $this->findById($id);

        if (isset($data['cover']) && $book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->update($data);
        return $book;
    }

    public function deleteBook(string $id): void
    {
        $book = $this->findById($id);
        
        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }
        
        $book->delete();
    }
}
