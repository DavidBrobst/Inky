<?php

namespace Inky\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Point
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\UserBundle\Entity\PointRepository")
 */
class Point
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
	* @ORM\ManyToOne(targetEntity="Inky\UserBundle\Entity\User")
	* @ORM\JoinColumn(nullable=false)
	*/
     private $user;
	
    /**
	* @ORM\ManyToOne(targetEntity="Inky\UserBundle\Entity\PointAction")
	* @ORM\JoinColumn(nullable=false)
	*/
    private $action;
	
	public function __construct()
    {
        $this->date = new \Datetime;
    }
	
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
     * Set date
     *
     * @param \DateTime $date
     * @return Point
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set user
     *
     * @param \Inky\UserBundle\Entity\User $user
     * @return Point
     */
    public function setUser(\Inky\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Inky\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set action
     *
     * @param \Inky\UserBundle\Entity\PointAction $action
     * @return Point
     */
    public function setAction(\Inky\UserBundle\Entity\PointAction $action)
    {
        $this->action = $action;
    
        return $this;
    }

    /**
     * Get action
     *
     * @return \Inky\UserBundle\Entity\PointAction 
     */
    public function getAction()
    {
        return $this->action;
    }
}