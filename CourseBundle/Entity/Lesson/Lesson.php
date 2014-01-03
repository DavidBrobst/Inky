<?php

namespace Inky\CourseBundle\Entity\Lesson;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Lesson
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\CourseBundle\Entity\Lesson\LessonRepository")
 */
class Lesson
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isPublic", type="boolean")
     */
    private $isPublic;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="orderid", type="smallint", nullable=true)
     */
    private $orderid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastUpdate", type="datetime")
     */
    private $lastUpdate;

    /**
     * @var \Date
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

	/**
	 * @ORM\ManyToOne(targetEntity="Inky\CourseBundle\Entity\Course\Course",cascade={"persist"}, inversedBy="lesson")
	 */
	private $course;
	
	/**
	* @ORM\ManyToOne(targetEntity="Inky\UserBundle\Entity\User")
	*/
	private $user;
	
	/**
	* @ORM\ManyToMany(targetEntity="Inky\CourseBundle\Entity\Tag\Tag",cascade={"persist"}, mappedBy="lesson")
	* @ORM\JoinColumn(nullable=true)
	*/
	private $tags;
		
	/**
	* @ORM\OneToOne(targetEntity="Inky\CourseBundle\Entity\Comment\Thread")
	*
	*/
	private $askThread;
	

    /**
     * Constructor
     */
    public function __construct()
    {
		$this->date = new \Datetime;
		$this->lastUpdate = new \Datetime;
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Lesson
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

 
    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     * @return Lesson
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    
        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean 
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return Lesson
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    
        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime 
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Lesson
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
     * Set course
     *
     * @param \Inky\CourseBundle\Entity\Course\Course $course
     * @return Lesson
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
     * @return Lesson
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

    /**
     * Add tags
     *
     * @param \Inky\CourseBundle\Entity\Tag $tags
     * @return Lesson
     */
    public function addTag($tags)
    {
        $this->tags[] = $tags;
    
        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Inky\CourseBundle\Entity\Tag\Tag $tags
     */
    public function removeTag(\Inky\CourseBundle\Entity\Tag\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set orderid
     *
     * @param integer $orderid
     * @return Lesson
     */
    public function setOrderid($orderid)
    {
        $this->orderid = $orderid;
    
        return $this;
    }

    /**
     * Get orderid
     *
     * @return integer 
     */
    public function getOrderid()
    {
        return $this->orderid;
    }

    /**
     * Set askThread
     *
     * @param \Inky\CourseBundle\Entity\Comment\Thread $askThread
     * @return Lesson
     */
    public function setAskThread(\Inky\CourseBundle\Entity\Comment\Thread $askThread = null)
    {
        $this->askThread = $askThread;
    
        return $this;
    }

    /**
     * Get askThread
     *
     * @return \Inky\CourseBundle\Entity\Comment\Thread 
     */
    public function getAskThread()
    {
        return $this->askThread;
    }
}