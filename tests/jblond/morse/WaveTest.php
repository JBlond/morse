<?php

namespace jblond\morse;

use Exception;
use finfo;
use PHPUnit\Framework\TestCase;
use RuntimeException;

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

    public function testCanGenerateValidWav(): void
    {
        $wav = new Wave();
        $output = $wav->generate('Espen');

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
        $output = $wav->generate('Espen');

        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $fileInfo->buffer($output);
        $this->assertEquals('audio/x-wav', $mime);
    }

    public function testThrowsIfInvalidCwSpeedSet(): void
    {
        $this->expectExceptionMessage("Speed must be numeric");
        $this->expectException(Exception::class);
        (new Wave())->setCwSpeed('foo');
    }

    /**
     * @throws Exception
     */
    public function testCanSetSampleRate(): void
    {
        $wav = (new Wave())->setSampleRate(8000);
        $output = $wav->generate('Espen');

        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $fileInfo->buffer($output);

        $this->assertEquals('audio/x-wav', $mime);
    }

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
        $output = $wav->generate('Espen');

        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $fileInfo->buffer($output);

        $this->assertEquals('audio/x-wav', $mime);
    }

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
        $output = $wav->setFrequency(100)->generate($this->getLoremIpsum());
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $fileInfo->buffer($output);

        $this->assertEquals('audio/x-wav', $mime);
    }

    protected function getLoremIpsum(): string
    {
        return (
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ' .
            'Duis sed dignissim arcu. Etiam non euismod nulla. ' .
            'Cras non sagittis velit. Donec et imperdiet ipsum. ' .
            'Fusce vel enim ut neque pellentesque congue. ' .
            'Nunc posuere vitae justo eu dignissim. ' .
            'Sed eget nunc sed massa auctor posuere. ' .
            'Etiam condimentum ullamcorper tellus, et tempor nisl aliquet a.' .
            'Nulla finibus ut nulla eu rhoncus.'
        );
    }
}
