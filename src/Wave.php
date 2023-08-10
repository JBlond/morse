<?php

declare(strict_types=1);

namespace jblond\morse;

use Exception;
use RuntimeException;

/**
 * Inspired by http://www.codeproject.com/Articles/85339/Morse-Code-Generation-from-Text
 */
class Wave
{
    /**
     * 8-bit sound generated at a rate of 11050 samples/second
     * @var int $sampleRate
     */
    protected int $sampleRate = 11050;
    /**
     * roughly two times PI
     * float
     */
    protected const TWO_PI = 6.283185307;
    /**
     * @var int $wordPerMinute (cw speed)
     */
    protected int $wordPerMinute = 25;
    /**
     * @var int $audioFrequency (cw tone)
     */
    protected int $audioFrequency = 700;

    /**
     * @var float|int
     */
    protected float|int $phase = 0;
    /**
     * @var float|int
     */
    protected float|int $dPhase;
    /**
     * @var float $toneTime seconds per wavelength
     */
    protected float $toneTime;

    /**
     * @var float $dotTime (dit time)
     */
    protected float $dotTime;

    /**
     * @var float|int
     */
    protected float|int $characterSpace = 3;

    /**
     * @var float
     */
    protected float $wordSpace;

    /**
     * @var float $dashTime (dah time)
     */
    protected float $dashTime;

    /**
     * @var float
     */
    protected float $sampleDelayTime;

    /**
     * @var Morse
     */
    protected Morse $morse;

    /**
     *
     */
    public function __construct()
    {
        $this->morse = new Morse();
    }

