<?php

namespace jblond\morse;

use Exception;
use RuntimeException;

/**
 * Inspired by http://www.codeproject.com/Articles/85339/Morse-Code-Generation-from-Text
 */
class Wave
{
    /**
     *
     */
    protected const dot = '.';
    /**
     *
     */
    protected const dash = '-';
    /**
     *
     */
    protected const pause = '/';

    /**
     * @var int
     */
    protected int $sampleRate = 11050;
    /**
     * @var float
     */
    protected float $twoPi = 6.283185307;
    /**
     * @var float|int
     */
    protected float|int $cwSpeed = 30;
    /**
     * @var float|int
     */
    protected float|int $frequency = 700;

    /**
     * @var float|int
     */
    protected float|int $phase = 0;
    /**
     * @var float|int
     */
    protected float|int $dPhase = 0;

    /**
     * @var array
     */
    protected array $bytes = [];

    /**
     * @var float
     */
    protected float $toneTime;

    /**
     * @var float
     */
    protected float $dotTime;

    /**
     * @var float
     */
    protected float $charsPc;

    /**
     * @var float
     */
    protected float $wordsPc;

    /**
     * @var float
     */
    protected float $dashTime;

    /**
     * @var float
     */
    protected float $sampleDt;

    /**
     * @var Morse
     */
    protected Morse $characters;

    /**
     *
     */
    public function __construct()
    {
        $this->characters = new Morse();
    }

    /**
     * @throws Exception
     */
    public function setCwSpeed($speed): static
    {
        if (!is_numeric($speed)) {
            throw new RuntimeException('$Speed must be numeric');
        }

        $this->cwSpeed = $speed;
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

        $this->frequency = $frequency;
        return $this;
    }

    /**
     * @param $text
     * @return string
     */
    public function generate($text): string
    {
        $this->reset();

        $this->toneTime = 1.0 / $this->frequency; // sec per wavelength
        if ($this->cwSpeed < 15) {
            // use Farnsworth spacing
            $this->dotTime = 1.145 / 15.0;
            $this->charsPc = 122.5 / $this->cwSpeed - 31.0 / 6.0;
        } else {
            $this->dotTime = 1.145 / $this->cwSpeed;
            $this->charsPc = 3;
        }

        $this->wordsPc = floor(2 * $this->charsPc + 0.5);
        $this->dashTime = 3 * $this->dotTime;
        $this->sampleDt = 1.0 / $this->sampleRate;
        $this->phase = 0;
        $this->dPhase = 0;
        //$this->slash = false;

        $this->oscReset();

        $dit = 0;
        while ($dit < $this->dotTime) {
            $x = $this->osc();
            // The dit and dah sound both rise during the first half dit-time
            if ($dit < (0.5 * $this->dotTime)) {
                $x *= sin((M_PI / 2.0) * $dit / (0.5 * $this->dotTime));
                $this->bytes[self::dot] .= chr(floor(120 * $x + 128));
                $this->bytes[self::dash] .= chr(floor(120 * $x + 128));
            } else if ($dit > (0.5 * $this->dotTime)) {
                // During the second half dit-time, the dit sound decays
                // but the dah sound stays constant
                $this->bytes[self::dash] .= chr(floor(120 * $x + 128));
                $x *= sin((M_PI / 2.0) * ($this->dotTime - $dit) / (0.5 * $this->dotTime));
                $this->bytes[self::dot] .= chr(floor(120 * $x + 128));
            } else {
                $this->bytes[self::dot] .= chr(floor(120 * $x + 128));
                $this->bytes[self::dash] .= chr(floor(120 * $x + 128));
            }
            $this->bytes[self::pause] .= chr(128);
            $dit += $this->sampleDt;
        }

        // At this point the dit ans space sound have been generated
        // During the next dit-time, the dah sound amplitude is constant
        $dit = 0;
        while ($dit < $this->dotTime) {
            $x = $this->osc();
            $this->bytes[self::dash] .= chr(floor(120 * $x + 128));
            $dit += $this->sampleDt;
        }

        // During the 3rd dit-time, the dah-sound has a constant amplitude
        // then decays during that last half dit-time
        $dit = 0;
        while ($dit < $this->dotTime) {
            $x = $this->osc();
            if ($dit > (0.5 * $this->dotTime)) {
                $x *= sin((M_PI / 2.0) * ($this->dotTime - $dit) / (0.5 * $this->dotTime));
            }
            $this->bytes[self::dash] .= chr(floor(120 * $x + 128));
            $dit += $this->sampleDt;
        }

        // Convert the text to morse code string
        $text = strtoupper($text);
        $sound = '';
        for ($i = 0, $iMax = strlen($text); $i < $iMax; $i++) {
            if ($text[$i] === ' ') {
                $sound .= str_repeat($this->bytes[self::pause], $this->wordsPc);
            } else {
                $xChar = $this->characters->getCharacter($i);

                for ($k = 0, $kMax = strlen($xChar); $k < $kMax; $k++) {
                    if ($xChar[$k] === '0') {
                        $sound .= $this->bytes[self::dot];
                    } else {
                        $sound .= $this->bytes[self::dash];
                    }
                    $sound .= $this->bytes[self::pause];
                }

                for ($j = 1; $j < $this->charsPc; $j++) {
                    $sound .= $this->bytes[self::pause];
                }
            }
        }

        $n = strlen($sound);

        // Write out the WAVE file
        $x = $n + 32;
        $soundSize = '';

        for ($i = 0; $i < 4; $i++) {
            $soundSize .= chr($x % 256);
            $x = floor($x / 256);
        }

        $riffHeader = 'RIFF' . $soundSize . 'WAVE';
        $x = $this->sampleRate;
        $sampleRateString = '';

        for ($i = 0; $i < 4; $i++) {
            $sampleRateString .= chr($x % 256);
            $x = floor($x / 256);
        }

        $headerString = 'fmt ' . chr(16) . chr(0) . chr(0) . chr(0) . chr(1) . chr(0) . chr(1) . chr(0);
        $headerString .= $sampleRateString . $sampleRateString . chr(1) . chr(0) . chr(8) . chr(0);
        $x = $n;
        $sampleString = '';

        for ($i = 0; $i < 4; $i++) {
            $sampleString .= chr($x % 256);
            $x = floor($x / 256);
        }

        $sound = 'data' . $sampleString . $sound;
        return $riffHeader . $headerString . $sound;
    }

    /**
     * @return float
     */
    protected function osc(): float
    {
        $this->phase += $this->dPhase;
        if ($this->phase >= $this->twoPi) {
            $this->phase -= $this->twoPi;
        }
        return sin($this->phase);
    }

    /**
     * @return void
     */
    protected function oscReset(): void
    {
        $this->phase = 0;
        $this->dPhase = $this->twoPi * $this->sampleDt / $this->toneTime;
    }

    /**
     * @return void
     */
    protected function reset(): void
    {
        $this->bytes = [
            self::dot => '',
            self::dash => '',
            self::pause => ''
        ];
    }
}
