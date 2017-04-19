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
     * @ORM\Column(name="Name_Activity_Idea", type="string", length=255)
     */
    private $nameActivityIdea;

    /**
     * @var string
     *
     * @ORM\Column(name="Description_Activity_Idea", type="text")
     */
    private $descriptionActivityIdea;

    /**
     * @var string
     *
     * @ORM\Column(name="Url_Picture_Activity_Idea", type="string", length=255)
     */
    private $urlPictureActivityIdea;

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
    public function setNameActivityIdea($nameActivityIdea)
    {
        $this->nameActivityIdea = $nameActivityIdea;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getNameActivityIdea()
    {
        return $this->nameActivityIdea;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ActivityIdea
     */
    public function setDescriptionActivityIdea($descriptionActivityIdea)
    {
        $this->descriptionActivityIdea = $descriptionActivityIdea;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescriptionActivityIdea()
    {
        return $this->descriptionActivityIdea;
    }

    /**
     * Set urlPicture
     *
     * @param string $urlPicture
     *
     * @return ActivityIdea
     */
    public function setUrlPictureActivityIdea($urlPictureActivityIdea)
    {
        $this->urlPictureActivityIdea = $urlPictureActivityIdea;

        return $this;
    }

    /**
     * Get urlPicture
     *
     * @return string
     */
    public function getUrlPictureActivityIdea()
    {
        return $this->urlPictureActivityIdea;
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
