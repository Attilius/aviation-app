<?php

namespace App\Contracts;

interface KeyGeneratorInterface
{
    /**
     * Generate unique key with different length.
     *
     * @param int $keyLength
     * @return string
     */
    public function generate(int $keyLength = 2): string;
}
