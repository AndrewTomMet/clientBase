<?php

namespace ClientBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ContainsCheckHaveAllContactTypes
 *
 * @Annotation
 */
class ContainsCheckHaveAllContactTypes extends Constraint
{
    public $message = 'The client %name% have not all contact types!';

    /**
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
