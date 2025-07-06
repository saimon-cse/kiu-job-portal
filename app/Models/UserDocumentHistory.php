<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocumentHistory extends Model
{
    use HasFactory;
    protected $table = 'user_documents_history';
    protected $guarded = [];
}
