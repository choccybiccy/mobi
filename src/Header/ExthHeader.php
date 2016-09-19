<?php

namespace Choccybiccy\Mobi\Header;

use Choccybiccy\Mobi\Exception\NoSuchRecordException;
use Choccybiccy\Mobi\Header\Record\ExthRecord;

/**
 * Class ExthHeader.
 *
 * @method ExthRecord[] getIterator()
 */
class ExthHeader extends AbstractRecordHeader
{
    const TYPE_AUTHOR = 100;
    const TYPE_PUBLISHER = 102;
    const TYPE_CONTRIBUTOR = 108;
    const TYPE_UPDATEDTITLE = 503;

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
        $this->length = $length;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $type
     *
     * @return mixed
     * 
     * @throws NoSuchRecordException
     */
    public function getRecordByType($type)
    {
        $iterator = $this->getIterator();
        foreach ($iterator as $record) {
            if ($type == $record->getType()) {
                return $record->getData();
            }
        }
        throw new NoSuchRecordException('No such EXTH record matching type ' . $type . ' found');
    }
}
