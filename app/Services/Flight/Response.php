<?php

namespace App\Services\Flight;

class Response
{
    private array $requiredPropsKeys = [
                'titile',
                'progressId',
                'departure',
                'arriving',
                'passengers',
                'airplanes',
                'isPrivate',
                'isRoundTrip'
            ];
    private array $props = [];

    public function getKeys(): array
    {
        return $this->requiredPropsKeys;
    }

    public function addProps(string $key, mixed $value): void
    {
        $this->props[$key] = $value;
    }

    public function getProps(): array
    {
        return $this->props;
    }

    public function removeItem(string $key): void
    {
        unset($this->props[$key]);
    }

    public function resetProps(): void
    {
        $this->props = [];
    }
}
