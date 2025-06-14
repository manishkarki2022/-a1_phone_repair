<?php

use App\Events\UserCreated;
use App\Notifications\WelcomeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeEmail implements ShouldQueue
{
    public function handle(UserCreated $event)
    {
        $event->user->notify(new WelcomeEmail());
    }
}
