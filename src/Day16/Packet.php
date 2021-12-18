<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day16;

class Packet
{
    public function __construct(public int $version_sum, public int $value)
    {
    }
}
