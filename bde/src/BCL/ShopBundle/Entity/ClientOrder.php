<?php

namespace BCL\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientOrder
 *
 * @ORM\Table(name="client_order")
 * @ORM\Entity(repositoryClass="BCL\ShopBundle\Repository\ClientOrderRepository")
 */
class ClientOrder
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
     * @ORM\Column(name="Date_Order", type="date")
     */
    private $dateOrder;

    /**
     * @var bool
     *
     * @ORM\Column(name="Paid", type="boolean")
     */
    private $paid;


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
     * Set dateOrder
     *
     * @param \DateTime $dateOrder
     *
     * @return ClientOrder
     */
    public function setDateOrder($dateOrder)
    {
        $this->dateOrder = $dateOrder;

        return $this;
    }

    /**
     * Get dateOrder
     *
     * @return \DateTime
     */
    public function getDateOrder()
    {
        return $this->dateOrder;
    }

    /**
     * Set paid
     *
     * @param boolean $paid
     *
     * @return ClientOrder
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return bool
     */
    public function getPaid()
    {
        return $this->paid;
    }
}

