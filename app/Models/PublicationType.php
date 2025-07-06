<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationType extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    public function userPublications()
    {
        return $this->hasMany(UserPublication::class);
    }
}
