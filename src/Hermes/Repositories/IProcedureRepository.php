<?php

namespace Hermes\Repositories;

use Hermes\Entities\InProgressProcedure;
use JeyDotC\IEnumerable;

/**
 *
 * @author jguevara
 */
interface IProcedureRepository
{
    public function save(InProgressProcedure $newProcedure): InProgressProcedure;
    
    public function update(InProgressProcedure $existingProcedure);
    
    public function all(): IEnumerable;
}
