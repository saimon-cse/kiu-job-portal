<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEducationHistory extends Model
{
    use HasFactory;
    protected $table = 'user_educations_history';
    protected $guarded = [];
}
