<?php

namespace ClientBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Client
 * @package ClientBundle\Entity
 * @ORM\Entity(repositoryClass="ClientBundle\Repository\ClientRepository")
 * @ORM\Table(name="client")
 * @ORM\HasLifecycleCallbacks
 */

class Client
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\NotBlank(message = "client.firstname.not_blank")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $surname;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthday;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="Contact", mappedBy="client", cascade={"remove"})
     */
    private $contacts;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="clients")
     * @ORM\JoinTable(name="client_category")
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity="Lang")
     */
    private $language;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Get tags
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set tags
     *
     * @param array $tags
     *
     * @return Client
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Client
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Client
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Get display name
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->getSurname().' '.$this->getFirstname();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this ->getDisplayName();
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return Client
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Client
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->created_at = new \DateTime('now');

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Client
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add contact
     *
     * @param \ClientBundle\Entity\Contact $contact
     *
     * @return Client
     */
    public function addContact(\ClientBundle\Entity\Contact $contact)
    {
        $contact->setClient($this);
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Remove contact
     *
     * @param \ClientBundle\Entity\Contact $contact
     */
    public function removeContact(\ClientBundle\Entity\Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Add category
     *
     * @param \ClientBundle\Entity\Category $category
     *
     * @return Client
     */
    public function addCategory(\ClientBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \ClientBundle\Entity\Category $category
     */
    public function removeCategory(\ClientBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set language
     *
     * @param \ClientBundle\Entity\Lang $language
     *
     * @return Client
     */
    public function setLanguage(\ClientBundle\Entity\Lang $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \ClientBundle\Entity\Lang
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
