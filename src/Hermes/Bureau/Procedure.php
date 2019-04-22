<?php

namespace Hermes\Bureau;

use JeyDotC\IEnumerable;

/**
 * Description of Procedure
 *
 * @author jguevara
 */
class Procedure
{

    private $procedureNumber;
    private $description;

    /**
     *
     * @var Form
     */
    private $form;

    /**
     *
     * @var IEnumerable of BureaucratProcesses
     */
    private $processes;
    
    private $officerCompletedTaskListeners = [];
    
    private $officerFailedTaskListeners = [];
    
    private $procedureStartedListeners = [];

    public function __construct($procedureNumber, Form $form, IEnumerable $BureaucratProcesses, string $description = '') {
        $this->procedureNumber = $procedureNumber;
        $this->form = $form;
        $this->description = $description;
        $this->processes = $BureaucratProcesses;
    }
    
    public function getIsFinalized(){
        return $this->processes->all(function(Process $process){
            return $process->isFinalized();
        });
    }

    public function getProcedureNumber() {
        return $this->procedureNumber;
    }

    public function getForm(): Form {
        return $this->form;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getProcesses(): IEnumerable {
        return $this->processes;
    }
    
    public function getStartableProcesses(): IEnumerable {
        return $this->processes->where(function(Process $process){
            return $process->canPerformTask($this->form);
        });
    }
    
    function hasProcess(BureaucratOfficer $BureaucratInCharge) {
        return $this->processes->any(function(Process $process) use ($BureaucratInCharge) {
                    return $process->getBureaucratOfficerIncharge()->getId() == $BureaucratInCharge->getId();
                });
    }

    function getProcess(BureaucratOfficer $BureaucratInCharge): Process {
        return $this->processes->first(function(Process $process) use ($BureaucratInCharge) {
                    return $process->getBureaucratOfficerIncharge()->getId() == $BureaucratInCharge->getId();
                });
    }

    public function generateTaskReport() {
        return $this->processes->select(function(Process $process) {
                    $status = $process->getLastStamp();
                    $officer = $process->getBureaucratOfficerIncharge();
                    return [
                        'officerId' => $officer->getId(),
                        'officerName' => $officer->getName(),
                        'taskStatus' => $status
                    ];
                });
    }
    
    public function run(){
        
        $this->procedureStarted(new ProcedureStartedEvent($this));
        
        foreach ($this->getStartableProcesses() as /** @var Process $process */ $process) {
            
            try {
                $process->performTask($this->form);
                $this->officerCompleted(new OfficerCompletedEvent($this, $process->getBureaucratOfficerIncharge(), $this->form));
            } catch (Exception $ex) {
                $officerFailed = new OfficerFailedEvent($ex, $this, $process->getBureaucratOfficerIncharge(), $this->form);
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
