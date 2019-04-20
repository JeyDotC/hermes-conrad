<?php

namespace Hermes\Bureau\Factories\Decorators;

use Hermes\Bureau\Events\OfficerFailedEvent;
use Hermes\Bureau\Factories\IBureaucratProcedureRunnerDecorator;
use Hermes\Bureau\Services\BureaucratProcedureRunner;

/**
 * Description of ContinueOnOfficerFailuer
 *
 * @author jguevara
 */
class ContinueOnOfficerFailed implements IBureaucratProcedureRunnerDecorator
{
    
    public function decorate(BureaucratProcedureRunner $runner) {
        $runner->onOfficerFailed(function(OfficerFailedEvent $event){
            $event->setActionToTake(OfficerFailedEvent::CONTINUE_PROCESS);
        });
    }

}
