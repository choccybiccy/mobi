<?php

namespace Choccybiccy\Mobi;

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
     * Reader constructor.
     * @param string|\SplFileObject $file
     */
    public function __construct($file)
    {
        if (is_string($file)) {
            $file = new \SplFileObject($file, "r");
        }
        $this->file = $file;
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

