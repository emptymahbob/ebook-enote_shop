<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\UserBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::latest()->paginate(12);
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'price' => 'required|numeric|min:0',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_file' => 'required|mimes:pdf|max:10240'
        ]);

        $coverPath = $request->file('cover_image')->store('covers', 'public');
        $pdfPath = $request->file('pdf_file')->store('books', 'public');

        Book::create([
            'title' => $validated['title'],
            'summary' => $validated['summary'],
            'price' => $validated['price'],
            'cover_image' => $coverPath,
            'pdf_file' => $pdfPath
        ]);

        return redirect()->route('books.index')->with('success', 'Book added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'price' => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:10240'
        ]);

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($book->cover_image);
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            Storage::disk('public')->delete($book->pdf_file);
            $validated['pdf_file'] = $request->file('pdf_file')->store('books', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        Storage::disk('public')->delete([$book->cover_image, $book->pdf_file]);
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully');
    }

    public function purchase(Request $request, Book $book)
    {
        // Check if user already owns the book
        if (Auth::user()->userBooks()->where('book_id', $book->id)->exists()) {
            return redirect()->route('books.show', $book)
                ->with('error', 'You already own this book.');
        }

        $request->validate([
            'payment_method' => 'required|string',
            'payment_details' => 'required|string'
        ]);

        // Create order with pending status
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $book->price,
            'status' => 'pending',
            'payment_info' => [
                'method' => $request->payment_method,
                'details' => $request->payment_details
            ],
            'approval_status' => 'pending'
        ]);

        // Add book to user's collection (but won't be accessible until approved)
        UserBook::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'order_id' => $order->id,
            'purchased_at' => now(),
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Your purchase request has been submitted and is pending approval.');
    }
}
