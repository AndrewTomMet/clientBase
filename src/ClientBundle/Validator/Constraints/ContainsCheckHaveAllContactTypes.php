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
    public $message = 'Клієнт %name% повинин мати всі типи контактів!';

    /**
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
