<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hermes\Bureau\Repositories;

use Hermes\Bureau\BureaucratOfficer;
use JeyDotC\IEnumerable;

/**
 *
 * @author jeiss
 */
interface IBureaucratOfficerRepository {

    public function add(BureaucratOfficer $newProcedure): BureaucratOfficer;

    public function update(BureaucratOfficer $existingProcedure);
    
    public function getOfficersThatProvideTheseServices(array $bureaucratServiceNames): IEnumerable;
}
