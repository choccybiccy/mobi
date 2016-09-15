<?php

namespace Choccybiccy\Mobi\Header;

use Choccybiccy\Mobi\Header\Record\ExthRecord;

/**
 * Class ExthHeader.
 *
 * @method ExthRecord[] getIterator()
 */
class ExthHeader extends AbstractRecordHeader
{
    /**
     * @var int
     */
    protected $length;

    /**
     * ExthHeader constructor.
     * @param int $length
     * @param array $records
     */
    public function __construct($length, array $records = [])
    {
        parent::__construct($records);
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }
}
