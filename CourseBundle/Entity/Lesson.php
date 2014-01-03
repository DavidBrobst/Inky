<?php

namespace Inky\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lesson
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\CourseBundle\Entity\LessonRepository")
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
     * @var text
     *
     * @ORM\Column(name="Content", type="text")
     */
    private $content;

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
	 * @ORM\ManyToOne(targetEntity="Inky\CourseBundle\Entity\Course",cascade={"persist"}, inversedBy="lesson")
	 */
	private $course;
	
	/**
	* @ORM\ManyToOne(targetEntity="Inky\UserBundle\Entity\User")
	*/
	private $user;
	
	/**
	* @ORM\ManyToMany(targetEntity="Inky\CourseBundle\Entity\Tag",cascade={"persist"}, mappedBy="lesson")
	* @ORM\JoinColumn(nullable=true)
	*/
	private $tags;
	
	/**
	* @ORM\OneToMany(targetEntity="Inky\CourseBundle\Entity\LessonStatus", cascade={"persist", "remove"}, mappedBy="lesson")
	*
	*/
	private $lessonStatus;
	
	/**
	* @ORM\OneToOne(targetEntity="Inky\CourseBundle\Entity\Thread")
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
     * Set content
     *
     * @param string $content
     * @return Lesson
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
     * @param \Inky\CourseBundle\Entity\Course $course
     * @return Lesson
     */
    public function setCourse(\Inky\CourseBundle\Entity\Course $course = null)
    {
		$this->course = $course;
         return $this;
    }

    /**
     * Get course
     *
     * @return \Inky\CourseBundle\Entity\Course 
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
     * @param \Inky\CourseBundle\Entity\Tag $tags
     */
    public function removeTag(\Inky\CourseBundle\Entity\Tag $tags)
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
     * Add lessonStatus
     *
     * @param \Inky\CourseBundle\Entity\LessonStatus $lessonStatus
     * @return Lesson
     */
    public function addLessonStatu(\Inky\CourseBundle\Entity\LessonStatus $lessonStatus)
    {
        $this->lessonStatus[] = $lessonStatus;
    
        return $this;
    }

    /**
     * Remove lessonStatus
     *
     * @param \Inky\CourseBundle\Entity\LessonStatus $lessonStatus
     */
    public function removeLessonStatu(\Inky\CourseBundle\Entity\LessonStatus $lessonStatus)
    {
        $this->lessonStatus->removeElement($lessonStatus);
    }

    /**
     * Get lessonStatus
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLessonStatus()
    {
        return $this->lessonStatus;
    }

    /**
     * Set askThread
     *
     * @param \Inky\CourseBundle\Entity\Thread $askThread
     * @return Lesson
     */
    public function setAskThread(\Inky\CourseBundle\Entity\Thread $askThread = null)
    {
        $this->askThread = $askThread;
    
        return $this;
    }

    /**
     * Get askThread
     *
     * @return \Inky\CourseBundle\Entity\Thread 
     */
    public function getAskThread()
    {
        return $this->askThread;
    }
}