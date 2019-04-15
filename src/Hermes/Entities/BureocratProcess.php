<?php

namespace Hermes\Entities;

use Hermes\Exceptions\RecoverableTaskFailedException;
use Hermes\ValueObjects\Stamp;
use JeyDotC\Enumerable;
use JeyDotC\EnumerableList;
use JeyDotC\IEnumerable;
use JeyDotC\IList;

/**
 * Description of BureocratProcess
 *
 * @author jguevara
 */
class BureocratProcess
{

    /**
     *
     * @var BureocratOfficer
     */
    private $bureocratOfficerIncharge;

    /**
     *
     * @var IList
     */
    private $stamps;

    public static function create(BureocratOfficer $officerInCharge) {
        return new static($officerInCharge, Enumerable::empty());
    }

    function __construct(BureocratOfficer $bureocratOfficerIncharge, IEnumerable $stamps) {
        $this->bureocratOfficerIncharge = $bureocratOfficerIncharge;
        $this->stamps = EnumerableList::from($stamps->orderBy(function (Stamp $stamp1, Stamp $stamp2) {
                            return $stamp1->getTimeStamp() - $stamp2->getTimeStamp();
                        }));
    }

    public function performTask(BoringTask $task) {
        $officerFunction = $this->bureocratOfficerIncharge->getFunction();
        
        if(!$officerFunction->shouldBeExecuted($task, $this)){
            return;
        }
        
        try {
            $officerFunction->execute($task, $this);
        } catch (RecoverableTaskFailedException $exc) {
            $this->stamp(Stamp::STATUS_FAILED_RESUMABLE, $exc->getPrevious()->getMessage());
            throw $exc;
        } catch (\Hermes\Exceptions\DefinitiveTaskFailedException $exc){
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

    function getBureocratOfficerIncharge(): BureocratOfficer {
        return $this->bureocratOfficerIncharge;
    }

}
