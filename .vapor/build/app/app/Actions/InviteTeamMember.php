<?php

namespace App\Actions;

use App\Models\Invite;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Action;

class InviteTeamMember extends Action
{
    protected $getAttributesFromConstructor = true;

    public function handle($email, Team $team, ?User $from = null)
    {
        $from ??= Auth::user();

        if(!$user = User::firstWhere('email', strtolower($this->email))) {
            return $this->invite($email, $team, $from);
        }

        if($user->isMemberOf($team)) {
            return false;
        }

        return $this->invite($user->email, $team, $from);
    }

    protected function invite($email, Team $team, User $from)
    {
        return Invite::updateOrCreate(
            ['email' => $email, 'team_id' => $team->id],
            ['user_id' => $from->id]
        )->send();
    }
}
