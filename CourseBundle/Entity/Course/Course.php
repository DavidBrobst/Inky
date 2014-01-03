<?php

namespace Inky\CourseBundle\Entity\Course;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Course
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\CourseBundle\Entity\Course\CourseRepository")
 */
class Course
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
     * @ORM\Column(name="title", type="string")
	 * @Assert\Length(
     *      min = "6",
     *      max = "25"
     * )
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
	 * @Assert\DateTime()
     * )
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastUpdate", type="datetime")
	 * @Assert\DateTime()
     */
    private $lastUpdate;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
	 * @Assert\Length(max = "255" )
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="objective", type="string", length=255)
	 * @Assert\Length(max = "255" )
     */
    private $objective;
    /**
     * @var string
     *
     * @ORM\Column(name="prerequisite", type="string", length=255)
	 * @Assert\Length(max = "255" )
     */
    private $prerequisite;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isPublic", type="boolean")
     */
    private $isPublic;
	
	/**
	 * @ORM\OneToOne(targetEntity="Inky\CourseBundle\Entity\Course\Image", cascade={"persist", "remove"})
	 * @Assert\Valid()
	 */
	private $image;

	/**
	 * @ORM\OneToMany(targetEntity="Inky\UserBundle\Entity\Group", cascade={"persist", "remove"}, mappedBy="course")
	 */
	private $groups;
	
	/**
	 * @ORM\OneToMany(targetEntity="Inky\CourseBundle\Entity\Lesson\Lesson", cascade={"persist", "remove"}, mappedBy="course")
	 */
	private $lesson;
	
	/**
	* @ORM\ManyToOne(targetEntity="Inky\UserBundle\Entity\User")
	*/
	private $user;
	
	/**
	* @ORM\ManyToMany(targetEntity="Inky\CourseBundle\Entity\Tag\Tag",cascade={"persist"}, mappedBy="course")
	* @ORM\JoinColumn(nullable=false)
	*/
	private $tags;
	

    /**
     * Constructor
     */
    public function __construct()
    {
		$this->date = new \Datetime;
		$this->lastUpdate = new \Datetime;
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Course
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
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return Course
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
     * Set description
     *
     * @param string $description
     * @return Course
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     * @return Course
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
     * Set image
     *
     * @param \Inky\CourseBundle\Entity\Course\Image $image
     * @return Course
     */
    public function setImage(\Inky\CourseBundle\Entity\Course\Image $image = null)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return \Inky\CourseBundle\Entity\Course\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set user
     *
     * @param \Inky\UserBundle\Entity\User $user
     * @return Course
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
     * @param \Inky\CourseBundle\Entity\Tag\Tag $tags
     * @return Course
     */
    public function addTag(\Inky\CourseBundle\Entity\Tag\Tag $tags)
    {
        $this->tags[] = $tags;
    
        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Inky\CourseBundle\Entity\Tag $tags
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
     * Set title
     *
     * @param string $title
     * @return Course
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
     * Set objective
     *
     * @param string $objective
     * @return Course
     */
    public function setObjective($objective)
    {
        $this->objective = $objective;
    
        return $this;
    }

    /**
     * Get objective
     *
     * @return string 
     */
    public function getObjective()
    {
        return $this->objective;
    }

    /**
     * Set prerequisit
     *
     * @param string $prerequisit
     * @return Course
     */
    public function setPrerequisit($prerequisit)
    {
        $this->prerequisit = $prerequisit;
    
        return $this;
    }

    /**
     * Get prerequisit
     *
     * @return string 
     */
    public function getPrerequisit()
    {
        return $this->prerequisit;
    }

    /**
     * Add groups
     *
     * @param \Inky\UserBundle\Entity\Group $groups
     * @return Course
     */
    public function addGroup(\Inky\UserBundle\Entity\Group $groups)
    {
        $this->groups[] = $groups;
    
        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Inky\UserBundle\Entity\Group $groups
     */
    public function removeGroup(\Inky\UserBundle\Entity\Group $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Add lesson
     *
     * @param \Inky\CourseBundle\Entity\Lesson\Lesson $lesson
     * @return Course
     */
    public function addLesson(\Inky\CourseBundle\Entity\Lesson\Lesson $lesson)
    {
        $this->lesson[] = $lesson;
    
        return $this;
    }

    /**
     * Remove lesson
     *
     * @param \Inky\CourseBundle\Entity\Lesson $lesson
     */
    public function removeLesson(\Inky\CourseBundle\Entity\Lesson\Lesson $lesson)
    {
        $this->lesson->removeElement($lesson);
    }

    /**
     * Get lesson
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLesson()
    {
        return $this->lesson;
    }

    /**
     * Set prerequisite
     *
     * @param string $prerequisite
     * @return Course
     */
    public function setPrerequisite($prerequisite)
    {
        $this->prerequisite = $prerequisite;
    
        return $this;
    }

    /**
     * Get prerequisite
     *
     * @return string 
     */
    public function getPrerequisite()
    {
        return $this->prerequisite;
    }
}