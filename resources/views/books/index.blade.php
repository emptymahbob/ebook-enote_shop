@extends('layouts.app')

@section('title', 'Books')

@section('content')
<div class="container">
    @if(auth()->check() && auth()->user()->isAdmin())
        <div class="mb-4">
            <a href="{{ route('books.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Book
            </a>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($books as $book)
            <div class="col">
                <div class="card h-100">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" 
                             class="card-img-top" alt="{{ $book->title }}"
                             style="height: 300px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                             style="height: 300px;">
                            <i class="fas fa-book fa-3x text-muted"></i>
                        </div>
                    @endif
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text text-muted">${{ number_format($book->price, 2) }}</p>
                        <p class="card-text">{{ Str::limit($book->summary, 100) }}</p>
                    </div>
                    
                    <div class="card-footer bg-transparent">
                        <div class="d-grid">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-primary">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No books available at the moment.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $books->links() }}
    </div>
</div>
@endsection 