@extends('layouts.app')

@section('title', 'Manage Orders')

@section('content')
<div class="container">
    <h1 class="mb-4">Manage Orders</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Book</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->book ? $order->book->title : 'Book not found' }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>
                            @if($order->isPending())
                                <span class="badge bg-warning">Pending</span>
                            @elseif($order->isApproved())
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            @if($order->isPending())
                                <form action="{{ route('admin.orders.approve', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                                
                                <button type="button" class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#rejectModal{{ $order->id }}">
                                    <i class="fas fa-times"></i> Reject
                                </button>

                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal{{ $order->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.orders.reject', $order) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Reject Order #{{ $order->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                                                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" 
                                                                  rows="3" required></textarea>
                                                        @error('rejection_reason')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Reject Order</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @elseif($order->isRejected())
                                <small class="text-danger">{{ $order->rejection_reason }}</small>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links('pagination::simple-default') }}
    </div>
</div>

<style>
/* Pagination styling */
.pagination {
    margin-bottom: 0;
}

.pagination .page-link {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.pagination .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.pagination .page-link:hover {
    background-color: #e9ecef;
}

/* Table styling */
.table th {
    background-color: #f8f9fa;
}

.table td {
    vertical-align: middle;
}

/* Button styling */
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

/* Modal styling */
.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.modal-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
}
</style>
@endsection 