<?php

namespace A2ZWeb\DevMode;

use A2ZWeb\DevMode\DTO\CachePayload;
use Exception;
use Illuminate\Container\Attributes\Config;
use Illuminate\Container\Attributes\Singleton;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

#[Singleton]
readonly class DevModeService
{
    public function __construct(
        #[Config('app.debug_mode_ttl')]
        public int $ttl
    ) {}

    public function enable(Authenticatable $user, string $ip): void
    {
        if (! $user instanceof Model) {
            throw new InvalidArgumentException('User must be an instance of Eloquent Model.');
        }

        if (! $user->is_developer) {
            throw new Exception('user is not a developer');
        }

        Cache::set($this->getCacheKey($user), CachePayload::make($ip), $this->ttl);
    }

    public function disable(Authenticatable|int|string $user): void
    {
        Cache::delete($this->getCacheKey($user));
    }

    public function isEnabled(Authenticatable $user, string $ip): bool
    {
        if (! $user instanceof Model) {
            return false;
        }

        if (! $user->is_developer) {
            return false;
        }

        /**
         * @var CachePayload|null
         */
        $payload = Cache::get($this->getCacheKey($user, $ip));
        if ($payload === null) {
            return false;
        }

        return $payload->ip === $ip;
    }

    private function getCacheKey(Authenticatable|int|string $user): string
    {
        return 'dev-mode:'.($user instanceof Authenticatable ? $user->getAuthIdentifier() : $user);
    }
}
