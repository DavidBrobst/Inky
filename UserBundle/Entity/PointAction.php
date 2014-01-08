<?php

namespace Inky\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PointAction
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\UserBundle\Entity\PointActionRepository")
 */
class PointAction
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="point", type="integer")
     */
    private $point;

    /**
     * @var string
     *
     * @ORM\Column(name="actionLabel", type="string", length=255)
     */
    private $actionLabel;


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
     * Set point
     *
     * @param integer $point
     * @return PointAction
     */
    public function setPoint($point)
    {
        $this->point = $point;
    
        return $this;
    }

    /**
     * Get point
     *
     * @return integer 
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Set actionLabel
     *
     * @param string $actionLabel
     * @return PointAction
     */
    public function setActionLabel($actionLabel)
    {
        $this->actionLabel = $actionLabel;
    
        return $this;
    }

    /**
     * Get actionLabel
     *
     * @return string 
     */
    public function getActionLabel()
    {
        return $this->actionLabel;
    }
}