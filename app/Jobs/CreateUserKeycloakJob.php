<?php

namespace App\Jobs;

use App\Events\CreateUserKeycloakEvent;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateUserKeycloakJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $token;
    public $username;
    public $email;
    /**
     * Create a new job instance.
     */
    public function __construct($token, $username, $email)
    {
        $this->username = $username;
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        event(new CreateUserKeycloakEvent($this->token, $this->username, $this->email));
        if (session()->has('userIdKeycloak')) {
            $userIdKeycloak = session()->get('userIdKeycloak');
            User::where('email', 'like', '%' . $this->email . '%')->update([
                'userIdKeyCloak' => $userIdKeycloak
            ]);
            session()->forget('userIdKeycloak');
        }
    }
}
