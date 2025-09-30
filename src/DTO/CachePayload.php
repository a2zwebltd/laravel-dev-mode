<?php

namespace A2ZWeb\DevMode\DTO;

use Carbon\Carbon;

readonly class CachePayload
{
    public static function make(string $ip): self
    {
        return new self($ip, Carbon::now());
    }

    public function __construct(
        public string $ip,
        public Carbon $createdAt
    ) {}

    public function __serialize(): array
    {
        return [
            'ip' => $this->ip,
            'created_at' => $this->createdAt->getTimestamp(),
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->ip = $data['ip'];
        $this->createdAt = new Carbon($data['created_at']);
    }
}
