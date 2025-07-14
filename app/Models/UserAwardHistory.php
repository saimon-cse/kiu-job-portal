<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAwardHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * This explicitly tells Laravel which table this model manages.
     *
     * @var string
     */
    protected $table = 'user_awards_history';

    /**
     * The attributes that are not mass assignable.
     *
     * An empty array means all attributes are mass assignable, which is safe
     * here because we control the data being passed in from our own system
     * during the snapshot process.
     *
     * @var array
     */
    protected $guarded = [];
}
