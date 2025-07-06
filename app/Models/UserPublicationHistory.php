<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPublicationHistory extends Model
{
    use HasFactory;
    protected $table = 'user_publications_history';
    protected $guarded = [];
}
