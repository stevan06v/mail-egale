<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailCampaign extends Model
{
    protected $fillable = [
        'name',
        'schedule_time',
        'profile_id',
        'subject',
        'schedule_time',
        'email_blacklist_id',
        'from_email',
        'email_template_id',
        'email_configuration_id',
        'user_id'
    ];

    public function email_lists(): BelongsToMany {
        return $this->belongsToMany(EmailList::class, 'email_list_campaigns', 'email_campaign_id', 'email_list_id');
    }
    public function email_blacklist(): BelongsTo {
        return $this->belongsTo(EmailBlacklist::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function email_template(): BelongsTo
    {
        return $this->belongsTo(EmailTemplate::class);
    }
    public function email_profile(): BelongsTo {
        return $this->belongsTo(EmailConfiguration::class);
    }
}
