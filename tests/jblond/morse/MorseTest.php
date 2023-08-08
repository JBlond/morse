<?php

namespace jblond\morse;

use PHPUnit\Framework\TestCase;

class MorseTest extends TestCase
{

    public function testGetCharacter(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            [
                '01 ',
                '01001 ',
                'thai',
                '1001 '
            ],
            [
                $morse->getCharacter('A'),
                $morse->getCharacter('Ł'),
                $morse->setLetters('thai'),
                $morse->getCharacter('ช')
            ]
        );
    }

    public function testStringToMorse(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            '1 0000 00 000 / 00 000 / 0111 001 000 1 / 01 / 1 0 000 1 101011 ',
            $morse->stringToMorse('This is just a test!')
        );
    }
    public function testDotDash(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            '- .... .. ... / .. ... / .--- ..- ... - / .- / - . ... - -.-.-- ',
            $morse->dotDash('1 0000 00 000 / 00 000 / 0111 001 000 1 / 01 / 1 0 000 1 101011 ')
        );
    }
}
