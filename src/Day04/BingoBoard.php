<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day04;

class BingoBoard
{
    /** @var array<array<BingoBoardNumber>> */
    private array $board;

    public function __construct()
    {
    }

    public function markAsDrawn(int $number): void
    {

    }

    public function addRow(string $row): void
    {
        $numbers_in_row = array_map(static function ($value) {
            return new BingoBoardNumber((int)$value);
        }, preg_split('/\s+/', trim($row)));

        $this->board[] = $numbers_in_row;
    }

    public function __toString(): string
    {
        $return = "";

        foreach ($this->board as $row) {
            foreach ($row as $number) {
                $return .= str_pad((string)$number->number, 3, " ", STR_PAD_LEFT);
            }

            $return .= PHP_EOL;
        }

        return $return;
    }
}
