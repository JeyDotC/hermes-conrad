<?php

namespace Hermes\Services;

use Exception;
use Hermes\Entities\BureocratOfficer;
use Hermes\Entities\Procedure;
use Hermes\Events\OfficerCompletedEvent;
use Hermes\Events\OfficerFailedEvent;
use Hermes\Events\ProcedureStartedEvent;

/**
 * Description of BureocratProcessRunner
 *
 * @author jguevara
 */
class BureocratProcedureRunner
{
    private $officerCompletedTaskListeners = [];
    
    private $officerFailedTaskListeners = [];
    
    private $procedureStartedListeners = [];
    
    public function run(Procedure $procedure){
        
        $this->procedureStarted(new ProcedureStartedEvent($procedure));

        foreach ($procedure->getBureocratOfficers() as /** @var BureocratOfficer $officer */ $officer) {

            $task = $procedure->getBoringTask();
            
            $task->openProces($officer->getId());

            try {
                $officer->performTask($task);
                $this->officerCompleted(new OfficerCompletedEvent($procedure, $officer, $task));
            } catch (Exception $ex) {
                $officerFailed = new OfficerFailedEvent($ex, $procedure, $officer, $task);
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
    
    public function onProcedureStarted(callable $listener){
        $this->procedureStartedListeners[] = $listener;
        return $this;
    }
    
    public function onOfficerCompleted(callable $listener){
        $this->officerCompletedTaskListeners[] = $listener;
        return $this;
    }
    
    public function onOfficerFailed(callable $listener){
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
