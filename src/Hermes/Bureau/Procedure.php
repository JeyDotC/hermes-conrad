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

    public function __construct($procedureNumber, Form $form, IEnumerable $BureaucratProcesses, string $description = '') {
        $this->procedureNumber = $procedureNumber;
        $this->form = $form;
        $this->description = $description;
        $this->processes = $BureaucratProcesses;
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

}
