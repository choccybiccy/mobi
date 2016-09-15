<?php

namespace Choccybiccy\Mobi\Header;

use Choccybiccy\Mobi\Header\Record\PalmRecord;

/**
 * Class PalmDb.
 */
class PalmDb implements \IteratorAggregate
{
    /**
     * @var PalmRecord[]
     */
    protected $records = [];

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->records);
    }

    /**
     * @param PalmRecord $record
     */
    public function addRecord(PalmRecord $record)
    {
        $this->records[] = $record;
    }
}
