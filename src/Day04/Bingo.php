<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day04;

use LogicException;

class Bingo
{
    /**
     * @param array<array-key, string> $input
     *
     * @return array{numbers_drawn: array<array-key, int>, boards: array<array-key, BingoBoard>}
     */
    private function parseInput(array $input): array
    {
        $numbers_drawn = array_map(static function (string $value) {
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

            if ($board === null) {
                throw new LogicException("board is still null");
            }

            $board->addRow($row);
        }

        return ["numbers_drawn" => $numbers_drawn, "boards" => $boards];
    }

    /**
     * @param array<array-key, string> $input
     */
    public function part1(array $input): int
    {
        $parsed = $this->parseInput($input);
        $numbers_drawn = $parsed["numbers_drawn"];
        $boards = $parsed["boards"];

        foreach ($numbers_drawn as $drawn_number) {
            foreach ($boards as $board) {
                $board->markAsDrawn($drawn_number);

                if ($board->hasBingo()) {
                    return (int)($board->sumUnmarkedNumbers() * $drawn_number);
                }
            }
        }

        throw new LogicException("failed to find a bingo");
    }

    /**
     * @param array<array-key, string> $input
     */
    public function part2(array $input): int
    {
        $parsed = $this->parseInput($input);
        $numbers_drawn = $parsed["numbers_drawn"];
        $boards = $parsed["boards"];

        $number_of_boards = count($boards);
        $bingos = 0;

        foreach ($numbers_drawn as $drawn_number) {
            foreach ($boards as $i => $board) {
                $board->markAsDrawn($drawn_number);

                if ($board->hasBingo()) {
                    unset($boards[$i]); // remove this board since we know it has a bingo already
                    $bingos++;
                    if ($bingos === $number_of_boards) {
                        return (int)($board->sumUnmarkedNumbers() * $drawn_number);
                    }
                }
            }
        }

        throw new LogicException("failed to find a bingo");
    }
}
