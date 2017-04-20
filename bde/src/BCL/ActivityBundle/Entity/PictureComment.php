<?php

namespace BCL\ActivityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PictureComment
 *
 * @ORM\Table(name="picture_comment")
 * @ORM\Entity(repositoryClass="BCL\ActivityBundle\Repository\PictureCommentRepository")
 */
class PictureComment
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
     * @ORM\Column(name="Content", type="string", length=255)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Comment", type="datetime",nullable=true)
     */
    private $dateComment;

    /**
     * @ORM\ManyToOne(targetEntity="BCL\ActivityBundle\Entity\Picture_Gallery")
     * @ORM\JoinColumn(nullable=false)
     */
    private $imageCommented;

    /**
     * @ORM\ManyToOne(targetEntity="BCL\UserBundle\Entity\Users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userCommented;


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
     * Set content
     *
     * @param string $content
     *
     * @return PictureComment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set dateComment
     *
     * @param \DateTime $dateComment
     *
     * @return PictureComment
     */
    public function setDateComment($dateComment)
    {
        $this->dateComment = $dateComment;

        return $this;
    }

    /**
     * Get dateComment
     *
     * @return \DateTime
     */
    public function getDateComment()
    {
        return $this->dateComment;
    }

    /**
     * Set imageCommented
     *
     * @param \BCL\ActivityBundle\Entity\Picture_Gallery $imageCommented
     *
     * @return PictureComment
     */
    public function setImageCommented(\BCL\ActivityBundle\Entity\Picture_Gallery $imageCommented)
    {
        $this->imageCommented = $imageCommented;

        return $this;
    }

    /**
     * Get imageCommented
     *
     * @return \BCL\ActivityBundle\Entity\Picture_Gallery
     */
    public function getImageCommented()
    {
        return $this->imageCommented;
    }

    /**
     * Set userCommented
     *
     * @param \BCL\UserBundle\Entity\Users $userCommented
     *
     * @return PictureComment
     */
    public function setUserCommented(\BCL\UserBundle\Entity\Users $userCommented)
    {
        $this->userCommented = $userCommented;

        return $this;
    }

    /**
     * Get userCommented
     *
     * @return \BCL\UserBundle\Entity\Users
     */
    public function getUserCommented()
    {
        return $this->userCommented;
    }
}
