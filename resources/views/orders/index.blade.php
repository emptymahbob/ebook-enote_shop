@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container">
    <h1 class="mb-4">My Orders</h1>

    @forelse($orders as $order)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Order #{{ $order->id }}</span>
                <span class="text-muted">{{ $order->created_at->format('F j, Y') }}</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $order->book ? $order->book->title : 'Book not found' }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>
                                    @if($order->isPending())
                                        <span class="badge bg-warning">Pending Approval</span>
                                    @elseif($order->isApproved())
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                        @if($order->rejection_reason)
                                            <br>
                                            <small class="text-danger">{{ $order->rejection_reason }}</small>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end"><strong>Total:</strong></td>
                                <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            You haven't placed any orders yet.
            <a href="{{ route('books.index') }}" class="alert-link">Browse our collection</a>
        </div>
    @endforelse

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection 