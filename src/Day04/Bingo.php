<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day04;

use LogicException;

class Bingo
{
    private function parseInput(array $input): array
    {
        $numbers_drawn = array_map(static function ($value) {
            return (int)$value;
        }, preg_split('/,/', trim($input[0])));
        unset($input[0]);

        // initialize the boards
        $boards = [];
        $board = null;
        foreach ($input as $row) {
            if (empty($row)) {
                $board = new BingoBoard();
                $boards[] = $board;

                continue;
            }

            $board->addRow($row);
        }

        return [$numbers_drawn, $boards];
    }

    public function part1(array $input): int
    {
        [$numbers_drawn, $boards] = $this->parseInput($input);

        foreach ($numbers_drawn as $drawn_number) {
            foreach ($boards as $board) {
                $board->markAsDrawn($drawn_number);

                if ($board->hasBingo()) {
                    return $board->sumUnmarkedNumbers() * $drawn_number;
                }
            }
        }

        throw new LogicException("failed to find a bingo");
    }

    public function part2(array $input): int
    {
        [$numbers_drawn, $boards] = $this->parseInput($input);

        $number_of_boards = count($boards);
        $bingos = 0;

        foreach ($numbers_drawn as $drawn_number) {
            foreach ($boards as $i => $board) {
                $board->markAsDrawn($drawn_number);

                if ($board->hasBingo()) {
                    unset($boards[$i]); // remove this board since we know it has a bingo already
                    $bingos++;
                    if ($bingos === $number_of_boards) {
                        return $board->sumUnmarkedNumbers() * $drawn_number;
                    }
                }
            }
        }

        throw new LogicException("failed to find a bingo");
    }
}
