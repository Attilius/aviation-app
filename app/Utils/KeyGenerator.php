<?php

namespace App\Utils;

use App\Contracts\KeyGeneratorInterface;

class KeyGenerator implements KeyGeneratorInterface
{
    private static array $chars = [
        "A", "a", "B",
        "b", "C", "c",
        "D", "d", "E",
        "e", "F", "f",
        "G", "g", "H",
        "h", "I", "i",
        "J", "j", "K",
        "k", "L", "l",
        "M", "m", "N",
        "n", "O", "o",
        "P", "p", "Q",
        "q", "R", "r",
        "S", "s", "T",
        "t", "U", "u",
        "V", "v", "W",
        "w", "X", "x",
        "Y", "y", "Z",
        "z",
    ];

    private static array $numbers = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];

    private static string $key = '';

    /**
     * Generate a unique key in different type and length.
     *
     * @param int $keyLength
     * @param string $type
     * @return string
     */
    public function generate(int $keyLength = 2, string $type = ''): string
    {
        if($type === '') {
            for ($i = 0; $i < $keyLength; $i++) {
                if($i == 0 || $i % 2 == 0) {
                   $charIndex = rand(0, count(self::$chars) - 1);
                   self::$key .= self::$chars[$charIndex];
                } else {
                    $numberIndex = rand(0, count(self::$numbers) - 1);
                    self::$key .= self::$numbers[$numberIndex];
                }
            }
        }

        switch ($type) {
            case 'alpha': {
                return $this->createOnlyAlphaNumericKey($keyLength);
            }
            case 'number': {
                return $this->createOnlyNumericKey($keyLength);
            }
            case 'mix': {
                return $this->createMixedNumericAndAlphaNumericKey($keyLength);
            }
        }

        return self::$key;
    }

    /**
     * Generate a random alphanumeric key.
     *
     * @param int $keyLength
     * @return string
     */
    private static function createOnlyAlphaNumericKey(int $keyLength): string
    {
        for ($i = 0; $i < $keyLength; $i++) {
            $charIndex = rand(0, count(self::$chars) - 1);
            self::$key .= self::$chars[$charIndex];
        }

        return self::$key;
    }

    /**
     * Generate a random numeric key.
     *
     * @param int $keyLength
     * @return string
     */
    private function createOnlyNumericKey(int $keyLength): string
    {
        for ($i = 0; $i < $keyLength; $i++) {
            $numberIndex = rand(0, count(self::$numbers) - 1);
            self::$key .= self::$numbers[$numberIndex];
        }

        return self::$key;
    }

    /**
     * Generate a random alphanumeric and numeric mixed key.
     *
     * @param int $keyLength
     * @return string
     */
    private static function createMixedNumericAndAlphaNumericKey(int $keyLength): string
    {
        for ($i = 0; $i < $keyLength; $i++) {
            $randomValue = rand(0, 99);

            $index = $randomValue %5 === 0
                ? rand(0, count(self::$numbers) - 1) . ' number'
                : rand(0, count(self::$chars) - 1) . ' char';

            explode(' ',$index)[1] === 'char'
                ? self::$key .= self::$chars[explode(' ',$index)[0]]
                : self::$key .= self::$numbers[explode(' ',$index)[0]];
        }

        return self::$key;
    }
}
