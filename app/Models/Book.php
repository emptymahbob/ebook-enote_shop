<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'price',
        'cover_image',
        'pdf_file'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function userBooks()
    {
        return $this->hasMany(UserBook::class);
    }
}
