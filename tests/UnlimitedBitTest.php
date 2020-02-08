<?php
declare(strict_types=1);

namespace Mitsuru793\Bit;

use Helper\TestBase;

final class UnlimitedBitTest extends TestBase
{
    /**
     * @dataProvider constructProvider
     * @param int|string $init
     */
    public function testConstruct($init, int $expectedInt, string $expectedStr): void
    {
        $bit = new UnlimitedBit($init);
        $this->assertSame($expectedInt, $bit->asInt());
        $this->assertSame($expectedStr, $bit->asStr());
    }

    /**
     * @return array[]
     */
    public function constructProvider(): array
    {
        return [
            'Integer 0.' => [
                'init' => 0,
                'expectedInt' => 0,
                'expectedStr' => '0',
            ],
            'String 0' => [
                'init' => '0',
                'expectedInt' => 0,
                'expectedStr' => '0',
            ],
            'Complex integer' => [
                'init' => 9,
                'expectedInt' => 9,
                'expectedStr' => '1001',
            ],
            'Complex string' => [
                'init' => '1001',
                'expectedInt' => 9,
                'expectedStr' => '1001',
            ],
            'First 0 is ignored.' => [
                'init' => '0010',
                'expectedInt' => 2,
                'expectedStr' => '10',
            ],
        ];
    }

    /**
     * @dataProvider onProvider
     * @param int|int[] $onDigits
     */
    public function testOn(int $init, $onDigits, int $expectedInt, string $expectedStr): void
    {
        $bit = new UnlimitedBit($init);
        $bit = $bit->on($onDigits);
        $this->assertSame($expectedInt, $bit->asInt());
        $this->assertSame($expectedStr, $bit->asStr());
    }

    /**
     * @return array[]
     */
    public function onProvider(): array
    {
        return [
            'Argument as digit starts 0.' => [
                'init' => 0,
                'onDigits' => 1,
                'expectedInt' => 1,
                'expectedStr' => '1',
            ],
            'Argument can be array.' => [
                'init' => 0,
                'onDigits' => [2, 4],
                'expectedInt' => 10,
                'expectedStr' => '1010',
            ],
            'Digit 0 remains.' => [
                'init' => 1,
                'onDigits' => 4,
                'expectedInt' => 9,
                'expectedStr' => '1001',
            ],
            'Already on flags do not change.' => [
                'init' => 9, // '1001'
                'onDigits' => [1, 2],
                'expectedInt' => 11,
                'expectedStr' => '1011',
            ],

            'OnDigits are over init bit' => [
                'init' => 1,
                'onDigits' => 4,
                'expectedInt' => 9,
                'expectedStr' => '1001',
            ],
        ];
    }

    /**
     * @dataProvider offProvider
     * @param int|int[] $onDigits
     */
    public function testOff(int $init, $onDigits, int $expectedInt, string $expectedStr): void
    {
        $bit = new UnlimitedBit($init);
        $bit = $bit->off($onDigits);
        $this->assertSame($expectedInt, $bit->asInt());
        $this->assertSame($expectedStr, $bit->asStr());
    }

    /**
     * @return array[]
     */
    public function offProvider(): array
    {
        return [
            'Argument as digit starts 0.' => [
                'init' => 1,
                'offDigits' => 1,
                'expectedInt' => 0,
                'expectedStr' => '0',
            ],
            'Argument can be array.' => [
                'init' => 9, // '1001'
                'offDigits' => [1, 4],
                'expectedInt' => 0,
                'expectedStr' => '0',
            ],
            'Digit 0 remains.' => [
                'init' => 9, // '1001'
                'offDigits' => 1,
                'expectedInt' => 8,
                'expectedStr' => '1000',
            ],
            'Already on flags do not change.' => [
                'init' => 9, // '1001'
                'offDigits' => [1, 2],
                'expectedInt' => 8,
                'expectedStr' => '1000',
            ],

            'OffDigits are over init bit.' => [
                'init' => 9, // '1001'
                'offDigits' => [1, 2, 6],
                'expectedInt' => 8,
                'expectedStr' => '1000',
            ],
        ];
    }

    /**
     * @dataProvider andProvider
     * @param int|string|Bit $other
     */
    public function testAnd(string $init, $other, int $expectedInt, string $expectedStr): void
    {
        $bit = new UnlimitedBit($init);
        $bit = $bit->and($other);
        $this->assertSame($expectedInt, $bit->asInt());
        $this->assertSame($expectedStr, $bit->asStr());
    }

    /**
     * @return array[]
     */
    public function andProvider(): array
    {
        return [
            'Other is int.' => [
                'init' => '0110',
                'other' => 10, // 1010
                'expectedInt' => 2,
                'expectedStr' => '10',
            ],
            'Other is string.' => [
                'init' => '0110',
                'other' => '1010',
                'expectedInt' => 2,
                'expectedStr' => '10',
            ],
            'Other is Bit object.' => [
                'init' => '0110',
                'other' => new UnlimitedBit('1010'),
                'expectedInt' => 2,
                'expectedStr' => '10',
            ],

            'Other is over init digit.' => [
                'init' => '110',
                'other' => new UnlimitedBit('1010'),
                'expectedInt' => 2,
                'expectedStr' => '10',
            ]
        ];
    }

    /**
     * @dataProvider orProvider
     * @param int|string|Bit $other
     */
    public function testOr(string $init, $other, int $expectedInt, string $expectedStr): void
    {
        $bit = new UnlimitedBit($init);
        $bit = $bit->or($other);
        $this->assertSame($expectedInt, $bit->asInt());
        $this->assertSame($expectedStr, $bit->asStr());
    }

    /**
     * @return array[]
     */
    public function orProvider(): array
    {
        return [
            'Other is int' => [
                'init' => '0110',
                'other' => 10, // 1010
                'expectedInt' => 14,
                'expectedStr' => '1110',
            ],
            'Other is string' => [
                'init' => '0110',
                'other' => '1010',
                'expectedInt' => 14,
                'expectedStr' => '1110',
            ],
            'Other is Bit object.' => [
                'init' => '0110',
                'other' => new UnlimitedBit('1010'),
                'expectedInt' => 14,
                'expectedStr' => '1110',
            ],

            'Other is over init digit.' => [
                'init' => '110',
                'other' => new UnlimitedBit('1010'),
                'expectedInt' => 14,
                'expectedStr' => '1110',
            ]
        ];
    }
}
