<?php

namespace Hermes\Bureau\Factories;

use Hermes\Bureau\Services\BureaucratProcedureRunner;

/**
 * Description of BureaucratProcedureRunnerFactory
 *
 * @author jguevara
 */
class BureaucratProcedureRunnerFactory
{

    /**
     *
     * @var BureaucratProcedureRunner
     */
    private $instance;

    public function __construct() {
        $this->instance = new BureaucratProcedureRunner();
    }
    
    public static function create() {
        return new static();
    }

    public function with(IBureaucratProcedureRunnerDecorator $decorator) {
        $decorator->decorate($this->instance);
        
        return $this;
    }
    
    public function get(): BureaucratProcedureRunner{
        return $this->instance;
    }

}
