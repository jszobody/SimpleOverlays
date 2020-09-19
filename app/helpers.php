<?php

function user()
{
    return Auth::user();
}

function team()
{
    return user()->current_team;
}
