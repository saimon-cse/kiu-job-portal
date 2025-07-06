<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfileHistory extends Model
{
    use HasFactory;
    protected $table = 'user_profiles_history';
    protected $guarded = [];
}
