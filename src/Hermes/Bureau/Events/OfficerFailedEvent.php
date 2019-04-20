<?php

namespace Hermes\Bureau\Events;

use Exception;
use Hermes\Bureau\Form;
use Hermes\Bureau\BureaucratOfficer;
use Hermes\Bureau\Procedure;

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

    public function __construct(\Exception $exception, Procedure $procedure, BureaucratOfficer $officer, Form $task) {
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
