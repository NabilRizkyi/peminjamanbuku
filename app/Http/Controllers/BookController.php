<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Book\BookInterface;
use App\Services\Borrowing\BorrowingInterface;
use App\Models\Book;

class BookController extends Controller
{
    private BookInterface $bookService;
    private BorrowingInterface $borrowingService;

    public function __construct(BookInterface $bookService, BorrowingInterface $borrowingService)
    {
        $this->bookService = $bookService;
        $this->borrowingService = $borrowingService;
    }

    public function dashboard(Request $request)
    {
        $search = $request->search;
        $books = Book::when($search, function ($query, $search) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
        })->paginate(10);
        return view('anggota.dashboard', compact('books', 'search'));
    }

    public function index(Request $request)
    {
        $query = Book::query();
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%');
            });
        }
        $books = $query->latest()->paginate(10)->withQueryString();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required',
            'penulis'   => 'required',
            'genre'     => 'required',
            'penerbit'  => 'nullable',
            'deskripsi' => 'nullable',
            'stok'      => 'required|integer',
            'cover'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }
        $this->bookService->createBook($validated);
        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit(string $bookId)
    {
        $book = $this->bookService->findById($bookId);
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, string $bookId)
    {
        $validated = $request->validate([
            'judul'     => 'required',
            'penulis'   => 'required',
            'genre'     => 'required',
            'penerbit'  => 'nullable',
            'deskripsi' => 'nullable',
            'stok'      => 'required|integer',
            'cover'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        $this->bookService->updateBook($bookId, $validated);
        return redirect()->route('books.index')->with('success', 'Buku berhasil diupdate');
    }

    public function destroy(string $bookId)
    {
        $this->bookService->deleteBook($bookId);
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus');
    }

    public function show(string $bookId)
    {
        $book = $this->bookService->findById($bookId);
        if (auth()->user()->role === 'anggota') {
            return view('anggota.detail', compact('book'));
        }
        return view('books.show', compact('book'));
    }

    public function adminDashboard()
    {
        $totalBuku     = $this->bookService->countTotal();
        $totalDipinjam = $this->borrowingService->countByStatus('dipinjam');
        $totalSelesai  = $this->borrowingService->countByStatus('dikembalikan');
        $recentBooks   = $this->bookService->getRecent(5);
        return view('admin.dashboard', compact('totalBuku', 'totalDipinjam', 'totalSelesai', 'recentBooks'));
    }

    public function anggota(Request $request)
    {
        $query = Book::query();
        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%');
        }
        $books = $query->latest()->paginate(10);
        return view('anggota.katalog', compact('books'));
    }
}
