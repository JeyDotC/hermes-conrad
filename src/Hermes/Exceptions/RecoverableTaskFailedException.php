<?php

namespace Hermes\Exceptions;

/**
 * Description of RecoverableTaskFailed
 *
 * @author jguevara
 */
class RecoverableTaskFailedException extends \Exception
{

    public function __construct(\Throwable $cause): \Exception {
        parent::__construct('This task failed but can be resumed.', 0, $cause);
    }

}
