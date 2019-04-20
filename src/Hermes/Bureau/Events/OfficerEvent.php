<?php

namespace Hermes\Bureau\Events;

use Hermes\Bureau\Form;
use Hermes\Bureau\BureaucratOfficer;
use Hermes\Bureau\Procedure;

/**
 * Description of OfficerEvent
 *
 * @author jguevara
 */
abstract class OfficerEvent extends ProcedureEvent
{

    /**
     *
     * @var BureaucratOfficer
     */
    private $officer;

    /**
     *
     * @var Form
     */
    private $task;

    public function __construct(Procedure $procedure, BureaucratOfficer $officer, Form $task) {
        parent::__construct($procedure); 
        $this->officer = $officer;
        $this->task = $task;
    }

    function getOfficer(): BureaucratOfficer {
        return $this->officer;
    }

    function getTask(): Form {
        return $this->task;
    }

}
