<?php

namespace Hermes\Bureau\Factories;

use Hermes\Bureau\Services\BureaucratProcedureRunner;

/**
 *
 * @author jguevara
 */
interface IBureaucratProcedureRunnerDecorator
{
    public function decorate(BureaucratProcedureRunner $runner);
}