    /**
     * @throws Exception
     */
    public function setCwSpeed($speed): static
    {
        if (!is_numeric($speed)) {
            throw new RuntimeException('$Speed must be numeric');
        }
        if ($speed < 1) {
            $speed = 15;
        }

        $this->wordPerMinute = $speed;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function setSampleRate($rate): static
    {
        if (!is_numeric($rate)) {
            throw new RuntimeException('Sample rate must be numeric');
        }

        $this->sampleRate = $rate;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function setFrequency($frequency): static
    {
        if (!is_numeric($frequency)) {
            throw new RuntimeException('Frequency must be numeric');
        }

        $this->audioFrequency = $frequency;
        return $this;
    }

    /**
     * @param string $text
     * @return string
     */
    public function generate(string $text): string
    {

        $this->toneTime = 1.0 / $this->audioFrequency; // seconds per wavelength
        if ($this->wordPerMinute < 15) {
            $this->dotTime = 1.145 / 15; //sec
            $this->characterSpace = (122.5 / $this->wordPerMinute) - (31 / 6);
        } else {
            $this->dotTime = 1.145 / $this->wordPerMinute;
        }

        $this->wordSpace = floor(2 * $this->characterSpace + 0.5);
        $this->dashTime = 3 * $this->dotTime; // seconds
        $this->sampleDelayTime = 1 / $this->sampleRate;
        $this->oscReset();
        $dt = 0;
        $dotString = '';
        $dashString = '';
        $spaceString = '';

        while ($dt < $this->dotTime) {
            $osc = $this->osc();
            // The dit and dah sound both rise during the first half dit-time
            if ($dt < (0.5 * $this->dotTime)) {
                $osc *= sin((M_PI / 2) * $dt / (0.5 * $this->dotTime));
                $dotString .= chr((int) floor(120 * $osc + 128));
                $dashString .= chr((int) floor(120 * $osc + 128));
            } else {
                // During the second half dit-time, the dit sound decays
                // but the dah sound stays constant
                $dashString .= chr((int) floor(120 * $osc + 128));
                $osc *= sin((M_PI / 2) * ($this->dotTime - $dt) / (0.5 * $this->dotTime));
                $dotString .= chr((int) floor(120 * $osc + 128));
            }
            $spaceString .= chr(128);
            $dt += $this->sampleDelayTime;
        }

        // At this point the dit and space sound have been generated
        // During the next dit-time, the dah sound amplitude is constant
        $dt = 0;
        while ($dt < $this->dotTime) {
            $osc = $this->osc();
            $dashString .= chr((int) floor(120 * $osc + 128));
            $dt += $this->sampleDelayTime;
        }

        // During the 3rd dit-time, the dah-sound has a constant amplitude
        // then decays during that last half dit-time
        $dt = 0;
        while ($dt < $this->dotTime) {
            $osc = $this->osc();
            if ($dt > (0.5 * $this->dotTime)) {
                $osc *= sin(M_PI / 2) * ($this->dotTime - $dt) / (0.5 * $this->dotTime);
            }
            $dashString .= chr((int) floor(120 * $osc + 128));
            $dt += $this->sampleDelayTime;
        }
        // convert the text to CW code string in $soundString[]
        $soundString = $this->convertTextToMorseCode($text, $spaceString, $dotString, $dashString);
        return $this->riffWave($soundString);
    }

    protected function convertTextToMorseCode($text, $spaceString, $dotString, $dashString): string
    {
        $soundString = '';
        $stringLength = strlen($text);
        for ($i = 0; $i < $stringLength; $i++) {
            $xChar = trim($this->morse->getCharacter($text[$i]));
            if ($text[$i] === ' ') {
                $soundString .= $spaceString;
            } elseif ($xChar !== '#') {
                $xCharLen = strlen($xChar);
                for ($k = 0; $k < $xCharLen; $k++) {
                    if ($xChar[$k] === '0' || $xChar[$k] === 0) {
                        $soundString .= $dotString;
                    } else {
                        $soundString .= $dashString;
                    }
                    $soundString .= $spaceString;
                }
                for ($j = 1; $j < $this->characterSpace; $j++) {
                    $soundString .= $spaceString;
                }
            }
        }
        return $soundString;
    }

    protected function riffWave($soundString): string
    {
        $soundStringLength = strlen($soundString);

        $x = $soundStringLength + 32;
        $soundSize = '';
        for ($i = 0; $i < 4; $i++) {
            $soundSize .= chr($x % 256);
            $x = floor($x / 256);
        }

        $riffHeader = 'RIFF' . $soundSize . 'WAVE';
        $sampRateStr = '';
        $x = $this->sampleRate;
        for ($i = 0; $i < 4; $i++) {
            $sampRateStr .= chr($x % 256);
            $x = floor($x / 256);
        }
        /*
         * The first chunk, in our case, consists of the format specifier that begins with the ASCII characters
         * fmt followed by a 4-byte chunk size that is equal to 16, 18, or 40,
         * depending on the sound encoding format used. In this application, I use plain vanilla PCM format,
         * so the chunk size is always 16 bytes and the required data is the number of channels,
         * sound samples/second, average bytes/second, a block align indicator, and the number of bits/sound sample.
         */
        $headerString = 'fmt ' . chr(16) . chr(0) . chr(0) . chr(0) . chr(1) .
            chr(0) . chr(1) . chr(0) .
            $sampRateStr . $sampRateStr . chr(1) . chr(0) . chr(8) . chr(0);

        $x = $soundStringLength;
        $nSampleString = '';
        for ($i = 0; $i < 4; $i++) {
            $nSampleString .= chr($x % 256);
            $x = floor($x / 256);
        }
        $soundString = 'data' . $nSampleString . $soundString;
        return $riffHeader . $headerString . $soundString;
    }

    /**
     * @return float
     */
    protected function osc(): float
    {
        $this->phase += $this->dPhase;
        if ($this->phase >= self::TWO_PI) {
            $this->phase -= self::TWO_PI;
        }
        return sin($this->phase);
    }

    /**
     * @return void
     */
    protected function oscReset(): void
    {
        $this->phase = 0;
        $this->dPhase = self::TWO_PI * $this->sampleDelayTime / $this->toneTime;
    }
}
