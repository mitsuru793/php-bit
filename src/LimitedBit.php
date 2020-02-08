<?php
declare(strict_types=1);

namespace Php;

class LimitedBit implements Bit
{
    use UnlimitedBitTrait {
        on as _on;
        off as _off;
        and as _and;
        or as _or;
    }

    /** All bits are 1. */
    private int $maxBit;

    private int $maxDigit;

    /** Decimal number for bit flags. */
    private int $value;

    /**
     * @param int|string
     */
    private function __construct(int $maxBit, $value = 0)
    {
        $this->maxBit = $maxBit;
        $this->maxDigit = strlen(decbin($maxBit));

        if (is_string($value)) {
            $value = bindec($value);
        }
        $this->value = $value;
        $this->value &= $this->maxBit;
    }

    /**
     * @return static
     */
    public static function maxBit(int $maxBit, $value = 0)
    {
        return new static($maxBit, $value);
    }

    /**
     * @return static
     */
    public static function maxDigit(int $maxDigit, $value = 0)
    {
        $maxBit = pow(2, $maxDigit) - 1;
        return static::maxBit($maxBit, $value);
    }

    public function asInt(): int
    {
        return $this->value;
    }

    public function asStr(): string
    {
        return decbin($this->value);
    }

    public function on($digits)
    {
        if (is_int($digits)) {
            $digits = [$digits];
        }

        $digits = array_filter($digits, fn($digit) => $digit <= $this->maxDigit);
        return $this->_on($digits);
    }

    public function off($digits)
    {
        if (is_int($digits)) {
            $digits = [$digits];
        }

        $digits = array_filter($digits, fn($digit) => $digit <= $this->maxDigit);
        return $this->_off($digits);
    }

    public function and($other)
    {
        $new = $this->_and($other);
        $new->value &= $this->maxBit;
        return $new;
    }

    public function or($other)
    {
        $new = $this->_or($other);
        $new->value &= $this->maxBit;
        return $new;
    }
}
