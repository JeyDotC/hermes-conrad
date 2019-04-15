<?php

namespace Hermes\Repositories;

use Hermes\Entities\Procedure;
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
}
