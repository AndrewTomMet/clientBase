<?php

namespace ClientBundle\Validator\Constraints;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
/**
 * Class ContainsCheckHaveAllContactTypesValidator
 */
class ContainsCheckHaveAllContactTypesValidator extends ConstraintValidator
{
    /** @var ArrayCollection */
    private $contactTypes;

    /**
     * @param ArrayCollection $contactTypes
     */
    public function setContactTypes($contactTypes)
    {
        $this->contactTypes = $contactTypes;
    }

    /**
     * @param mixed      $client
     * @param Constraint $constraint
     */
    public function validate($client, Constraint $constraint)
    {
        $contacts = $client->getContacts();

        var_dump($contacts->toArray());
        var_dump($this->contactTypes);

        //$diff = array_diff($this->contactTypes, );
        //$contactArr['type']
    }

    private function getElemsByKey($arr)
    {
        $result = array();
        foreach ($arr as $ar) {
            $result[] = $arr->getType();
        }

        return $result;
    }
}
