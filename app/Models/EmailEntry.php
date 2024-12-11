<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailEntry extends Model
{
    protected $fillable = [
        "email_list_id",
        "name",
        "email"
    ];

    public function email_list(): BelongsTo
    {
        return $this->belongsTo(EmailList::class);
    }

}
