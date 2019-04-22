<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MortgageLoan\Factories;

use Hermes\Bureau\Form;
use JeyDotC\EnumerableList;
use MortgageLoan\FormComponents\Address;
use MortgageLoan\FormComponents\ContactInfo;
use MortgageLoan\FormComponents\CreditLine;
use MortgageLoan\FormComponents\ExpensesInfo;
use MortgageLoan\FormComponents\IncomeInfo;
use MortgageLoan\FormComponents\JobInfo;
use MortgageLoan\FormComponents\PersonalInfo;
use MortgageLoan\FormComponents\Property;

/**
 * Description of MortgageLoanFormFactory
 *
 * @author Win 10
 */
class MortgageLoanFormFactory {
    
    public function createForm( 
            PersonalInfo $personalInfo,
            ContactInfo $contactInfo,
            Address $address,
            JobInfo $jobInfo,
            IncomeInfo $incomeInfo,
            ExpensesInfo $expensesInfo,
            CreditLine $creditLine,
            Property $property
        ): Form {
        return new Form(0, EnumerableList::from([
            $personalInfo,
            $contactInfo,
            $address,
            $jobInfo,
            $incomeInfo,
            $expensesInfo,
            $creditLine,
            $property
        ]));
    }
}
