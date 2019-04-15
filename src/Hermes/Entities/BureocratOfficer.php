<?php

namespace Hermes\Entities;

use Exception;
use Hermes\Services\IBureocratService;
use Hermes\ValueObjects\Stamp;

/**
 * Description of BureocratOfficer
 *
 * @author jguevara
 */
class BureocratOfficer
{

    private $id;
    private $name;

    /**
     *
     * @var IBureocratService
     */
    private $function;

    public function __construct(int $id, $name, IBureocratService $function) {
        $this->id = $id;
        $this->name = $name;
        $this->function = $function;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getFunction(): IBureocratService {
        return $this->function;
    }

    public function performTask(BoringTask $boringTask) {
        if (!$boringTask->hasProcess($this->id)) {
            return;
        }

        $process = $boringTask->getProcess($this->id);
        
        if ($this->function->shouldBeExecuted($boringTask, $process)) {

            $lastStamp = $process->getLastStamp();

            if ($lastStamp->getStatus() != Stamp::STATUS_COMPLETED) {
                $this->doExecute($boringTask, $process);
            }
        }
    }

    private function doExecute(BoringTask $boringTask, BureocratProcess $process) {
        try {
            $this->function->execute($boringTask, $process);
        } catch (Exception $exc) {
            $process->stamp(Stamp::STATUS_ERROR, $exc->getMessage());
            throw $exc;
        }
    }

}
