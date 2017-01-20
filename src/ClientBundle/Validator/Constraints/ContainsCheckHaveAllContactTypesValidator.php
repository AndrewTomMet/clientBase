<?php

namespace ClientBundle\Validator\Constraints;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Doctrine\ORM\EntityRepository;
/**
 * Class ContainsCheckHaveAllContactTypesValidator
 */
class ContainsCheckHaveAllContactTypesValidator extends ConstraintValidator
{
    protected $repository;

    /**
     * ContainsCheckHaveAllContactTypesValidator constructor.
     * @param EntityRepository $repository
     */
    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param mixed      $client
     * @param Constraint $constraint
     */
    public function validate($client, Constraint $constraint)
    {
        $clientContacts = $client->getContacts();

        $allContactsTypeId = [];
        if (!empty($this->repository)) {
            $allContactsTypeId = $this->repository->getAllIds();
        }

        $clientContactsTypeId = [];
        foreach ($clientContacts as $contact) {
            $clientContactsTypeId[] = $contact->getType()->getId();
        }

        $result = array_diff($allContactsTypeId, $clientContactsTypeId);
        if (!empty($result)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%name%', $client->getFirstName())
                ->addViolation();
        }
    }
}
