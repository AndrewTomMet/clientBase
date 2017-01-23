<?php

namespace tests\ClientBundle\Validator\Constraints;

use ClientBundle\Entity\Client;
use ClientBundle\Entity\Contact;
use ClientBundle\Repository\ContactTypeRepository;
use ClientBundle\Validator\Constraints\ContainsCheckHaveAllContactTypesValidator;
use ClientBundle\Entity\ContactType;
use ClientBundle\Validator\Constraints as ClientAssert;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilder;

class ContainsCheckHaveAllContactTypesValidatorTest extends \PHPUnit_Framework_TestCase
{
    private $context;
    private $repository;
    private $contactType;
    private $contactType1;
    private $clientContact;
    private $clientContact1;
    private $contains;
    private $allContactTypes;
    private $validator;
    private $constraintValidationBuilder;

    public function setUp()
    {
        $this->context = $this->getMockBuilder(ExecutionContext::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->contains = new ClientAssert\ContainsCheckHaveAllContactTypes();

        $this->contactType = $this->getMock(ContactType::class, ['getId']);
        $this->contactType->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(0));

        $this->clientContact = $this->getMock(Contact::class, ['getType']);
        $this->clientContact->expects($this->any())
            ->method('getType')
            ->will($this->returnValue($this->contactType));

        $this->repository = $this
            ->getMockBuilder(ContactTypeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->contactType1 = $this->getMock(ContactType::class, ['getId']);
        $this->contactType1->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(1));

        $this->clientContact1 = $this->getMock(Contact::class, ['getType']);
        $this->clientContact1->expects($this->any())
            ->method('getType')
            ->will($this->returnValue($this->contactType1));

        $this->allContactTypes = [0, 1];

        $this->constraintValidationBuilder = $this->getMockBuilder(ConstraintViolationBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository->expects($this->once())
            ->method('getAllIds')
            ->will($this->returnValue($this->allContactTypes));
        $this->validator = new ContainsCheckHaveAllContactTypesValidator($this->repository);
        $this->validator->initialize($this->context);
    }

    public function testPassValidator()
    {
        $client = $this->getMock(Client::class, ['getContacts', 'getFirstName']);

        $client->expects($this->any())
            ->method('getFirstName')
            ->will($this->returnValue('tratata'));

        $client->expects($this->any())
            ->method('getContacts')
            ->will($this->returnValue([$this->clientContact, $this->clientContact1]));

        $this->constraintValidationBuilder->expects($this->any())
            ->method('setParameter')
            ->with($this->equalTo('%name%'), $this->equalTo($client->getFirstName()))
            ->will($this->returnSelf());

        $this->context->expects($this->never())
            ->method('buildViolation')
            ->will($this->returnValue($this->constraintValidationBuilder));

        $this->validator->validate($client, $this->contains);
    }

    public function testFailValidator()
    {
        $client = $this->getMock(Client::class, ['getContacts', 'getFirstName']);

        $client->expects($this->any())
            ->method('getFirstName')
            ->will($this->returnValue('tratata'));

        $client->expects($this->any())
            ->method('getContacts')
            ->will($this->returnValue([$this->clientContact]));

        $this->constraintValidationBuilder->expects($this->any())
            ->method('setParameter')
            ->with($this->equalTo('%name%'), $this->equalTo($client->getFirstName()))
            ->will($this->returnSelf());

        $this->context->expects($this->once())
            ->method('buildViolation')
            ->will($this->returnValue($this->constraintValidationBuilder));

        $this->validator->validate($client, $this->contains);
    }
}
