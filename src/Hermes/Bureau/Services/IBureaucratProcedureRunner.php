<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hermes\Bureau\Services;

/**
 *
 * @author Win 10
 */
interface IBureaucratProcedureRunner {
    
    public function run(Procedure $procedure): void;
    
    public function onProcedureStarted(callable $listener): IBureaucratProcedureRunner;
    
    public function onOfficerCompleted(callable $listener): IBureaucratProcedureRunner;
    
    public function onOfficerFailed(callable $listener): IBureaucratProcedureRunner;
}
