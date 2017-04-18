<?php

namespace BCL\ActivityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActivityIdea
 *
 * @ORM\Table(name="activity_idea")
 * @ORM\Entity(repositoryClass="BCL\ActivityBundle\Repository\ActivityIdeaRepository")
 */
class ActivityIdea
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Url_Picture", type="string", length=255)
     */
    private $urlPicture;

    /**
     * @ORM\ManyToOne(targetEntity="BCL\UserBundle\Entity\Users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userCreator;

    /**
     * @ORM\ManyToMany(targetEntity="BCL\UserBundle\Entity\Users", cascade={"persist"})
     */
    private $userWhoLiked;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ActivityIdea
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ActivityIdea
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
     * Set urlPicture
     *
     * @param string $urlPicture
     *
     * @return ActivityIdea
     */
    public function setUrlPicture($urlPicture)
    {
        $this->urlPicture = $urlPicture;

        return $this;
    }

    /**
     * Get urlPicture
     *
     * @return string
     */
    public function getUrlPicture()
    {
        return $this->urlPicture;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userWhoLiked = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set userCreator
     *
     * @param \BCL\UserBundle\Entity\Users $userCreator
     *
     * @return ActivityIdea
     */
    public function setUserCreator(\BCL\UserBundle\Entity\Users $userCreator)
    {
        $this->userCreator = $userCreator;

        return $this;
    }

    /**
     * Get userCreator
     *
     * @return \BCL\UserBundle\Entity\Users
     */
    public function getUserCreator()
    {
        return $this->userCreator;
    }

    /**
     * Add userWhoLiked
     *
     * @param \BCL\UserBundle\Entity\Users $userWhoLiked
     *
     * @return ActivityIdea
     */
    public function addUserWhoLiked(\BCL\UserBundle\Entity\Users $userWhoLiked)
    {
        $this->userWhoLiked[] = $userWhoLiked;

        return $this;
    }

    /**
     * Remove userWhoLiked
     *
     * @param \BCL\UserBundle\Entity\Users $userWhoLiked
     */
    public function removeUserWhoLiked(\BCL\UserBundle\Entity\Users $userWhoLiked)
    {
        $this->userWhoLiked->removeElement($userWhoLiked);
    }

    /**
     * Get userWhoLiked
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserWhoLiked()
    {
        return $this->userWhoLiked;
    }
}
