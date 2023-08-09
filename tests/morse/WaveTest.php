<?php

namespace jblond\morse;

use Exception;
use finfo;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 *
 */
class WaveTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        if (!extension_loaded('fileinfo')) {
            throw new RuntimeException('The File info extension is not available');
        }
    }

    /**
     * @return void
     */
    public function testCanGenerateValidWav(): void
    {
        $wav = new Wave();
        $output = $wav->generate('Hoc est temptare');

        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $fileInfo->buffer($output);

        $this->assertEquals('audio/x-wav', $mime);
    }

    /**
     * @throws Exception
     */
    public function testCanSetCwSpeed(): void
    {
        $wav = (new Wave())->setCwSpeed(10);
        $output = $wav->generate('Hoc est temptare');

        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $fileInfo->buffer($output);
        $this->assertEquals('audio/x-wav', $mime);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testThrowsIfInvalidCwSpeedSet(): void
    {
        $this->expectExceptionMessage("Speed must be numeric");
        $this->expectException(Exception::class);
        (new Wave())->setCwSpeed('foo');
    }

    /**
     * @covers \jblond\morse\Wave
     * @throws Exception
     */
    public function testCanSetSampleRate(): void
    {
        $wav = (new Wave())->setSampleRate(8000);
        $output = $wav->generate('Hoc est temptare');

        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $fileInfo->buffer($output);

        $this->assertEquals('audio/x-wav', $mime);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testThrowsIfInvalidSampleRateSet(): void
    {
        $this->expectExceptionMessage("Sample rate must be numeric");
        $this->expectException(Exception::class);
        (new Wave())->setSampleRate('foo');
    }

    /**
     * @throws Exception
     */
    public function testCanSetFrequency(): void
    {
        $wav = (new Wave())->setFrequency(8000);
        $output = $wav->generate('Hoc est temptare');

        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $fileInfo->buffer($output);

        $this->assertEquals('audio/x-wav', $mime);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testThrowsIfInvalidFrequencySet(): void
    {
        $this->expectExceptionMessage("Frequency must be numeric");
        $this->expectException(Exception::class);
        (new Wave())->setFrequency('foo');
    }

    /**
     * @throws Exception
     */
    public function testCanGenerateLongerValidWav(): void
    {
        $wav = new Wave();
        $output = $wav->setFrequency(100)->generate($this->getSampleText());
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $fileInfo->buffer($output);

        $this->assertEquals('audio/x-wav', $mime);
    }

    /**
     * @return string
     */
    protected function getSampleText(): string
    {
        return (
            'tecta perstillantia in die frigoris et litigiosa mulier conparantur' .
            'qui retinet eam quasi qui ventum teneat et oleum dexterae suae vocabit.' .
            'melius est habitare in terra deserta quam cum muliere rixosa et iracunda. ' .
            'quod si invicem mordetis et comeditis videte ne ab invicem consumamini. ' .
            'si habuerint inter se iurgium viri et unus contra alterum rixari coeperit' .
            'volensque uxor alterius eruere virum suum de manu fortioris miserit manum' .
            ' et adprehenderit verenda eius. '
        );
    }
}
