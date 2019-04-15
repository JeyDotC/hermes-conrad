<?php

namespace Hermes\ValueObjects;

/**
 * Description of Stamp
 *
 * @author jguevara
 */
final class Stamp
{

    const STATUS_NOT_STARTED = 'not_started';
    const STATUS_STARTED = 'started';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED_RESUMABLE = 'failed_resumable';
    const STATUS_STAND_BY = 'stand_by';
    const STATUS_DELEGATED = 'delegated';
    const STATUS_ERROR = 'error';

    private $timeStamp;
    private $status;
    private $notes;

    public static function empty() {
        return new Stamp(0, self::STATUS_NOT_STARTED);
    }

    public function __construct(int $timeStamp, $status, $notes = '') {
        $this->timeStamp = $timeStamp;
        $this->status = $status;
        $this->notes = $notes;
    }

    public function getTimeStamp(): int {
        return $this->timeStamp;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getNotes() {
        return $this->notes;
    }

}
