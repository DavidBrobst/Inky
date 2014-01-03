<?php

namespace Inky\CourseBundle\Entity\InkyChap;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * InkyChapAdvancement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\CourseBundle\Entity\InkyChap\InkychapAdvancementRepository")
 */
class InkyChapAdvancement
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
     * @var boolean
     *
     * @ORM\Column(name="completed", type="boolean")
     */
    private $completed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finished_date", type="datetime")
     */
    private $finishedDate;

	/**
	* 
	* @ORM\ManyToOne(targetEntity="Inky\CourseBundle\Entity\InkyChap\InkyChap", cascade={"persist"})
	* 
	*/
	private $inkychap;
	
	/**
	* 
	* @ORM\ManyToOne(targetEntity="Inky\UserBundle\Entity\User", cascade={"persist"})
	*/
	private $user;

	public function __construct()
	{
		$this->finishedDate = new \datetime;
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
     * Set completed
     *
     * @param boolean $completed
     * @return InkychapAdvancement
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;
    
        return $this;
    }

    /**
     * Get completed
     *
     * @return boolean 
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Set finishedDate
     *
     * @param \DateTime $finishedDate
     * @return InkychapAdvancement
     */
    public function setFinishedDate($finishedDate)
    {
        $this->finishedDate = $finishedDate;
    
        return $this;
    }

    /**
     * Get finishedDate
     *
     * @return \DateTime 
     */
    public function getFinishedDate()
    {
        return $this->finishedDate;
    }

    /**
     * Set inkychap
     *
     * @param \Inky\CourseBundle\Entity\InkyChap\InkyChap $inkychap
     * @return InkyChapAdvancement
     */
    public function setInkychap(\Inky\CourseBundle\Entity\InkyChap\InkyChap $inkychap = null)
    {
        $this->inkychap = $inkychap;
    
        return $this;
    }

    /**
     * Get inkychap
     *
     * @return \Inky\CourseBundle\Entity\InkyChap\InkyChap 
     */
    public function getInkychap()
    {
        return $this->inkychap;
    }

    /**
     * Set user
     *
     * @param \Inky\UserBundle\Entity\User $user
     * @return InkyChapAdvancement
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