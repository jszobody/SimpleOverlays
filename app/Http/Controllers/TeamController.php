<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController
{
    public function select(Team $team, Request $request)
    {
        user()->selectTeam(
            user()->memberTeams()->whereId($team->id)->firstOrFail()
        );

        return redirect(
            $request->get('redirect', route('list-stacks'))
        );
    }
}
