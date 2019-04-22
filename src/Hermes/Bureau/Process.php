<?php

namespace Hermes\Bureau;

use Hermes\Bureau\Exceptions\RecoverableTaskFailedException;
use Hermes\Bureau\Stamp;
use JeyDotC\Enumerable;
use JeyDotC\EnumerableList;
use JeyDotC\IEnumerable;
use JeyDotC\IList;

/**
 * Description of BureaucratProcess
 *
 * @author jguevara
 */
class Process
{

    /**
     *
     * @var BureaucratOfficer
     */
    private $BureaucratOfficerIncharge;

    /**
     *
     * @var IList
     */
    private $stamps;

    public static function create(BureaucratOfficer $officerInCharge) {
        return new static($officerInCharge, Enumerable::empty());
    }

    function __construct(BureaucratOfficer $BureaucratOfficerIncharge, IEnumerable $stamps) {
        $this->BureaucratOfficerIncharge = $BureaucratOfficerIncharge;
        $this->stamps = EnumerableList::from($stamps->orderBy(function (Stamp $stamp1, Stamp $stamp2) {
                            return $stamp1->getTimeStamp() - $stamp2->getTimeStamp();
                        }));
    }
    
    public function canPerformTask(Form $task): bool {
        return $this->BureaucratOfficerIncharge->getFunction()->shouldBeExecuted($task, $this);
    }

    public function performTask(Form $task) {
        $officerFunction = $this->BureaucratOfficerIncharge->getFunction();
        
        if(!$officerFunction->shouldBeExecuted($task, $this)){
            return;
        }
        
        try {
            $officerFunction->execute($task, $this);
        } catch (RecoverableTaskFailedException $exc) {
            $this->stamp(Stamp::STATUS_FAILED_RESUMABLE, $exc->getPrevious()->getMessage());
            throw $exc;
        } catch (\Hermes\Bureau\Exceptions\DefinitiveTaskFailedException $exc){
            $this->stamp(Stamp::STATUS_FAILED_DEFINITIVE, $exc->getPrevious()->getMessage());
            throw $exc;
        }catch (\Exception $exc){
            $this->stamp(Stamp::STATUS_FAILED_RESUMABLE, $exc->getMessage());
            throw $exc;
        }
    }

    public function stamp(string $status, string $notes = '') {
        $this->stamps->add(new Stamp(time(), $status, $notes));
    }

    public function getLastStamp(): Stamp {
        return $this->stamps->lastOrDefault(Stamp::empty());
    }

    public function getStamps(): IEnumerable {
        return Enumerable::from($this->stamps);
    }

    function getBureaucratOfficerIncharge(): BureaucratOfficer {
        return $this->BureaucratOfficerIncharge;
    }

}
