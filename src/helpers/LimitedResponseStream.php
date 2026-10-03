<?php
namespace verbb\consume\helpers;

use verbb\consume\exceptions\ResponseTooLargeException;

use GuzzleHttp\Psr7\StreamDecoratorTrait;
use Psr\Http\Message\StreamInterface;

class LimitedResponseStream implements StreamInterface
{
    // Traits
    // =========================================================================

    use StreamDecoratorTrait;


    // Properties
    // =========================================================================

    private StreamInterface $stream;
    private int $maximumBytes;
    private int $bytesWritten = 0;
    private int $maximumReadPosition;
    private bool $validateExistingSize;


    // Public Methods
    // =========================================================================

    public function __construct(StreamInterface $stream, int $maximumBytes, bool $validateExistingSize = true)
    {
        $this->stream = $stream;
        $this->maximumBytes = $maximumBytes;
        $this->validateExistingSize = $validateExistingSize;
        $this->maximumReadPosition = $validateExistingSize ? $maximumBytes : $stream->tell() + $maximumBytes;

        if ($validateExistingSize && ($size = $stream->getSize()) !== null && $size > $this->maximumBytes) {
            $this->_throwResponseTooLarge();
        }
    }

    public function getSize(): ?int
    {
        if (!$this->validateExistingSize) {
            return $this->bytesWritten;
        }

        return $this->stream->getSize();
    }

    public function enforcesMaximumBytes(int $maximumBytes): bool
    {
        return $this->maximumBytes <= $maximumBytes;
    }

    public function read($length): string
    {
        $remaining = $this->maximumReadPosition - $this->stream->tell();
        $contents = $remaining > 0 ? $this->stream->read(min($length, $remaining)) : '';

        // Probe once at the boundary so a one-shot read cannot silently truncate an oversized body.
        if ($this->stream->tell() >= $this->maximumReadPosition && $this->stream->read(1) !== '') {
            $this->_throwResponseTooLarge();
        }

        return $contents;
    }

    public function write($string): int
    {
        if ($this->bytesWritten + strlen($string) > $this->maximumBytes) {
            $this->_throwResponseTooLarge();
        }

        $written = $this->stream->write($string);
        $this->bytesWritten += $written;

        return $written;
    }


    // Private Methods
    // =========================================================================

    private function _throwResponseTooLarge(): never
    {
        throw new ResponseTooLargeException(sprintf('Response exceeded the %d-byte limit.', $this->maximumBytes));
    }
}
