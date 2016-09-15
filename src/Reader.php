<?php

namespace Choccybiccy\Mobi;

use Choccybiccy\Mobi\Exception\InvalidFormatException;
use Choccybiccy\Mobi\Header\ExthHeader;
use Choccybiccy\Mobi\Header\MobiHeader;
use Choccybiccy\Mobi\Header\PalmDbHeader;
use Choccybiccy\Mobi\Header\PalmDocHeader;
use Choccybiccy\Mobi\Header\Record\ExthRecord;
use Choccybiccy\Mobi\Header\Record\PalmRecord;

/**
 * Class Reader.
 */
class Reader
{
    /**
     * @var \SplFileObject
     */
    protected $file;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var PalmDbHeader
     */
    protected $palmDbHeader;

    /**
     * @var int
     */
    protected $palmDbHeaderStart = 76;

    /**
     * @var PalmDocHeader
     */
    protected $palmDocHeader;

    /**
     * @var int
     */
    protected $palmDocHeaderStart;

    /**
     * @var MobiHeader
     */
    protected $mobiHeader;

    /**
     * @var int
     */
    protected $mobiHeaderStart;

    /**
     * @var ExthHeader
     */
    protected $exthHeader;

    /**
     * Reader constructor.
     * @param string|\SplFileObject $file
     */
    public function __construct($file)
    {
        if (is_string($file)) {
            $file = new \SplFileObject($file, "r");
        }
        $this->file = $file;
        $this->parse();
    }

    /**
     * Parse the file data
     */
    protected function parse()
    {
        $file = $this->file;
        $file->fseek(60);
        $content = $file->fread(8);
        if ($content !== 'BOOKMOBI') {
            throw new InvalidFormatException('The file is not a valid mobi file');
        }
        $this->parsePalmDb();
        $this->parsePalmDoc();
        $this->parseMobiHeader();
        $this->parseExth();
    }

    /**
     * Parse the PalmDb records from the file.
     */
    protected function parsePalmDb()
    {
        $file = $this->file;
        $file->fseek($this->palmDbHeaderStart);
        $content = $file->fread(2);
        $records = hexdec(bin2hex($content));

        $this->palmDbHeader = new PalmDbHeader();
        $file->fseek(78);
        for ($i=0; $i<$records; $i++) {
            $this->palmDbHeader->addRecord(new PalmRecord(
                $this->readData($file, 4),
                $this->readData($file, 1),
                $this->readData($file, 3)
            ));
        }
    }

    /**
     * Parse the PalmDoc header from the file.
     */
    protected function parsePalmDoc()
    {
        if (!$this->palmDbHeader) {
            return;
        }
        $file = $this->file;
        /** @var PalmRecord $firstPalmDbRecord */
        $firstPalmDbRecord = $this->palmDbHeader->getIterator()->offsetGet(0);
        $offset = $firstPalmDbRecord->getOffset();
        $this->palmDocHeaderStart = $offset;
        $file->fseek($offset);
        $this->palmDocHeader = new PalmDocHeader(
            $this->readData($file, 2),
            $this->readData($file, 4, $offset+4),
            $this->readData($file, 2),
            $this->readData($file, 2)
        );
    }

    /**
     * Parse the MOBI header from the file.
     */
    protected function parseMobiHeader()
    {
        if (!$this->palmDocHeader) {
            return;
        }
        $file = $this->file;
        $this->mobiHeaderStart = $file->ftell()+4;
        $file->fseek($this->mobiHeaderStart);
        if ($file->fread(4) === 'MOBI') {
            $this->mobiHeader = new MobiHeader(
                $this->readData($file, 4),
                $this->readData($file, 4),
                $this->readData($file, 4),
                $this->readData($file, 4),
                $this->readData($file, 4)
            );
        }
    }

    /**
     * Parse EXTH header from the file.
     */
    protected function parseExth()
    {
        if (!$this->mobiHeader) {
            return;
        }
        $file = $this->file;
        $file->fseek($this->mobiHeaderStart + $this->mobiHeader->getLength());
        $this->exthHeader = new ExthHeader($this->readData($file, 4));
        $records = $this->readData($file, 4);
        for ($i=0; $i<$records; $i++) {
            
        }
    }

    /**
     * @param \SplFileObject $file
     * @param int $length
     * @param int|null $seek
     *
     * @return number
     */
    protected function readData(\SplFileObject &$file, $length, $seek = null)
    {
        if (is_int($seek)) {
            $file->fseek($seek);
        }
        return hexdec(bin2hex($file->fread($length)));
    }

    /**
     * @param \SplFileObject $file
     * @return static
     */
    public function createFromFileObject(\SplFileObject $file)
    {
        return new static($file);
    }

    /**
     * Validate and return a string.
     *
     * @param $string
     *
     * @return string
     */
    public static function validateString($string)
    {
        if (is_string($string) || (is_object($string) && method_exists($string, '__toString'))) {
            return (string) $string;
        }
        throw new \InvalidArgumentException('Expected data must either be a string or stringable');
    }
}

