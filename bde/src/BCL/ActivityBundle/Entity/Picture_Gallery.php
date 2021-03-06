<?php

namespace BCL\ActivityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Picture_Gallery
 *
 * @ORM\Table(name="picture__gallery")
 * @ORM\Entity(repositoryClass="BCL\ActivityBundle\Repository\Picture_GalleryRepository")
 */
class Picture_Gallery
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
     * @ORM\Column(name="Url_Picture", type="string", length=255)
     */
    private $urlPicture;

    /**
     * @ORM\ManyToMany(targetEntity="BCL\UserBundle\Entity\Users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $personsWhoLiked;

    /**
     * @ORM\ManyToOne(targetEntity="BCL\ActivityBundle\Entity\Gallery")
     * @ORM\JoinColumn(nullable=false)
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
     * Set urlPicture
     *
     * @param string $urlPicture
     *
     * @return Picture_Gallery
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
        $this->personsWhoLiked = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add personsWhoLiked
     *
     * @param \BCL\UserBundle\Entity\Users $personsWhoLiked
     *
     * @return Picture_Gallery
     */
    public function addPersonsWhoLiked(\BCL\UserBundle\Entity\Users $personsWhoLiked)
    {
        $this->personsWhoLiked[] = $personsWhoLiked;

        return $this;
    }

    /**
     * Remove personsWhoLiked
     *
     * @param \BCL\UserBundle\Entity\Users $personsWhoLiked
     */
    public function removePersonsWhoLiked(\BCL\UserBundle\Entity\Users $personsWhoLiked)
    {
        $this->personsWhoLiked->removeElement($personsWhoLiked);
    }

    /**
     * Get personsWhoLiked
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonsWhoLiked()
    {
        return $this->personsWhoLiked;
    }

    /**
     * Set gallery
     *
     * @param \BCL\ActivityBundle\Entity\Gallery $gallery
     *
     * @return Picture_Gallery
     */
    public function setGallery(\BCL\ActivityBundle\Entity\Gallery $gallery)
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
