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
     * @covers \jblond\morse\CharacterSet\Latin
     * @covers \jblond\morse\CharacterSet\Thai
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
     * @covers \jblond\morse\CharacterSet\Latin
     * @covers \jblond\morse\CharacterSet\Thai
     * @return void
     */
    public function testGetLetters(): void
    {
        $morse = new Morse();
        $this->assertEquals(
            [
                'Latin',
                [
                    // Latin => https://en.wikipedia.org/wiki/Morse_code
                    '01' => 'A', '1000' => 'B', '1010' => 'C', '100' => 'D', '0' => 'E', '0010' => 'F',
                    '110' => 'G', '0000' => 'H', '00' => 'I', '0111' => 'J', '101' => 'K', '0100' => 'L',
                    '11' => 'M', '10' => 'N', '111' => 'O', '0110' => 'P', '1101' => 'Q', '010' => 'R',
                    '000' => 'S', '1' => 'T', '001' => 'U', '0001' => 'V', '011' => 'W', '1001' => 'X',
                    '1011' => 'Y', '1100' => 'Z',
                    '11111' => '0', '01111' => '1', '00111' => '2', '00011' => '3', '00001' => '4',
                    '00000' => '5', '10000' => '6', '11000' => '7', '11100' => '8', '11110' => '9',
                    '010101' => '.', '110011' => ',', '001100' => '?',
                    '011110' => '\'', '101011' => '!', '10010' => '/',
                    '10110' => '(', '101101' => ')', '01000' => '&', '111000' => ':', '101010' => ';', '10001' => '=',
                    '01010' => '+', '100001' => '-', '001101' => '_',
                    '010010' => '"', '0001001' => '$', '011010' => '@',
                    '00101' => '¿', '110001' => '¡',
                    'Ã' => '01101', '01101' => 'Á', 'Å' => '01101', 'À' => '01101', 'Â' => '01101', '0101' => 'Ä',
                    'Ç' => '10100', 'Ć' => '10100', 'Ĉ' => '10100', 'Č' => '110',
                    '00110' => 'Ð', '00100' => 'É',
                    '11010' => 'Ğ', '1111' => 'Ĥ', '01110' => 'Ì', '01001' => 'Ł', '11011' => 'Ñ', 'Ö' => '1110',
                    '0001000' => 'Ś', '01100' => 'Ş', '00010' => 'Ŝ', '0001100' => 'ß', '0011' => 'Ü',
                    '11001' => 'Ż',
                ],
                'Thai',
                [
                    '10' => 'ก', '1010' => 'ข', '101' => 'ค', '10110' => 'ง', '10010' => 'จ',
                    '1111' => 'ฉ', '1001' => 'ช', '1100' => 'ซ', '0111' => 'ญ', '100' => 'ด',
                    '1' => 'ต', '10100' => 'ถ', '10011' => 'ท', '1000' => 'บ',
                    '0110' => 'ป', '1101' => 'ผ', '10101' => 'ฝ', '01100' => 'พ', '0010' => 'ฟ',
                    '11' => 'ม', '1011' => 'ย', '010' => 'ร', '0100' => 'ล', '011' => 'ว',
                    '000' => 'ส', '0000' => 'ห', '10001' => 'อ', '11011' => 'ฮ', '01011' => 'ฤ',
                    '01000' => 'ะ', '01' => 'า', '00100' => 'ิ', '00' => 'ี', '00110' => 'ึ',
                    '0011' => 'ื', '00101' => 'ุ', '1110' => 'ู', '0' => 'เ', '0101' => 'แ',
                    '01001' => 'ไ', '111' => 'โ', '00010' => 'ำ', '001' => '่', '0001' => '้',
                    '11000' => '๊', '01010' => '๋', '01101' => 'ั', '11100' => '็', '11001' => '์',
                    '10111' => 'ๆ', '11010' => 'ฯ',
                ]
            ],
            [
                $morse->setLetters(),
                $morse->getLetters(),
                $morse->setLetters('Thai'),
                $morse->getLetters()
            ]
        );
    }
    /**
     * @covers \jblond\morse\Morse
     * @covers \jblond\morse\CharacterSet\Latin
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
     * @covers \jblond\morse\CharacterSet\Japanese
     * @covers \jblond\morse\CharacterSet\Latin
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
     * @covers \jblond\morse\CharacterSet\Greek
     * @covers \jblond\morse\CharacterSet\Latin
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
     * @covers \jblond\morse\CharacterSet\Cyrillic
     * @covers \jblond\morse\CharacterSet\Latin
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
     * @covers \jblond\morse\CharacterSet\Arabic
     * @covers \jblond\morse\CharacterSet\Latin
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
     * @covers \jblond\morse\CharacterSet\Hebrew
     * @covers \jblond\morse\CharacterSet\Latin
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
     * @covers \jblond\morse\CharacterSet\Korean
     * @covers \jblond\morse\CharacterSet\Latin
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
     * @covers \jblond\morse\CharacterSet\Persian
     * @covers \jblond\morse\CharacterSet\Latin
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
     * @covers \jblond\morse\CharacterSet\Thai
     * @covers \jblond\morse\CharacterSet\Latin
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
     * @covers \jblond\morse\CharacterSet\Latin
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
