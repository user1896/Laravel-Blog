<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory; // Enable mass assignment for the Post model
    
    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];
}
