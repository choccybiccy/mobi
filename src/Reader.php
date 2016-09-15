<?php

namespace Choccybiccy\Mobi;

use Choccybiccy\Mobi\Exception\InvalidFormatException;
use Choccybiccy\Mobi\Header\PalmDb;
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
     * @var PalmDb
     */
    protected $palmDb;

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
        $this->palmDb = new PalmDb();
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

        $file->fseek(76);
        $content = $file->fread(2);
        $records = hexdec(bin2hex($content));

        $file->fseek(78);
        for ($i=0; $i<$records; $i++) {
            $this->palmDb->addRecord(new PalmRecord(
                hexdec(bin2hex($file->fread(4))),
                hexdec(bin2hex($file->fread(1))),
                hexdec(bin2hex($file->fread(3)))
            ));
        }
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

