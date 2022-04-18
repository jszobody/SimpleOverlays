<?php

namespace App\Models;

use App\Notifications\TeamMemberInvitation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class Invite extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->token = Str::uuid();
        });
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function send()
    {
        Notification::route('mail', $this->email)
            ->notify(new TeamMemberInvitation($this));

        return $this;
    }
}
