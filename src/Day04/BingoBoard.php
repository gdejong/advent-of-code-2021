<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day04;

class BingoBoard
{
    /** @var array<array<BingoBoardNumber>> */
    private array $board = [];

    public function markAsDrawn(int $number): void
    {
        foreach ($this->board as $row) {
            foreach ($row as $bingo_board_number) {
                if ($bingo_board_number->number === $number) {
                    $bingo_board_number->drawn = true;
                }
            }
        }
    }

    public function hasBingo(): bool
    {
        foreach ($this->board as $row) {
            // first find the row values
            if ($this->numbersAreBingo($row)) {
                // we got a horizontal bingo
                return true;
            }
        }

        // no row-bingo found, maybe there are columns that form a bingo
        $length = count($this->board[0]);
        $height = count($this->board);
        for ($i = 0; $i < $length; $i++) {
            $column_values = [];
            for ($j = 0; $j < $height; $j++) {
                $column_values[] = $this->board[$j][$i];
            }
            if ($this->numbersAreBingo($column_values)) {
                // we got a vertical bingo
                return true;
            }
        }

        return false;
    }

    public function sumUnmarkedNumbers(): int
    {
        $sum = 0;

        foreach ($this->board as $row) {
            foreach ($row as $bingo_board_number) {
                if ($bingo_board_number->drawn === false) {
                    $sum += $bingo_board_number->number;
                }
            }
        }

        return $sum;
    }

    /**
     * @param BingoBoardNumber[] $values
     */
    private function numbersAreBingo(array $values): bool
    {
        foreach ($values as $value) {
            if ($value->drawn === false) {
                return false;
            }
        }

        return true;
    }

    public function addRow(string $row): void
    {
        $numbers_in_row = array_map(static function (string $value) {
            return new BingoBoardNumber((int)$value);
        }, preg_split('/\s+/', trim($row)));

        $this->board[] = $numbers_in_row;
    }

    public function __toString(): string
    {
        $return = "";

        foreach ($this->board as $row) {
            foreach ($row as $number) {
                $return .= $number;
            }

            $return .= PHP_EOL;
        }

        return $return;
    }
}
