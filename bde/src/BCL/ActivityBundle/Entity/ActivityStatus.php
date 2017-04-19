<?php

namespace BCL\ActivityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActivityStatus
 *
 * @ORM\Table(name="activity_status")
 * @ORM\Entity(repositoryClass="BCL\ActivityBundle\Repository\ActivityStatusRepository")
 */
class ActivityStatus
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
     * @ORM\Column(name="Name_Status", type="string", length=255)
     */
    private $nameStatus;


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
     * @return ActivityStatus
     */
    public function setNameStatus($nameStatus)
    {
        $this->nameStatus = $nameStatus;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getNameStatus()
    {
        return $this->nameStatus;
    }
}

