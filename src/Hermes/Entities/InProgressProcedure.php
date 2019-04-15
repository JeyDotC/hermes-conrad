<?php

namespace Hermes\Entities;

use JeyDotC\IEnumerable;

/**
 * Description of Procedure
 *
 * @author jguevara
 */
class InProgressProcedure
{

    private $id;
    private $description;

    /**
     *
     * @var BoringTask
     */
    private $boringTask;

    /**
     *
     * @var IEnumerable of BureocratProcesses
     */
    private $processes;

    public function __construct($id, BoringTask $boringTask, IEnumerable $bureocratProcesses, string $description = '') {
        $this->id = $id;
        $this->boringTask = $boringTask;
        $this->description = $description;
        $this->processes = $bureocratProcesses;
    }

    public function getId() {
        return $this->id;
    }

    public function getBoringTask(): BoringTask {
        return $this->boringTask;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getProcesses(): IEnumerable {
        return $this->processes;
    }

    function hasProcess(BureocratOfficer $bureocratInCharge) {
        return $this->processes->any(function(BureocratProcess $process) use ($bureocratInCharge) {
                    return $process->getBureocratOfficerIncharge()->getId() == $bureocratInCharge->getId();
                });
    }

    function getProcess(BureocratOfficer $bureocratInCharge): BureocratProcess {
        return $this->processes->first(function(BureocratProcess $process) use ($bureocratInCharge) {
                    return $process->getBureocratOfficerIncharge()->getId() == $bureocratInCharge->getId();
                });
    }

    public function generateTaskReport() {
        return $this->processes->select(function(BureocratProcess $process) {
                    $status = $process->getLastStamp();
                    $officer = $process->getBureocratOfficerIncharge();
                    return [
                        'officerId' => $officer->getId(),
                        'officerName' => $officer->getName(),
                        'taskStatus' => $status
                    ];
                });
    }

}
