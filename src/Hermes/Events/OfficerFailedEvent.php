<?php

namespace Hermes\Events;

use Exception;
use Hermes\Entities\BoringTask;
use Hermes\Entities\BureocratOfficer;
use Hermes\Entities\InProgressProcedure;

/**
 * Description of OfficerFailedEvent
 *
 * @author jguevara
 */
class OfficerFailedEvent extends OfficerEvent
{

    const CONTINUE_PROCESS = 'continue';
    const FAIL = 'fail';
    const FINISH_SILENTLY = 'finish';

    private $exception;
    private $actionToTake = self::FAIL;

    public function __construct(\Exception $exception, InProgressProcedure $procedure, BureocratOfficer $officer, BoringTask $task) {
        parent::__construct($procedure, $officer, $task);
        $this->exception = $exception;
    }

    function getException(): Exception {
        return $this->exception;
    }

    function getActionToTake() {
        return $this->actionToTake;
    }

    function setActionToTake($actionToTake) {
        $this->actionToTake = $actionToTake;
    }

}
