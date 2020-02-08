<?php
declare(strict_types=1);

namespace Mitsuru793\Bit;

use Helper\TestBase;

final class LimitedBitTest extends TestBase
{
    /**
     * @dataProvider maxBitProvider
     */
    public function testConstruct(int $maxDigit, $init, int $expectedInt, string $expectedStr)
    {
        $bit = LimitedBit::maxDigit($maxDigit, $init);
        $this->assertSame($expectedInt, $bit->asInt());
        $this->assertSame($expectedStr, $bit->asStr());

        $maxBit = pow(2, $maxDigit) - 1;
        $bit = LimitedBit::maxBit($maxBit, $init);
        $this->assertSame($expectedInt, $bit->asInt());
        $this->assertSame($expectedStr, $bit->asStr());
    }

    public function maxBitProvider()
    {
        return [
            'Integer 0.' => [
                'maxDigit' => 4,
                'init' => 0,
                'expectedInt' => 0,
                'expectedStr' => '0',
            ],
            'String 0' => [
                'maxDigit' => 4,
                'init' => '0',
                'expectedInt' => 0,
                'expectedStr' => '0',
            ],
            'Complex integer' => [
                'maxDigit' => 4,
                'init' => 9,
                'expectedInt' => 9,
                'expectedStr' => '1001',
            ],
            'Complex string' => [
                'maxDigit' => 4,
                'init' => '1001',
                'expectedInt' => 9,
                'expectedStr' => '1001',
            ],
            'First 0 is ignored.' => [
                'maxDigit' => 4,
                'init' => '0010',
                'expectedInt' => 2,
                'expectedStr' => '10',
            ],

            'Ignore over max bit.' => [
                'maxDigit' => 4,
                'init' => '11111',
                'expectedInt' => 15,
                'expectedStr' => '1111',
            ],
        ];
    }

    /**
     * @dataProvider onProvider
     */
    public function testOn(int $maxDigit, int $init, $onDigits, int $expectedInt, string $expectedStr)
    {
        $bit = LimitedBit::maxDigit($maxDigit, $init);
        $bit = $bit->on($onDigits);
        $this->assertSame($expectedInt, $bit->asInt());
        $this->assertSame($expectedStr, $bit->asStr());
    }

    public function onProvider()
    {
        return [
            'Argument as digit starts 0.' => [
                'maxDigit' => 4,
                'init' => 0,
                'onDigits' => 1,
                'expectedInt' => 1,
                'expectedStr' => '1',
            ],
            'Argument can be array.' => [
                'maxDigit' => 4,
                'init' => 0,
                'onDigits' => [2, 4],
                'expectedInt' => 10,
                'expectedStr' => '1010',
            ],
            'Digit 0 remains.' => [
                'maxDigit' => 4,
                'init' => 1,
                'onDigits' => 4,
                'expectedInt' => 9,
                'expectedStr' => '1001',
            ],
            'Already on flags do not change.' => [
                'maxDigit' => 4,
                'init' => 9, // '1001'
                'onDigits' => [1, 2],
                'expectedInt' => 11,
                'expectedStr' => '1011',
            ],

            'Ignore onDigits over max bit.' => [
                'maxDigit' => 4,
                'init' => 9, // '1001'
                'onDigits' => [1, 2, 5],
                'expectedInt' => 11,
                'expectedStr' => '1011',
            ],
        ];
    }

    /**
     * @dataProvider offProvider
     */
    public function testOff(int $maxDigit, int $init, $onDigits, int $expectedInt, string $expectedStr)
    {
        $bit = LimitedBit::maxDigit($maxDigit, $init);
        $bit = $bit->off($onDigits);
        $this->assertSame($expectedInt, $bit->asInt());
        $this->assertSame($expectedStr, $bit->asStr());
    }

    public function offProvider()
    {
        return [
            'Argument as digit starts 0.' => [
                'maxDigit' => 4,
                'init' => 1,
                'offDigits' => 1,
                'expectedInt' => 0,
                'expectedStr' => '0',
            ],
            'Argument can be array.' => [
                'maxDigit' => 4,
                'init' => 9, // '1001'
                'offDigits' => [1, 4],
                'expectedInt' => 0,
                'expectedStr' => '0',
            ],
            'Digit 0 remains.' => [
                'maxDigit' => 4,
                'init' => 9, // '1001'
                'offDigits' => 1,
                'expectedInt' => 8,
                'expectedStr' => '1000',
            ],
            'Already on flags do not change.' => [
                'maxDigit' => 4,
                'init' => 9, // '1001'
                'offDigits' => [1, 2],
                'expectedInt' => 8,
                'expectedStr' => '1000',
            ],

            'OffDigits are over init bit.' => [
                'maxDigit' => 4,
                'init' => 13, // '1101'
                'offDigits' => [1, 4, 5],
                'expectedInt' => 4,
                'expectedStr' => '100',
            ],
        ];
    }

    /**
     * @dataProvider andProvider
     */
    public function testAnd(int $maxDigit, $init, $other, int $expectedInt, string $expectedStr)
    {
        $bit = LimitedBit::maxDigit($maxDigit, $init);
        $bit = $bit->and($other);
        $this->assertSame($expectedInt, $bit->asInt());
        $this->assertSame($expectedStr, $bit->asStr());
    }

    public function andProvider()
    {
        return [
            'Other is int.' => [
                'maxDigit' => 4,
                'init' => '0110',
                'other' => 10, // 1010
                'expectedInt' => 2,
                'expectedStr' => '10',
            ],
            'Other is string.' => [
                'maxDigit' => 4,
                'init' => '0110',
                'other' => '1010',
                'expectedInt' => 2,
                'expectedStr' => '10',
            ],
            'Other is Bit object.' => [
                'maxDigit' => 4,
                'init' => '0110',
                'other' => LimitedBit::maxDigit(4, '1010'),
                'expectedInt' => 2,
                'expectedStr' => '10',
            ],

            'Other is over init digit.' => [
                'maxDigit' => 3,
                'init' => '110',
                'other' => LimitedBit::maxDigit(4, '1010'),
                'expectedInt' => 2,
                'expectedStr' => '10',
            ],
        ];
    }

    /**
     * @dataProvider orProvider
     */
    public function testOr(int $maxDigit, $init, $other, int $expectedInt, string $expectedStr)
    {
        $bit = LimitedBit::maxDigit($maxDigit, $init);
        $bit = $bit->or($other);
        $this->assertSame($expectedInt, $bit->asInt());
        $this->assertSame($expectedStr, $bit->asStr());
    }

    public function orProvider()
    {
        return [
            'Other is int' => [
                'maxDigit' => 4,
                'init' => '0110',
                'other' => 10, // 1010
                'expectedInt' => 14,
                'expectedStr' => '1110',
            ],
            'Other is string' => [
                'maxDigit' => 4,
                'init' => '0110',
                'other' => '1010',
                'expectedInt' => 14,
                'expectedStr' => '1110',
            ],
            'Other is Bit object.' => [
                'maxDigit' => 4,
                'init' => '0110',
                'other' => LimitedBit::maxDigit(4, '1010'),
                'expectedInt' => 14,
                'expectedStr' => '1110',
            ],

            'Other is over init digit.' => [
                'maxDigit' => 3,
                'init' => '110',
                'other' => LimitedBit::maxDigit(4, '1010'),
                'expectedInt' => 6,
                'expectedStr' => '110',
            ],
        ];
    }
}
