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
use MortgageLoan\FormComponents\PersonalInfo;

/**
 * Description of CheckForCreditBehaviorHistory
 *
 * @author Win 10
 */
class CheckForCreditBehaviorHistory implements IBureaucratService{
    use BureaucratServiceRequirementsTrait;

    public function execute(Form $form, Process $process) {
        throw new BadMethodCallException('Not Implemented,');
    }

    public function shouldBeExecuted(Form $form, Process $process) {
        return $this->requireCompoents($form, [
                    PersonalInfo::class,
                ]);
    }

}
