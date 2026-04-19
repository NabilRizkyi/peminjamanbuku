<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // ==========================
    // 📚 DASHBOARD SISWA + SEARCH
    // ==========================
    public function dashboard(Request $request)
    {
        $search = $request->search;

        $books = Book::when($search, function ($query, $search) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
        })->latest()->get();

        return view('siswa.dashboard', compact('books', 'search'));
    }


    // ==========================
    // 📚 ADMIN CRUD
    // ==========================
    public function index()
    {
        $books = Book::latest()->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }


    // ==========================
    // ✅ STORE + UPLOAD COVER
    // ==========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'deskripsi' => 'nullable',
            'stok' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }


    // ==========================
    // ✏️ EDIT
    // ==========================
    public function edit(Book $book) // ✅ pakai binding
    {
        return view('books.edit', compact('book'));
    }


    // ==========================
    // ✅ UPDATE + GANTI COVER
    // ==========================
    public function update(Request $request, Book $book) // ✅ binding
    {
        $validated = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'deskripsi' => 'nullable',
            'stok' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('cover')) {

            // hapus lama
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }

            // simpan baru
            $validated['cover'] = $request->file('cover')->store('covers', 'public');

        } else {
            unset($validated['cover']);
        }

        $book->update($validated);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil diupdate');
    }


    // ==========================
    // ❌ DELETE + HAPUS COVER
    // ==========================
    public function destroy(Book $book) // ✅ binding
    {
        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus');
    }


    // ==========================
    // 📖 DETAIL BUKU (SISWA)
    // ==========================
   public function show(Book $book)
{
    if (auth()->user()->role === 'siswa') {
        return view('siswa.detail', compact('book'));
    }

    return view('books.show', compact('book'));
}

public function adminDashboard()
{
    $totalBuku = Book::count();

    $totalDipinjam = Borrowing::where('status', 'dipinjam')->count();

    $totalSelesai = Borrowing::where('status', 'dikembalikan')->count();

    $recentBooks = Book::latest()->take(5)->get();

    return view('admin.dashboard', compact(
        'totalBuku',
        'totalDipinjam',
        'totalSelesai',
        'recentBooks'
    ));
}

}