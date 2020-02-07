<?php
declare(strict_types=1);

namespace Php;

final class Bit
{
    /** Decimal number for bit flags. */
    private int $value;

    /**
     * @param int|string
     */
    public function __construct($value = 0)
    {
        if (is_string($value)) {
            $value = bindec($value);
        }
        $this->value = $value;
    }

    public function asInt(): int
    {
        return $this->value;
    }

    public function asStr(): string
    {
        return decbin($this->value);
    }

    /**
     * @param int|int[] $digits
     */
    public function on($digits): self
    {
        if (is_int($digits)) {
            $digits = [$digits];
        }

        $new = clone $this;
        foreach ($digits as $digit) {
            $new->value |= (1 << $digit);
        }
        return $new;
    }

    /**
     * @param int|int[] $digits
     */
    public function off($digits)
    {
        if (is_int($digits)) {
            $digits = [$digits];
        }

        $new = clone $this;
        foreach ($digits as $digit) {
            $new->value &= ~(1 << $digit);
        }
        return $new;
    }

    /**
     * @param int|string $other Not digit, but bit value. 5 is '101'
     */
    public function and($other): self
    {
        if (is_string($other)) {
            $other = bindec($other);
        }

        $new = clone $this;
        $new->value &= $other;
        return $new;
    }
}

