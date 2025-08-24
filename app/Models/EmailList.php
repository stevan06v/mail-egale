<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailList extends Model
{
    protected $fillable = [
        'name',
        'email_column_name',
        'column_delimiter',
        'user_id'
    ];

    public function email_entries(): HasMany
    {
        return $this->hasMany(EmailEntry::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
