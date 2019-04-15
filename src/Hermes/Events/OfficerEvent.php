<?php

namespace Hermes\Events;

use Hermes\Entities\BoringTask;
use Hermes\Entities\BureocratOfficer;
use Hermes\Entities\InProgressProcedure;

/**
 * Description of OfficerEvent
 *
 * @author jguevara
 */
abstract class OfficerEvent extends ProcedureEvent
{

    /**
     *
     * @var BureocratOfficer
     */
    private $officer;

    /**
     *
     * @var BoringTask
     */
    private $task;

    public function __construct(InProgressProcedure $procedure, BureocratOfficer $officer, BoringTask $task) {
        parent::__construct($procedure); 
        $this->officer = $officer;
        $this->task = $task;
    }

    function getOfficer(): BureocratOfficer {
        return $this->officer;
    }

    function getTask(): BoringTask {
        return $this->task;
    }

}
