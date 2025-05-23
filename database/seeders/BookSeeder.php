<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        $books = [
            [
                'title' => '1984',
                'summary' => 'A dystopian novel by George Orwell.',
                'price' => 9.99,
                'cover_image' => 'covers/1984.jpg',
                'pdf_file' => 'books/1984.pdf',
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'summary' => 'A novel by Harper Lee.',
                'price' => 12.99,
                'cover_image' => 'covers/mockingbird.jpg',
                'pdf_file' => 'books/mockingbird.pdf',
            ],
            [
                'title' => 'The Great Gatsby',
                'summary' => 'A novel by F. Scott Fitzgerald.',
                'price' => 10.99,
                'cover_image' => 'covers/ksrZHTgtw9vj3iwinNtxeo1VGPmQdyaYxDd7oCNW.jpg',
                'pdf_file' => 'books/great-gatsby.pdf',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
} 