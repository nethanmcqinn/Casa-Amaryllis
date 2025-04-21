<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
     
        'user_id',
        'product_id',
        'comment',
        'rating',
        'created_at',
        'updated_at'
    ];
    protected $table = 'product_reviews';
    protected $primaryKey = 'id';
}
