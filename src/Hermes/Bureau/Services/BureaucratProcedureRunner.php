<?php

namespace Hermes\Bureau\Services;

use Exception;
use Hermes\Bureau\Process;
use Hermes\Bureau\Procedure;
use Hermes\Bureau\Events\OfficerCompletedEvent;
use Hermes\Bureau\Events\OfficerFailedEvent;
use Hermes\Bureau\Events\ProcedureStartedEvent;

/**
 * Description of BureaucratProcessRunner
 *
 * @author jguevara
 */
class BureaucratProcedureRunner implements IBureaucratProcedureRunner
{
    private $officerCompletedTaskListeners = [];
    
    private $officerFailedTaskListeners = [];
    
    private $procedureStartedListeners = [];
    
    public function run(Procedure $procedure){
        
        $this->procedureStarted(new ProcedureStartedEvent($procedure));

        foreach ($procedure->getProcesses() as /** @var Process $process */ $process) {

            $form = $procedure->getForm();
            
            try {
                $process->performTask($form);
                $this->officerCompleted(new OfficerCompletedEvent($procedure, $process->getBureaucratOfficerIncharge(), $form));
            } catch (Exception $ex) {
                $officerFailed = new OfficerFailedEvent($ex, $procedure, $process->getBureaucratOfficerIncharge(), $form);
                $this->officerFailed($officerFailed);
                
                $actionToTake = $officerFailed->getActionToTake();
                
                if($actionToTake == OfficerFailedEvent::CONTINUE_PROCESS){
                    continue;
                }else if($actionToTake == OfficerFailedEvent::FINISH_SILENTLY){
                    return;
                }else {
                    throw $ex;
                }
            }
        }
    }
    
    public function onProcedureStarted(callable $listener): IBureaucratProcedureRunner{
        $this->procedureStartedListeners[] = $listener;
        return $this;
    }
    
    public function onOfficerCompleted(callable $listener): IBureaucratProcedureRunner{
        $this->officerCompletedTaskListeners[] = $listener;
        return $this;
    }
    
    public function onOfficerFailed(callable $listener): IBureaucratProcedureRunner {
        $this->officerFailedTaskListeners[] = $listener;
        return $this;
    }
    
    private function procedureStarted(ProcedureStartedEvent $event){
        foreach ($this->procedureStartedListeners as $listener){
            $listener($event);
        }
    }
    
    private function officerCompleted(OfficerCompletedEvent $event){
        foreach ($this->officerCompletedTaskListeners as $listener){
            $listener($event);
        }
    }
    
     private function officerFailed(OfficerFailedEvent $event){
        foreach ($this->officerFailedTaskListeners as $listener){
            $listener($event);
        }
    }
}
