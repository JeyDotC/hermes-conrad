<?php

namespace Hermes\Factories;

use Hermes\Services\BureocratProcedureRunner;

/**
 *
 * @author jguevara
 */
interface IBureocratProcedureRunnerDecorator
{
    public function decorate(BureocratProcedureRunner $runner);
}
