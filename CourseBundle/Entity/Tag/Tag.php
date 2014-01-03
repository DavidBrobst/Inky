<?php

namespace Inky\CourseBundle\Entity\Tag;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\CourseBundle\Entity\Tag\TagRepository")
 */
class Tag
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
     * @ORM\Column(name="tagLabel", type="string", length=255)
     */
    private $tagLabel;


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
	 * @ORM\ManyToMany(targetEntity="Inky\CourseBundle\Entity\Course\Course", inversedBy="tags")
	 * @ORM\JoinColumn(nullable=false)
	*/
	 private $course;

	 /**
	 * @ORM\ManyToMany(targetEntity="Inky\CourseBundle\Entity\Lesson\Lesson", inversedBy="tags")
	 * @ORM\JoinColumn(nullable=false)
	*/
	 private $lesson;

    /**
     * Set tagLabel
     *
     * @param string $tagLabel
     * @return Tag
     */
    public function setTagLabel($tagLabel)
    {
        $this->tagLabel = $tagLabel;
    
        return $this;
    }

    /**
     * Get tagLabel
     *
     * @return string 
     */
    public function getTagLabel()
    {
        return $this->tagLabel;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->course = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lesson = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add course
     *
     * @param \Inky\CourseBundle\Entity\Course\Course $course
     * @return Tag
     */
    public function addCourse(\Inky\CourseBundle\Entity\Course\Course $course)
    {
        $this->course[] = $course;
    
        return $this;
    }

    /**
     * Remove course
     *
     * @param \Inky\CourseBundle\Entity\Course $course
     */
    public function removeCourse(\Inky\CourseBundle\Entity\Course\Course $course)
    {
        $this->course->removeElement($course);
    }

    /**
     * Get course
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Add lesson
     *
     * @param \Inky\CourseBundle\Entity\Lesson\Lesson $lesson
     * @return Tag
     */
    public function setLesson(\Inky\CourseBundle\Entity\Lesson\Lesson $lesson)
    {
        $lesson-> addTag($this);
		$this->lesson[] = $lesson;
    }

    /**
     * Remove lesson
     *
     * @param \Inky\CourseBundle\Entity\Lesson\Lesson $lesson
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
}