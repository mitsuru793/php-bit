<?php
declare(strict_types=1);

namespace Php;

trait UnlimitedBitTrait
{
    public function on($digits)
    {
        if (is_int($digits)) {
            $digits = [$digits];
        }

        $new = clone $this;
        foreach ($digits as $digit) {
            if ($digit < 1) {
                throw new \InvalidArgumentException("Digit must be than 0, but $digit.");
            }
            $new->value |= (1 << ($digit - 1));
        }
        return $new;
    }

    public function off($digits)
    {
        if (is_int($digits)) {
            $digits = [$digits];
        }

        $new = clone $this;
        foreach ($digits as $digit) {
            if ($digit < 1) {
                throw new \InvalidArgumentException("Digit must be than 0, but $digit.");
            }
            $new->value &= ~(1 << ($digit - 1));
        }
        return $new;
    }

    /**
     * @return static
     */
    public function and($other)
    {
        if (is_string($other)) {
            $other = bindec($other);
        } elseif ($other instanceof Bit) {
            $other = $other->asInt();
        }

        $new = clone $this;
        $new->value &= $other;
        return $new;
    }

    /**
     * @return static
     */
    public function or($other)
    {
        if (is_string($other)) {
            $other = bindec($other);
        } elseif ($other instanceof Bit) {
            $other = $other->asInt();
        }

        $new = clone $this;
        $new->value |= $other;
        return $new;
    }
}
