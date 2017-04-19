<?php

namespace BCL\ActivityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activity
 *
 * @ORM\Table(name="activity")
 * @ORM\Entity(repositoryClass="BCL\ActivityBundle\Repository\ActivityRepository")
 */
class Activity
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
     * @ORM\Column(name="Url_Picture", type="string", length=255, nullable=true)
     */
    private $urlPicture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCloseVote", type="datetime",nullable=true)
     */
    private $dateCloseVote;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCloseSubscribe", type="datetime",nullable=true)
     */
    private $dateCloseSubscribe;

    /**
     * @ORM\ManyToOne(targetEntity="BCL\ActivityBundle\Entity\ActivityStatus",)
     * @ORM\JoinColumn(nullable=false)
     */
    private $activityStatus;

    /**
     * @ORM\ManyToMany(targetEntity="BCL\UserBundle\Entity\Users", cascade={"persist"})
     */
    private $usersSubscribed;

    /**
     * @ORM\OneToOne(targetEntity="BCL\ActivityBundle\Entity\Gallery", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $gallery;


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
     * @return Activity
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
     * @return Activity
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
     * @return Activity
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
     * Set dateActivity
     *
     * @param \DateTime $dateCloseVote
     *
     * @return Activity
     */
    public function setDateCloseVote($dateCloseVote)
    {
        $this->dateCloseVote = $dateCloseVote;
        return $this;
    }

    /**
     * Get dateCloseVote
     *
     * @return \DateTime
     */
    public function getDateCloseVote()
    {
        return $this->dateCloseVote;
    }

    /**
     * Set dateActivity
     *
     * @param \DateTime $dateCloseSubscribe
     *
     * @return Activity
     */
    public function setDateCloseSubscribe($dateCloseSubscribe)
    {
        $this->dateCloseVote = $dateCloseSubscribe;
        return $this;
    }

    /**
     * Get dateCloseVote
     *
     * @return \DateTime
     */
    public function getDateCloseSubscribe()
    {
        return $this->dateCloseVote;
    }

    /**
     * Set activityStatus
     *
     * @param \BCL\ActivityBundle\Entity\Activity $activityStatus
     *
     * @return Activity
     */
    public function setActivityStatus(\BCL\ActivityBundle\Entity\Activity $activityStatus)
    {
        $this->activityStatus = $activityStatus;

        return $this;
    }

    /**
     * Get activityStatus
     *
     * @return \BCL\ActivityBundle\Entity\Activity
     */
    public function getActivityStatus()
    {
        return $this->activityStatus;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usersSubscribed = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add usersSubscribed
     *
     * @param \BCL\UserBundle\Entity\Users $usersSubscribed
     *
     * @return Activity
     */
    public function addUsersSubscribed(\BCL\UserBundle\Entity\Users $usersSubscribed)
    {
        $this->usersSubscribed[] = $usersSubscribed;

        return $this;
    }

    /**
     * Remove usersSubscribed
     *
     * @param \BCL\UserBundle\Entity\Users $usersSubscribed
     */
    public function removeUsersSubscribed(\BCL\UserBundle\Entity\Users $usersSubscribed)
    {
        $this->usersSubscribed->removeElement($usersSubscribed);
    }

    /**
     * Get usersSubscribed
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsersSubscribed()
    {
        return $this->usersSubscribed;
    }

    /**
     * Set gallery
     *
     * @param \BCL\ActivityBundle\Entity\Gallery $gallery
     *
     * @return Activity
     */
    public function setGallery(\BCL\ActivityBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \BCL\ActivityBundle\Entity\Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }
}
