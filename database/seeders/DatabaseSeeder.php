<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            BookSeeder::class,
        ]);

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create regular user
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Create sample books
        $books = [
            [
                'title' => 'The Great Gatsby',
                'summary' => 'A story of the fabulously wealthy Jay Gatsby and his love for the beautiful Daisy Buchanan.',
                'price' => 9.99,
                'cover_image' => 'covers/great-gatsby.jpg',
                'pdf_file' => 'books/great-gatsby.pdf',
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'summary' => 'The story of racial injustice and the loss of innocence in the American South.',
                'price' => 12.99,
                'cover_image' => 'covers/mockingbird.jpg',
                'pdf_file' => 'books/mockingbird.pdf',
            ],
            [
                'title' => '1984',
                'summary' => 'A dystopian social science fiction novel and cautionary tale.',
                'price' => 10.99,
                'cover_image' => 'covers/1984.jpg',
                'pdf_file' => 'books/1984.pdf',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
