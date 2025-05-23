<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'total',
        'status',
        'payment_method',
        'payment_details',
        'approval_status',
        'rejection_reason'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'payment_details' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function isPending()
    {
        return $this->approval_status === 'pending';
    }

    public function isApproved()
    {
        return $this->approval_status === 'approved';
    }

    public function isRejected()
    {
        return $this->approval_status === 'rejected';
    }

    public function approve()
    {
        $this->update([
            'approval_status' => 'approved',
            'rejection_reason' => null
        ]);
    }

    public function reject($reason)
    {
        $this->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $reason
        ]);
    }
}
