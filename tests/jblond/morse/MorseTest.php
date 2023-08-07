<?php

namespace jblond\morse;

use PHPUnit\Framework\TestCase;

class MorseTest extends TestCase
{

    public function testGetCharacter(): void
    {
        $characters = new Morse();
        $this->assertEquals(
            [
                '01 ',
                '01001 ',
                '1001 '
            ],
            [
                $characters->getCharacter('A'),
                $characters->getCharacter('Ł'),
                $characters->getCharacter('ช')
            ]
        );
    }

    public function testStringToMorse(): void
    {
        $characters = new Morse();
        $this->assertEquals(
            '1 0000 00 000 / 00 000 / 0111 001 000 1 / 01 / 1 0 000 1 101011 ',
            $characters->stringToMorse('This is just a test!')
        );
    }
    public function testDotDash(): void
    {
        $characters = new Morse();
        $this->assertEquals(
            '- .... .. ... / .. ... / .--- ..- ... - / .- / - . ... - -.-.-- ',
            $characters->dotDash('1 0000 00 000 / 00 000 / 0111 001 000 1 / 01 / 1 0 000 1 101011 ')
        );
    }
}
