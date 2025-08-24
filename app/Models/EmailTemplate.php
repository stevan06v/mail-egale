<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailTemplate extends Model
{

    protected $fillable = [
        'user_id',
        'name',
        'html'
    ];

    public function campaigns(): HasMany
    {
        return $this->hasMany(EmailCampaign::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
