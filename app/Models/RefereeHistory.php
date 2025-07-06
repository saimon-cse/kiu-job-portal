<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefereeHistory extends Model
{
    use HasFactory;
    protected $table = 'referees_history';
    protected $guarded = [];
}
