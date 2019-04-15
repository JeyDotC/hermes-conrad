<?php

namespace Hermes\Factories\Decorators;

use Hermes\Events\OfficerFailedEvent;
use Hermes\Factories\IBureocratProcedureRunnerDecorator;
use Hermes\Services\BureocratProcedureRunner;

/**
 * Description of ContinueOnOfficerFailuer
 *
 * @author jguevara
 */
class ContinueOnOfficerFailed implements IBureocratProcedureRunnerDecorator
{
    
    public function decorate(BureocratProcedureRunner $runner) {
        $runner->onOfficerFailed(function(OfficerFailedEvent $event){
            $event->setActionToTake(OfficerFailedEvent::CONTINUE_PROCESS);
        });
    }

}
