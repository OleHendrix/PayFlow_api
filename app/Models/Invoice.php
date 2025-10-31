<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $guarded = [];    

    public function relation(): BelongsTo
    {
        return $this->belongsTo(Relation::class);
    }
}
