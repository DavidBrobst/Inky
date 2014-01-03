<?php

namespace Inky\CourseBundle\Entity\Course;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subscribe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\CourseBundle\Entity\Course\SubscribeRepository")
 */
class Subscribe
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
     * @ORM\Column(name="SubscribeDate", type="datetime")
     */
    private $subscribeDate;
	
	/**
	* 
	* @ORM\ManyToOne(targetEntity="Inky\CourseBundle\Entity\Course\Course", cascade={"persist"})
	* 
	*/
	private $course;
	
	/**
	* 
	* @ORM\ManyToOne(targetEntity="Inky\UserBundle\Entity\User", cascade={"persist"})
	*/
	private $user;
	
	public function __construct()
	{
		$this->subscribeDate = new \Datetime;
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
     * Set subscribeDate
     *
     * @param \DateTime $subscribeDate
     * @return Subscribe
     */
    public function setSubscribeDate($subscribeDate)
    {
        $this->subscribeDate = $subscribeDate;
    
        return $this;
    }

    /**
     * Get subscribeDate
     *
     * @return \DateTime 
     */
    public function getSubscribeDate()
    {
        return $this->subscribeDate;
    }

    /**
     * Set course
     *
     * @param \Inky\CourseBundle\Entity\Course\Course $course
     * @return Subscribe
     */
    public function setCourse(\Inky\CourseBundle\Entity\Course\Course $course = null)
    {
        $this->course = $course;
    
        return $this;
    }

    /**
     * Get course
     *
     * @return \Inky\CourseBundle\Entity\Course\Course 
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set user
     *
     * @param \Inky\UserBundle\Entity\User $user
     * @return Subscribe
     */
    public function setUser(\Inky\UserBundle\Entity\User $user = null)
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
}