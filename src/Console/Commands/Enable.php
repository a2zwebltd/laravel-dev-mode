<?php

namespace A2ZWeb\DevMode\Console\Commands;

use A2ZWeb\DevMode\DevModeService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Console\ManuallyFailedException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class Enable extends Command
{
    protected $signature = 'dev-mode:enable {--user= : User ID} {--ip= : Any Valid IPv4 Or IPv6}';

    protected $description = 'Enable developer mode for a specific user and IP address';

    public function handle(DevModeService $devMode): void
    {
        $user = $this->getUser();
        $ip = $this->getIP();

        try {
            $devMode->enable($user, $ip);
        } catch (Exception $e) {
            throw new ManuallyFailedException($e->getMessage(), previous: $e);
        }

        $this->output->success("Developer mode enabled for user ID {$user->getAuthIdentifier()} on IP {$ip}. Duration: {$devMode->ttl} seconds.");
    }

    protected function getUser(): Authenticatable
    {
        $userId = $this->option('user');
        if (! $userId) {
            throw new ManuallyFailedException('Missing required --user option. Please specify a user ID.');
        }

        $user = Auth::getProvider()->retrieveById($userId);
        if (! $user) {
            throw new ManuallyFailedException("No user found with the specified ID: {$userId}");
        }

        return $user;
    }

    protected function getIP(): string
    {
        $ip = $this->option('ip');
        if (! $ip) {
            throw new ManuallyFailedException('Missing required --ip option. Please specify an IP address.');
        }

        if (! filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new ManuallyFailedException("Invalid IP address format provided: {$ip}");
        }

        return $ip;
    }
}
