<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class InviteController extends Controller
{
    public function accept(Invite $invite)
    {
        if($invite->accepted_at) {
            abort(403);
        }

        if($user = User::where('email', $invite->email)->first()) {
            // This user is already registered, just add them to the invited team
            $user->memberTeams()->attach($invite->team_id);

            $invite->update(['accepted_at' => now()]);

            return redirect('/');
        }

        return view('auth.invitation', ['invite' => $invite]);
    }

    public function complete(Request $request, Invite $invite)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $invite->email,
            'password' => Hash::make($request->password),
        ]);

        $user->memberTeams()->attach($invite->team_id);
        $invite->update(['accepted_at' => now()]);

        Auth::login($user);

        return redirect('/');
    }
}
