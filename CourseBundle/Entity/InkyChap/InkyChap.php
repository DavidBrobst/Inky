<?php

namespace Inky\CourseBundle\Entity\InkyChap;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * InkyChap
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\CourseBundle\Entity\InkyChap\InkyChapRepository")
 */
class InkyChap
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
     * @ORM\Column(name="title", type="string", length=150)
	 * @Assert\Length(
     *      min = "5",
     *      max = "150",
     *      minMessage = "Le titre doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le titre ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=25)
	 * @Assert\Length(
     *      min = "6",
     *      max = "25"
     * )
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="orderId", type="smallint")
     */
    private $orderId;

	/**
     * @ORM\ManyToOne(targetEntity="Inky\CourseBundle\Entity\Lesson\Lesson",  cascade={"persist","remove"}, inversedBy="inkychap")
     */
    private $lesson;
	
	// Defining different InkyChap types
	const VIDEO_TYPE = 'Video';
	const TEXT_TYPE = 'Text';
	const QUIZ_TYPE = 'Quiz';

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
     * @return InkyChap
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
     * Set type
     *
     * @param string $type
     * @return InkyChap
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }
	
	public static function getTypeList()
	{
	return array(
				self::VIDEO_TYPE, 
				self::TEXT_TYPE, 
				self::QUIZ_TYPE
				);
	}
	
    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set orderId
     *
     * @param integer $orderId
     * @return InkyChap
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    
        return $this;
    }

    /**
     * Get orderId
     *
     * @return integer 
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set lesson
     *
     * @param \Inky\CourseBundle\Entity\Lesson\Lesson $lesson
     * @return InkyChap
     */
    public function setLesson(\Inky\CourseBundle\Entity\Lesson\Lesson $lesson = null)
    {
        $this->lesson = $lesson;
    
        return $this;
    }

    /**
     * Get lesson
     *
     * @return \Inky\CourseBundle\Entity\Lesson\Lesson 
     */
    public function getLesson()
    {
        return $this->lesson;
    }
}