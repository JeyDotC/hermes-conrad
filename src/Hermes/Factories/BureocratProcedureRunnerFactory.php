<?php

namespace Hermes\Factories;

use Hermes\Services\BureocratProcedureRunner;

/**
 * Description of BureocratProcedureRunnerFactory
 *
 * @author jguevara
 */
class BureocratProcedureRunnerFactory
{

    /**
     *
     * @var BureocratProcedureRunner
     */
    private $instance;

    public function __construct() {
        $this->instance = new BureocratProcedureRunner();
    }
    
    public static function create() {
        return new static();
    }

    public function with(IBureocratProcedureRunnerDecorator $decorator) {
        $decorator->decorate($this->instance);
        
        return $this;
    }
    
    public function get(): BureocratProcedureRunner{
        return $this->instance;
    }

}
