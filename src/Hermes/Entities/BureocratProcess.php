<?php

namespace Hermes\Entities;

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
    private $bureocratOfficerIncharge;

    /**
     *
     * @var IList
     */
    private $stamps;

    function __construct($bureocratOfficerIncharge, IEnumerable $stamps) {
        $this->bureocratOfficerIncharge = $bureocratOfficerIncharge;
        $this->stamps = EnumerableList::from($stamps->orderBy(function (Stamp $stamp1, Stamp $stamp2) {
            return $stamp1->getTimeStamp() - $stamp2->getTimeStamp();
        }));
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

    function getBureocratOfficerIncharge() {
        return $this->bureocratOfficerIncharge;
    }

}
