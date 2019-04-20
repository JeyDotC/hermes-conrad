<?php

namespace Hermes\Bureau\Services;

use Hermes\Bureau\Form;
use Hermes\Bureau\Process;

/**
 *
 * @author jguevara
 */
interface IBureaucratService
{
    public function shouldBeExecuted(Form $task, Process $process);
    
    public function execute(Form $task, Process $process);
}
