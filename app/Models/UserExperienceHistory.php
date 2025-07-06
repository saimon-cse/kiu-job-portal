<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExperienceHistory extends Model
{
    use HasFactory;
    protected $table = 'user_experiences_history';
    protected $guarded = [];
}
