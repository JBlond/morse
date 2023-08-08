<?php

namespace jblond\morse;

use jblond\morse\CharacterSet\Greek;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class MorseTest extends TestCase
{

    /**
     * @covers \jblond\morse\Morse
     * @return void
     */
    public function testGetCharacter(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            [
                '01 ',
                '01001 ',
                'Thai',
                '1001 '
            ],
            [
                $morse->getCharacter('A'),
                $morse->getCharacter('Ł'),
                $morse->setLetters('Thai'),
                $morse->getCharacter('ช')
            ]
        );
    }

    /**
     * @covers \jblond\morse\Morse
     * @return void
     */
    public function testStringToMorse(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            '1 0000 00 000 / 00 000 / 0111 001 000 1 / 01 / 1 0 000 1 101011 ',
            $morse->stringToMorse('This is just a test!')
        );
    }

    /**
     * @covers \jblond\morse\Morse
     * @return void
     */
    public function testJapaneseString(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            [
                'Japanese',
                '01 ',
                '001 10001 1001 0110 10 1011 ',
                '0110 10110 0100 10001 '

            ],
            [
                $morse->setLetters('Japanese'),
                $morse->stringToMorse('イ'),
                $morse->stringToMorse('ウメマツタケ'),
                $morse->stringToMorse('ツルカメ')
            ]
        );
    }

    /**
     * @covers \jblond\morse\Morse
     * @return void
     */
    public function testGreekString(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            [
                'Greek',
                '1 0 0100 111 000 / 0 101 0110 111 11 0110 0000 000 '
            ],
            [
                $morse->setLetters('Greek'),
                $morse->stringToMorse((new Greek())->stringToUpper('Τέλος εκπομπής'))
            ]
        );
    }

    /**
     * @covers \jblond\morse\Morse
     * @return void
     */
    public function testCyrillicString(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            [
                'Cyrillic',
                '1100 01 0110 111 11 10 00 1 1001 '
            ],
            [
                $morse->setLetters('Cyrillic'),
                $morse->stringToMorse('Запомнить')
            ]
        );
    }

    /**
     * @covers \jblond\morse\Morse
     * @return void
     */
    public function testArabicString(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            [
                'Arabic',
                '1111 0010 010 0000  / 11 011 010 000 '
            ],
            [
                $morse->setLetters('Arabic'),
                $morse->stringToMorse('شفرة مورس')
            ]
        );
    }

    /**
     * @covers \jblond\morse\Morse
     * @return void
     */
    public function testHebrewString(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            [
                'Hebrew',
                '0100 11 000 0100 '
            ],
            [
                $morse->setLetters('Hebrew'),
                $morse->stringToMorse('למשל')
            ]
        );
    }

    /**
     * @covers \jblond\morse\Morse
     * @return void
     */
    public function testKoreanString(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            [
                'Korean',
                '0100 001 11 / 1010 001 / 0100 0 / 11 0 110 / 101 001 110 110 / 1000 0 '
            ],
            [
                $morse->setLetters('Korean'),
                // hangul 김치가 맛있다
                // Single letters: ㄱㅣㅁ ㅊㅣ ㄱㅏ ㅁㅏㅅ ㅇㅣㅅㅅ ㄷㅏ
                // SKATS: LUM CU LE  MEG KUGG BE
                $morse->stringToMorse('ㄱㅣㅁ ㅊㅣ ㄱㅏ ㅁㅏㅅ ㅇㅣㅅㅅ ㄷㅏ')
            ]
        );
    }

    /**
     * @covers \jblond\morse\Morse
     * @return void
     */
    public function testPersianString(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            [
                'Persian',
                '101 100 / 11 011 010 000 '
            ],
            [
                $morse->setLetters('Persian'),
                $morse->stringToMorse('کد مورس')
            ]
        );
    }

    /**
     * @covers \jblond\morse\Morse
     * @return void
     */
    public function testThaiString(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            [
                'Thai',
                '010 0000 01101 000 11 10001 010 11001 000 #01 #01 01001 10011 1011 '
            ],
            [
                $morse->setLetters('Thai'),
                $morse->stringToMorse('รหัสมอร์สภาษาไทย')
            ]
        );
    }

    /**
     * @covers \jblond\morse\Morse
     * @return void
     */
    public function testDotDash(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            '- .... .. ... / .. ... / .--- ..- ... - / .- / - . ... - -.-.-- ',
            $morse->dotDash('1 0000 00 000 / 00 000 / 0111 001 000 1 / 01 / 1 0 000 1 101011 ')
        );
    }
}
