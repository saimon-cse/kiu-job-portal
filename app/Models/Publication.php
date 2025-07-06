<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Publication extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * No date casting needed here, but you could cast 'publication_year'
     * to 'integer' if you perform numeric operations on it.
     */
    protected $casts = [
        'publication_year' => 'integer',
    ];

    // --- RELATIONSHIPS ---

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }



    /**
     * The type of this publication (e.g., "Journal Article").
     */
    public function publicationType(): BelongsTo
    {
        return $this->belongsTo(PublicationType::class);
    }
}
