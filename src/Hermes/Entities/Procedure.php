<?php

namespace Hermes\Entities;

use JeyDotC\IEnumerable;

/**
 * Description of Procedure
 *
 * @author jguevara
 */
class Procedure
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
     * @var IEnumerable of BureocratOfficer 
     */
    private $bureocratOfficers;

    public function __construct($id, BoringTask $boringTask, IEnumerable $bureocratOfficers, string $description = '') {
        $this->id = $id;
        $this->boringTask = $boringTask;
        $this->bureocratOfficers = $bureocratOfficers;
        $this->description = $description;
    }

    public function getId() {
        return $this->id;
    }

    public function getBoringTask(): BoringTask {
        return $this->boringTask;
    }

    public function getBureocratOfficers(): IEnumerable {
        return $this->bureocratOfficers;
    }

    public function getDescription() {
        return $this->description;
    }

    public function generateTaskReport() {
        return $this->bureocratOfficers
                        ->where(function(BureocratOfficer $officer) {
                            return $this->boringTask->hasProcess($officer->getId());
                        })
                        ->select(function(BureocratOfficer $officer) {
                            $status = $this->boringTask->getProcess($officer->getId())->getLastStamp();
                            return [
                                'officerId' => $officer->getId(),
                                'officerName' => $officer->getName(),
                                'taskStatus' => $status
                            ];
                        });
    }

}
