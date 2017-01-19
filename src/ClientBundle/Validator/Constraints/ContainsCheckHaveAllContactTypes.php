<?php

namespace ClientBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ContainsCheckHaveAllContactTypes
 */
class ContainsCheckHaveAllContactTypes extends Constraint
{
    public $message = 'The client %name% have not all contactTypes!';

    /**
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
