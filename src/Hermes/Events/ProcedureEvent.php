<?php

namespace Hermes\Events;

use Hermes\Entities\InProgressProcedure;

/**
 * Description of ProcedureEvent
 *
 * @author jguevara
 */
abstract class ProcedureEvent
{

    /**
     *
     * @var InProgressProcedure
     */
    private $procedure;

    public function __construct(InProgressProcedure $procedure) {
        $this->procedure = $procedure;
    }

    public function getProcedure(): InProgressProcedure {
        return $this->procedure;
    }
}
