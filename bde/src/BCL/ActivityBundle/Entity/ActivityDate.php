<?php

namespace BCL\ActivityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActivityDate
 *
 * @ORM\Table(name="activity_date")
 * @ORM\Entity(repositoryClass="BCL\ActivityBundle\Repository\ActivityDateRepository")
 */
class ActivityDate
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateActivity", type="datetime")
     */
    private $dateActivity;

    /**
     * @ORM\ManyToOne(targetEntity="BCL\ActivityBundle\Entity\Activity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /**
     * @ORM\ManyToMany(targetEntity="BCL\UserBundle\Entity\Users", cascade={"persist"})
     */
    private $user;


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
     * Set dateActivity
     *
     * @param \DateTime $dateActivity
     *
     * @return ActivityDate
     */
    public function setDateActivity($dateActivity)
    {
        $this->dateActivity = $dateActivity;

        return $this;
    }

    /**
     * Get dateActivity
     *
     * @return \DateTime
     */
    public function getDateActivity()
    {
        return $this->dateActivity;
    }

    /**
     * Set activity
     *
     * @param \BCL\ActivityBundle\Entity\Activity $activity
     *
     * @return ActivityDate
     */
    public function setActivity(\BCL\ActivityBundle\Entity\Activity $activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return \BCL\ActivityBundle\Entity\Activity
     */
    public function getActivity()
    {
        return $this->activity;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \BCL\UserBundle\Entity\Users $user
     *
     * @return ActivityDate
     */
    public function addUser(\BCL\UserBundle\Entity\Users $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \BCL\UserBundle\Entity\Users $user
     */
    public function removeUser(\BCL\UserBundle\Entity\Users $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }
}
