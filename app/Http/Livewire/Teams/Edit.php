<?php

namespace App\Http\Livewire\Teams;

use App\Actions\InviteTeamMember;
use App\Http\Livewire\WithNotifications;
use App\Models\Invite;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    use WithNotifications;

    public $team;
    public $email;
    public $displayingInviteDialog = false;

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function render()
    {
        return view('livewire.teams.edit');
    }

    public function displayInviteDialog()
    {
        $this->displayingInviteDialog = true;
        $this->reset('email');
        $this->resetErrorBag('email');
    }

    public function invite()
    {
        $this->validateOnly('email',
            ['email' => 'required|email'],
            ['required' => 'Please enter a valid email address', 'email' => 'Please enter a valid email address']
        );

        $this->displayingInviteDialog = false;

        /** @var Invite $invite */
        $invite = InviteTeamMember::run($this->email, $this->team);

        return $invite
            ? $this->notify('Invitation email sent to ' . $invite->email)
            : $this->notify('That email is already part of this team', 'warning');
    }
}
