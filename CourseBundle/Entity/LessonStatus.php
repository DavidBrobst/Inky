<?php

namespace Inky\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LessonStatus
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\CourseBundle\Entity\LessonStatusRepository")
 */
class LessonStatus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
     protected $id;
	 
	 /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

	/**
	* 
	* @ORM\ManyToOne(targetEntity="Inky\CourseBundle\Entity\Lesson", cascade={"persist"}, inversedBy="lessonStatus" )
	* 
	*/
	private $lesson;
	
	/**
	* 
	* @ORM\ManyToOne(targetEntity="Inky\UserBundle\Entity\User", cascade={"persist"})
	*/
	private $user;


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
     * Set status
     *
     * @param integer $status
     * @return LessonStatus
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set lesson
     *
     * @param \Inky\CourseBundle\Entity\Lesson $lesson
     * @return LessonStatus
     */
    public function setLesson(\Inky\CourseBundle\Entity\Lesson $lesson)
    {
        $this->lesson = $lesson;
    
        return $this;
    }

    /**
     * Get lesson
     *
     * @return \Inky\CourseBundle\Entity\Lesson 
     */
    public function getLesson()
    {
        return $this->lesson;
    }

    /**
     * Set user
     *
     * @param \Inky\UserBundle\Entity\User $user
     * @return LessonStatus
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
}