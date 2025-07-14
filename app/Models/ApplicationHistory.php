<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'applications_history';

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'due_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'payment_data' => 'json', // Automatically handles JSON encoding/decoding
    ];

    /**
     * Get the user that this application belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the job that this application is for.
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
