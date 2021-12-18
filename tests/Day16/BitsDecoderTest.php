<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day16;

use PHPUnit\Framework\TestCase;

class BitsDecoderTest extends TestCase
{
    private BitsDecoder $decoder;

    public function setUp(): void
    {
        $this->decoder = new BitsDecoder();
    }

    public function providerPart1Input(): array
    {
        return [
            ["8A004A801A8002F478", 16],
            ["620080001611562C8802118E34", 12],
            ["C0015000016115A2E0802F182340", 23],
            ["A0016C880162017C3686B18A3D4780", 31],
        ];
    }

    /**
     * @dataProvider providerPart1Input
     */
    public function testPart1(string $input, int $expected): void
    {
        self::assertSame($expected, $this->decoder->part1($input));
    }
}
