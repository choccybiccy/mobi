<?php

namespace Choccybiccy\Mobi\Header;

/**
 * Class PalmDocHeader.
 */
class PalmDocHeader
{
    const COMPRESSION_NONE = 1;
    const COMPRESSION_PALMDOC = 2;
    const COMPRESSION_HUFFCDIC = 17480;

    /**
     * @var int
     */
    protected $compression;

    /**
     * @var int
     */
    protected $textLength;

    /**
     * @var int
     */
    protected $recordCount;

    /**
     * @var int
     */
    protected $recordSize;

    /**
     * PalmDoc constructor.
     * @param int $compression
     * @param int $textLength
     * @param int $recordCount
     * @param int $recordSize
     */
    public function __construct($compression, $textLength, $recordCount, $recordSize)
    {
        $this->compression = $compression;
        $this->textLength = $textLength;
        $this->recordCount = $recordCount;
        $this->recordSize = $recordSize;
    }

    /**
     * @return int
     */
    public function getCompression()
    {
        return $this->compression;
    }

    /**
     * @return int
     */
    public function getTextLength()
    {
        return $this->textLength;
    }

    /**
     * @return int
     */
    public function getRecordCount()
    {
        return $this->recordCount;
    }

    /**
     * @return int
     */
    public function getRecordSize()
    {
        return $this->recordSize;
    }
}
