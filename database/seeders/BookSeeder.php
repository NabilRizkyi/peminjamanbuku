<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta Toer',
                'deskripsi' => 'Buku pertama dari Tetralogi Buru yang menceritakan kisah percintaan Minke dan Annelies dalam pergulatan sosial-politik masa kolonial Hindia Belanda.',
                'stok' => 10,
                'cover' => null,
            ],
            [
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'deskripsi' => 'Kisah inspiratif tentang perjuangan anak-anak di Belitung dalam mengejar pendidikan di sebuah SD Muhammadiyah yang hampir ditutup.',
                'stok' => 15,
                'cover' => null,
            ],
            [
                'judul' => 'Gadis Kretek',
                'penulis' => 'Ratih Kumala',
                'deskripsi' => 'Sebuah novel sejarah yang menceritakan tentang perburuan saus rahasia kretek dan kisah cinta yang menjalin masa lalu dan masa kini.',
                'stok' => 8,
                'cover' => null,
            ],
            [
                'judul' => 'Filosofi Kopi',
                'penulis' => 'Dee Lestari',
                'deskripsi' => 'Kumpulan cerita dan prosa yang membahas kehidupan melalui filosofi kopi. Fokus pada hubungan Ben dan Jody serta kedai kopi mereka.',
                'stok' => 12,
                'cover' => null,
            ],
            [
                'judul' => 'Hujan',
                'penulis' => 'Tere Liye',
                'deskripsi' => 'Sebuah novel tentang persahabatan, cinta, melupakan, dan perpisahan, berlatar di dunia masa depan pasca bencana alam dahsyat.',
                'stok' => 20,
                'cover' => null,
            ],
            [
                'judul' => 'Laut Bercerita',
                'penulis' => 'Leila S. Chudori',
                'deskripsi' => 'Menyuarakan kisah para aktivis mahasiswa \'98 di Indonesia yang hilang atau dihilangkan karena memperjuangkan suara reformasi.',
                'stok' => 5,
                'cover' => null,
            ]
        ];

        foreach ($books as $bookData) {
            // Karena model Book memakai HasUuids, create otomatis mengisi primary key
            Book::create($bookData);
        }
    }
}
