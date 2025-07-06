<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [ 'from_date' => 'date', 'to_date' => 'date' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
