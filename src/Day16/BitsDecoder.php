<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day16;

use LogicException;

class BitsDecoder
{
    private const TYPE_ID_SUM = 0;
    private const TYPE_ID_PRODUCT = 1;
    private const TYPE_ID_MINIMUM = 2;
    private const TYPE_ID_MAXIMUM = 3;
    private const TYPE_ID_LITERAL_VALUE = 4;
    private const TYPE_ID_GREATER_THAN = 5;
    private const TYPE_ID_LESS_THAN = 6;
    private const TYPE_ID_EQUAL_TO = 7;

    private const LENGTH_TYPE_ID_SUB_PACKETS_GIVEN_IN_NUMBER_OF_BITS = 0;
    private const LENGTH_TYPE_ID_SUB_PACKETS_GIVEN_IN_NUMBER_OF_SUB_PACKETS = 1;

    private function parseInput(string $hex): string
    {
        $hex = trim($hex);
        $binary = "";
        $input_length = strlen($hex);
        for ($i = 0; $i < $input_length; $i++) {
            $binary .= match ($hex[$i]) {
                "0" => "0000",
                "1" => "0001",
                "2" => "0010",
                "3" => "0011",
                "4" => "0100",
                "5" => "0101",
                "6" => "0110",
                "7" => "0111",
                "8" => "1000",
                "9" => "1001",
                "A" => "1010",
                "B" => "1011",
                "C" => "1100",
                "D" => "1101",
                "E" => "1110",
                "F" => "1111",
            };
        }

        return $binary;
    }

    public function part1(string $hex): int
    {
        return $this->decodeIntoFinalPacket($hex)->version_sum;
    }

    public function part2(string $hex): int
    {
        return $this->decodeIntoFinalPacket($hex)->value;
    }

    private function decodeIntoFinalPacket(string $hex): Packet
    {
        $binary = $this->parseInput($hex);

        $decoded_packets = $this->decodeIntoPackets($binary);

        if (count($decoded_packets) > 1) {
            throw new LogicException("expected only a single decoded packet at this point");
        }

        return reset($decoded_packets);
    }

    /**
     * @return Packet[]
     */
    private function decodeIntoPackets(string &$binary): array
    {
        $packets = [];
        while ($binary) {
            // If we only have zeroes left, we are done
            if (bindec($binary) === 0) {
                break;
            }

            $packets[] = $this->decodeSinglePacket($binary);
        }

        return $packets;
    }

    private function decodeSinglePacket(string &$binary): Packet
    {
        // Every packet begins with a standard header: the first three bits encode the packet version
        $packet_version = $this->readBinaryCharsAsInt($binary, 3);

        // And the next three bits encode the packet type ID
        $packet_type_id = $this->readBinaryCharsAsInt($binary, 3);

        // Packets with type ID 4 represent a literal value. Literal value packets encode a single binary number.
        // To do this, the binary number is padded with leading zeroes until its length is a multiple of four bits,
        // and then it is broken into groups of four bits. Each group is prefixed by a 1 bit except the last group,
        // which is prefixed by a 0 bit. These groups of five bits immediately follow the packet header.
        if ($packet_type_id === self::TYPE_ID_LITERAL_VALUE) {
            $literal_value_in_binary = "";
            while (true) {
                $group_type = $this->readBinaryCharsAsInt($binary, 1);
                $literal_value_in_binary .= $this->readBinaryChars($binary, 4);

                if ($group_type === 0) {
                    break;
                }
            }

            $value = (int)bindec($literal_value_in_binary);

            return new Packet($packet_version, $value);
        }

        // Every other type of packet (any packet with a type ID other than 4) represent an operator that
        // performs some calculation on one or more sub-packets contained within.
        // An operator packet contains one or more packets.

        $length_type_id = $this->readBinaryCharsAsInt($binary, 1);

        // If the length type ID is 0, then the next 15 bits are a number that represents the total length
        // in bits of the sub-packets contained by this packet.
        $sub_packets = [];
        if ($length_type_id === self::LENGTH_TYPE_ID_SUB_PACKETS_GIVEN_IN_NUMBER_OF_BITS) {
            $length_of_sub_packets = $this->readBinaryCharsAsInt($binary, 15);

            $packet_data = $this->readBinaryChars($binary, $length_of_sub_packets);

            $sub_packets = $this->decodeIntoPackets($packet_data);
        } elseif ($length_type_id === self::LENGTH_TYPE_ID_SUB_PACKETS_GIVEN_IN_NUMBER_OF_SUB_PACKETS) {
            // If the length type ID is 1, then the next 11 bits are a number that represents the number of
            // sub-packets immediately contained by this packet.
            $nr_of_sub_packets = $this->readBinaryCharsAsInt($binary, 11);
            for ($i = 0; $i < $nr_of_sub_packets; $i++) {
                $sub_packets[] = $this->decodeSinglePacket($binary);
            }
        } else {
            throw new LogicException("Invalid length type id");
        }

        // Now the sub-packets have been parsed.

        if (count($sub_packets) === 0) {
            throw new LogicException("expected at least a single sub packet");
        }

        $values = array_map(static fn(Packet $packet) => $packet->value, $sub_packets);

        // Combine the packet version of the current packet and add to it all packet versions of its sub-packets.
        $packet_version_sum = $packet_version + array_reduce($sub_packets, static fn(int|null $previous, Packet $current) => ($previous ?? 0) + $current->version_sum);

        if ($packet_type_id === self::TYPE_ID_SUM) {
            return new Packet($packet_version_sum, array_sum($values));
        }

        if ($packet_type_id === self::TYPE_ID_PRODUCT) {
            return new Packet($packet_version_sum, array_product($values));
        }

        if ($packet_type_id === self::TYPE_ID_MINIMUM) {
            return new Packet($packet_version_sum, min($values));
        }

        if ($packet_type_id === self::TYPE_ID_MAXIMUM) {
            return new Packet($packet_version_sum, max($values));
        }

        if ($packet_type_id === self::TYPE_ID_GREATER_THAN) {
            if (count($values) !== 2) {
                throw new LogicException("greater than packets should have exactly 2 sub-packets");
            }
            [$first, $second] = $values;
            return new Packet($packet_version_sum, $first > $second ? 1 : 0);
        }

        if ($packet_type_id === self::TYPE_ID_LESS_THAN) {
            if (count($values) !== 2) {
                throw new LogicException("less than packets should have exactly 2 sub-packets");
            }
            [$first, $second] = $values;
            return new Packet($packet_version_sum, $first < $second ? 1 : 0);
        }

        if ($packet_type_id === self::TYPE_ID_EQUAL_TO) {
            if (count($values) !== 2) {
                throw new LogicException("equal to packets should have exactly 2 sub-packets");
            }
            [$first, $second] = $values;
            return new Packet($packet_version_sum, $first === $second ? 1 : 0);
        }

        throw new LogicException("unknown packet type id");
    }

    private function readBinaryCharsAsInt(string &$input, int $length): int
    {
        return (int)bindec($this->readBinaryChars($input, $length));
    }

    private function readBinaryChars(string &$input, int $length): string
    {
        // Take the first N chars
        $read = substr($input, 0, $length);

        // Remove the first chars (we can modify $input here directly since we are using a pass-by-reference variable)
        $input = substr($input, $length);

        return $read;
    }
}
