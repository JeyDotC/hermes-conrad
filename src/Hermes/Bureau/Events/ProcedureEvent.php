<?php

namespace Hermes\Bureau\Events;

use Hermes\Bureau\Procedure;

/**
 * Description of ProcedureEvent
 *
 * @author jguevara
 */
abstract class ProcedureEvent
{

    /**
     *
     * @var Procedure
     */
    private $procedure;

    public function __construct(Procedure $procedure) {
        $this->procedure = $procedure;
    }

    public function getProcedure(): Procedure {
        return $this->procedure;
    }
}
