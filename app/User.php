<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ["id"];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function getCurrentTeamAttribute()
    {
        if (session('current_team')) {
            return Team::find(session('current_team'));
        }

        if (!$this->team_id) {
            $this->update(['team_id' => Team::newFor($this)->id]);
        }

        session(['current_team' => $this->team->id]);

        return $this->team;
    }

    public function join(Team $team)
    {
        $this->teams()->attach($this);
    }
}
