<?php

namespace BCL\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="BCL\UserBundle\Repository\UsersRepository")
 */
class Users
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
     * @ORM\Column(name="First_Name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="Last_Name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=255)
     */
    private $password;

    private $confirmPassword;



    /**
     * @var string
     *
     * @ORM\Column(name="Url_Picture", type="string", length=255, nullable=true)
     */
    private $urlPicture;

    /**
     * @ORM\ManyToOne(targetEntity="BCL\UserBundle\Entity\Status")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="BCL\UserBundle\Entity\Schoolyear")
     * @ORM\JoinColumn(nullable=true)
     */
    private $schoolyear;

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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Users
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Users
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set urlPicture
     *
     * @param string $urlPicture
     *
     * @return Users
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
     * Set status
     *
     * @param \BCL\UserBundle\Entity\Status $status
     *
     * @return Users
     */
    public function setStatus(\BCL\UserBundle\Entity\Status $status)
    {
        $this->status = $status;

        return $this;
    }


    /**
     * Get status
     *
     * @return \BCL\UserBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set schoolyear
     *
     * @param \BCL\UserBundle\Entity\Schoolyear $schoolyear
     *
     * @return Users
     */
    public function setSchoolyear(\BCL\UserBundle\Entity\Schoolyear $schoolyear)
    {
        $this->schoolyear = $schoolyear;

        return $this;
    }

    /**
     * Get schoolyear
     *
     * @return \BCL\UserBundle\Entity\Schoolyear
     */
    public function getSchoolyear()
    {
        return $this->schoolyear;
    }

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
    }
}
