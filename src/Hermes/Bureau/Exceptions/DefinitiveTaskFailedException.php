<?php

namespace Hermes\Bureau\Exceptions;

/**
 * Description of RecoverableTaskFailed
 *
 * @author jguevara
 */
class DefinitiveTaskFailedException extends \Exception
{

    public function __construct(\Throwable $cause): \Exception {
        parent::__construct('This task failed and should not be resumed.', 0, $cause);
    }

}
