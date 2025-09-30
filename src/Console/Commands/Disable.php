<?php

namespace A2ZWeb\DevMode\Console\Commands;

use A2ZWeb\DevMode\DevModeService;
use Illuminate\Console\Command;
use Illuminate\Console\ManuallyFailedException;

class Disable extends Command
{
    protected $signature = 'dev-mode:disable {--user=}';

    protected $description = 'Disable developer mode for a specific user and IP address';

    public function handle(DevModeService $devMode)
    {
        $user = $this->getUser();

        $devMode->disable($user);

        $this->output->success("Dev mode successfully disabled for user #{$user}");
    }

    protected function getUser(): string
    {
        $userId = $this->option('user');
        if (! $userId) {
            throw new ManuallyFailedException('Missing required --user option. Please specify a user ID.');
        }

        return $userId;
    }
}
