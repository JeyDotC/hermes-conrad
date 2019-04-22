<?php

namespace Hermes\Bureau\Repositories;

use Hermes\Bureau\Procedure;
use JeyDotC\IEnumerable;

/**
 *
 * @author jguevara
 */
interface IProcedureRepository
{
    public function save(Procedure $newProcedure): Procedure;
    
    public function update(Procedure $existingProcedure);
    
    public function all(): IEnumerable;
    
    public function getRunnableProcedures(): IEnumerable;
}
