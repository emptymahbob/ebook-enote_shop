@extends('layouts.app')

@section('title', 'My Books')

@section('content')
<div class="container">
    <h1 class="mb-4">My Books</h1>

    <div class="row">
        @forelse($books as $userBook)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($userBook->book->cover_image)
                        <img src="{{ asset('storage/' . $userBook->book->cover_image) }}" 
                             class="card-img-top" alt="{{ $userBook->book->title }}"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center"
                             style="height: 200px;">
                            <i class="fas fa-book fa-4x text-muted"></i>
                        </div>
                    @endif
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $userBook->book->title }}</h5>
                        <p class="card-text">{{ Str::limit($userBook->book->summary, 100) }}</p>
                        
                        @if($userBook->order->isPending())
                            <div class="alert alert-warning">
                                <i class="fas fa-clock"></i> Pending Approval
                            </div>
                        @elseif($userBook->order->isRejected())
                            <div class="alert alert-danger">
                                <i class="fas fa-times-circle"></i> Rejected
                                @if($userBook->order->rejection_reason)
                                    <p class="mb-0 mt-2"><small>{{ $userBook->order->rejection_reason }}</small></p>
                                @endif
                            </div>
                        @else
                            <a href="{{ asset('storage/' . $userBook->book->pdf_file) }}" 
                               class="btn btn-primary" target="_blank">
                                <i class="fas fa-book"></i> Read Now
                            </a>
                        @endif
                    </div>
                    <div class="card-footer text-muted">
                        Purchased on {{ $userBook->purchased_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    You haven't purchased any books yet.
                    <a href="{{ route('books.index') }}" class="alert-link">Browse our collection</a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $books->links() }}
    </div>
</div>
@endsection 