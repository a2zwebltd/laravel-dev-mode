<?php

namespace A2ZWeb\DevMode;

use A2ZWeb\DevMode\DTO\CachePayload;
use Illuminate\Container\Attributes\Config;
use Illuminate\Container\Attributes\Singleton;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Cache;

#[Singleton]
readonly class DevModeService
{
    public function __construct(
        #[Config('dev-mode.ttl')]
        public int $ttl
    ) {}

    public function enable(Authenticatable|int|string $user, string $ip): void
    {
        Cache::set($this->getCacheKey($user), CachePayload::make($ip), $this->ttl);
    }

    public function disable(Authenticatable|int|string $user): void
    {
        Cache::delete($this->getCacheKey($user));
    }

    public function isEnabled(Authenticatable|int|string $user, string $ip): bool
    {
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
