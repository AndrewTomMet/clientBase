<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 22.11.2016
 * Time: 12:03
 */

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Contact
 * @package ClientBundle\Entity
 * @ORM\Entity(repositoryClass="ClientBundle\Repository\ContactRepository")
 * @ORM\Table(name="contact")
 */
class Contact
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ContactType")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $mean;
    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="contacts")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mean
     *
     * @param string $mean
     *
     * @return Contact
     */
    public function setMean($mean)
    {
        $this->mean = $mean;

        return $this;
    }

    /**
     * Get mean
     *
     * @return string
     */
    public function getMean()
    {
        return $this->mean;
    }

    /**
     * Get displaName
     *
     * @return string
     */
    public function getDisplayName()
    {

        return $this->getType()->getName().': '.$this->mean;
    }

    /**
     * Set client
     *
     * @param \ClientBundle\Entity\Client $client
     *
     * @return Contact
     */
    public function setClient(\ClientBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \ClientBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set type
     *
     * @param \ClientBundle\Entity\ContactType $type
     *
     * @return Contact
     */
    public function setType(\ClientBundle\Entity\ContactType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \ClientBundle\Entity\ContactType
     */
    public function getType()
    {
        return $this->type;
    }

    public function __toString()
    {
        return (string) $this->getDisplayName();
    }
}
