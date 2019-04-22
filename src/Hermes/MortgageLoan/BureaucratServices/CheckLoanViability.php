<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MortgageLoan\BureaucratServices;

use BadMethodCallException;
use Hermes\Bureau\Form;
use Hermes\Bureau\Process;
use Hermes\Bureau\Services\BureaucratServiceRequirementsTrait;
use Hermes\Bureau\Services\IBureaucratService;
use MortgageLoan\FormComponents\CreditLine;
use MortgageLoan\FormComponents\ExpensesInfo;
use MortgageLoan\FormComponents\IncomeInfo;
use MortgageLoan\FormComponents\Property;

/**
 * Description of CheckLoanViability
 *
 * @author Win 10
 */
class CheckLoanViability implements IBureaucratService {
   use BureaucratServiceRequirementsTrait;

    public function execute(Form $form, Process $process) {
        throw new BadMethodCallException('Not Implemented,');
    }

    public function shouldBeExecuted(Form $form, Process $process) {
        return $this->requireCompoents($form, [
                    Property::class,
                    IncomeInfo::class,
                    ExpensesInfo::class,
                    CreditLine::class,
                ]);
    }

}
