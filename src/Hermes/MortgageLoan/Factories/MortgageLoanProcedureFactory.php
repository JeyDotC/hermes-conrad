<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MortgageLoan\Factories;

use BadMethodCallException;
use Hermes\Bureau\Form;
use Hermes\Bureau\Procedure;
use Hermes\Bureau\Services\BureaucratServiceRequirementsTrait;
use JeyDotC\Enumerable;
use MortgageLoan\BureaucratServices\CheckForActualPropertyWorth;
use MortgageLoan\BureaucratServices\CheckForCreditBehaviorHistory;
use MortgageLoan\BureaucratServices\CheckForCriminalRecord;
use MortgageLoan\BureaucratServices\CheckLoanViability;
use MortgageLoan\BureaucratServices\CheckPersonalInfoIsTrue;
use MortgageLoan\BureaucratServices\CheckPropertySaleAvailability;
use MortgageLoan\FormComponents\Address;
use MortgageLoan\FormComponents\ContactInfo;
use MortgageLoan\FormComponents\CreditLine;
use MortgageLoan\FormComponents\ExpensesInfo;
use MortgageLoan\FormComponents\IncomeInfo;
use MortgageLoan\FormComponents\JobInfo;
use MortgageLoan\FormComponents\PersonalInfo;
use MortgageLoan\FormComponents\Property;

/**
 * Description of MortgageLoanProcedureFactory
 *
 * @author Win 10
 */
class MortgageLoanProcedureFactory {

    use BureaucratServiceRequirementsTrait;

    public function createMortgageLoanProcedure(Form $form, string $description = ''): Procedure {

        if (!$this->requireCompoents($form, [
                    PersonalInfo::class,
                    ContactInfo::class,
                    Address::class,
                    JobInfo::class,
                    IncomeInfo::class,
                    ExpensesInfo::class,
                    CreditLine::class,
                    Property::class
                ])) {
            throw  new BadMethodCallException("Missing required form components.");
        }

        return new Procedure(0, $form, Enumerable::from([
            new CheckPersonalInfoIsTrue(),
            new CheckForCriminalRecord(),
            new CheckForCreditBehaviorHistory(),
            new CheckLoanViability(),
            new CheckForActualPropertyWorth(),
            new CheckPropertySaleAvailability()
        ]), $description);
    }

}
