<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function memberTeams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    public function owningTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'owner_id');
    }

    public function primaryTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function getCurrentTeamAttribute()
    {
        if (session('current_team')) {
            return Team::find(session('current_team'));
        }

        if (! $this->team_id && $this->memberTeams()->count()) {
            $this->update(['team_id' => $this->memberTeams()->first()->id]);
        }

        if (! $this->team_id) {
            $this->update([
                'team_id' => $this->memberTeams()->count()
                    ? $this->memberTeams()->first()->id
                    : Team::newFor($this)->id,
            ]);
        }

        $this->selectTeam($this->primaryTeam);

        return $this->primaryTeam;
    }

    public function selectTeam(Team $team)
    {
        session(['current_team' => $team->id]);

        return $this;
    }

    public function join(Team $team)
    {
        $this->memberTeams()->attach($team);
    }
}
