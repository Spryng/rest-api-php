<?php

namespace Spryng\SpryngRestApi;

use Spryng\SpryngRestApi\Exceptions\ValidationException;

class Utils
{       
    /**
     * Checks if $expected equals $actual. If not, throws an exception
     *
     * @param mixed $expected The expected value
     * @param mixed $actual   The actual value
     * 
     * @return void
     */
    public static function assert($expected, $actual = null)
    {
        if ($actual === null && !$expected) {
            throw new ValidationException('\'%s\' cannot be null', $expected);
        }
        if (!$expected || $actual !== null && $expected !== $actual) {
            throw new ValidationException(sprintf('Assertion failed. Got \'%s\' but expected \'%s\'.', $actual, $expected));
        }
    }
}