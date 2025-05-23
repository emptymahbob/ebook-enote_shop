@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" 
                     class="img-fluid rounded" alt="{{ $book->title }}">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                     style="height: 400px;">
                    <i class="fas fa-book fa-4x text-muted"></i>
                </div>
            @endif
        </div>
        
        <div class="col-md-8">
            <h1>{{ $book->title }}</h1>
            <p class="lead">${{ number_format($book->price, 2) }}</p>
            
            <div class="mb-4">
                <h5>Summary</h5>
                <p>{{ $book->summary }}</p>
            </div>

            @auth
                @if(auth()->user()->userBooks()->where('book_id', $book->id)->exists())
                    <div class="alert alert-success">
                        You own this book!
                        <a href="{{ asset('storage/' . $book->pdf_file) }}" class="btn btn-primary ms-3" target="_blank">
                            <i class="fas fa-book"></i> Read Now
                        </a>
                    </div>
                @else
                    <div class="card">
                        <div class="card-header">
                            Purchase Book
                        </div>
                        <div class="card-body">
                            <form action="{{ route('books.purchase', $book) }}" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method</label>
                                    <select class="form-select" id="payment_method" name="payment_method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="paypal">PayPal</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="payment_details" class="form-label">Payment Details</label>
                                    <textarea class="form-control" id="payment_details" name="payment_details" 
                                              rows="3" required 
                                              placeholder="Enter your payment details (e.g., card number, PayPal email, or bank account)"></textarea>
                                </div>

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    Your purchase will be reviewed by an administrator before you can access the book.
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-shopping-cart"></i> Purchase for ${{ number_format($book->price, 2) }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                @if(auth()->user()->isAdmin())
                    <hr>
                    <div class="mt-4">
                        <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Book
                        </a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">
                                <i class="fas fa-trash"></i> Delete Book
                            </button>
                        </form>
                    </div>
                @endif
            @else
                <div class="alert alert-info">
                    Please <a href="{{ route('login') }}">login</a> to purchase this book.
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection 