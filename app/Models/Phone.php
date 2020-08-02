<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{
    protected $fillable = [
        'user_id', 'name', 'phone_number'
    ];

    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        $this->belongsTo(User::class);
    }
}
