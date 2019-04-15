<?php

namespace Hermes\Services;

use Hermes\Entities\BoringTask;
use Hermes\Entities\BureocratProcess;

/**
 *
 * @author jguevara
 */
interface IBureocratService
{
    public function shouldBeExecuted(BoringTask $task, BureocratProcess $process);
    
    public function execute(BoringTask $task, BureocratProcess $process);
}
