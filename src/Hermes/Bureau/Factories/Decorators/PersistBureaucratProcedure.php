<?php

namespace Hermes\Bureau\Factories\Decorators;

use Hermes\Bureau\Events\OfficerEvent;
use Hermes\Bureau\Events\ProcedureStartedEvent;
use Hermes\Bureau\Factories\IBureaucratProcedureRunnerDecorator;
use Hermes\Bureau\Repositories\IProcedureRepository;
use Hermes\Bureau\Services\BureaucratProcedureRunner;

/**
 * Description of PersistBureaucratProcedure
 *
 * @author jguevara
 */
class PersistBureaucratProcedure implements IBureaucratProcedureRunnerDecorator
{

    /**
     *
     * @var IProcedureRepository 
     */
    private $procedureRepository;

    public function __construct(IProcedureRepository $procedureRepository) {
        $this->procedureRepository = $procedureRepository;
    }

    //put your code here
    public function decorate(BureaucratProcedureRunner $runner) {
        $updateProcedureOnOfficerEvent = function(OfficerEvent $event){
            $this->procedureRepository->update($event->getProcedure());
        };
        
        $runner->onProcedureStarted(function(ProcedureStartedEvent $event) {
            $procedure = $event->getProcedure();

            if ($procedure->getId() === 0) {
                $this->procedureRepository->save($procedure);
            }
        })
        ->onOfficerCompleted($updateProcedureOnOfficerEvent)
        ->onOfficerFailed($updateProcedureOnOfficerEvent);
    }

}
