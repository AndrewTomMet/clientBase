<?php

namespace ClientBundle\Validator\Constraints;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ContainsCheckHaveAllContactTypesValidator
 */
class ContainsCheckHaveAllContactTypesValidator extends ConstraintValidator
{
    protected $entityManager;
    protected $repositoryName;

    /**
     * @return string
     */
    public function getRepositoryName()
    {
        return $this->repositoryName;
    }

    /**
     * ContainsCheckHaveAllContactTypesValidator constructor.
     * @param ObjectManager $manager
     * @param string        $repositoryName
     */
    public function __construct(ObjectManager $manager, $repositoryName = '')
    {
        $this->entityManager = $manager;
        $this->repositoryName = $repositoryName;
    }

    /**
     * @param mixed      $client
     * @param Constraint $constraint
     */
    public function validate($client, Constraint $constraint)
    {
        $clientContacts = $client->getContacts();

        $allContactsTypeId = [];
        if (!empty($this->getRepositoryName())) {
            $allContactTypes = $this->entityManager->getRepository($this->getRepositoryName())->findAll();
            foreach ($allContactTypes as $contactType) {
                $allContactsTypeId[] = $contactType->getId();
            }
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
