<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailConfiguration extends Model
{
    public $table = 'email_configurations';

    public $fillable = [
        'name',
        'smtp_host',
        'port',
        'username',
        'password',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function email_campaigns(): HasMany
    {
        return $this->hasMany(EmailCampaign::class);
    }
}
