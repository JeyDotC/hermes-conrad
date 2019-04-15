<?php

namespace Hermes\Factories\Decorators;

use Hermes\Events\OfficerEvent;
use Hermes\Events\ProcedureStartedEvent;
use Hermes\Factories\IBureocratProcedureRunnerDecorator;
use Hermes\Repositories\IProcedureRepository;
use Hermes\Services\BureocratProcedureRunner;

/**
 * Description of PersistBureocratProcedure
 *
 * @author jguevara
 */
class PersistBureocratProcedure implements IBureocratProcedureRunnerDecorator
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
    public function decorate(BureocratProcedureRunner $runner) {
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
