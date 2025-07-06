<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circular extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'post_date' => 'date',
        'last_date_of_submission' => 'date',
    ];

    /**
     * A circular has many job posts.
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * The admin who created the circular.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
