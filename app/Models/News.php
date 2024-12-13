<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    // Specify the table name if it's not plural of the model name
    protected $table = 'news';

    // Define the fillable properties for mass assignment
    protected $fillable = [
        'headline',
        'content',
        'author',
        'date_published',
        'user_id',
    ];

    // Define the relationship between News and User models
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
