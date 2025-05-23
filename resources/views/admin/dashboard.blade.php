@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Books</h5>
                    <h2 class="card-text">{{ $stats['total_books'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <h2 class="card-text">{{ $stats['total_orders'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Pending Orders</h5>
                    <h2 class="card-text">{{ $stats['pending_orders'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('books.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Book
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-success">
                            <i class="fas fa-shopping-cart"></i> Manage Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Recent Orders</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User</th>
                            <th>Book</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->book ? $order->book->title : 'Book not found' }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
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
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No recent orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
/* Card styling */
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    margin-bottom: 1rem;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
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