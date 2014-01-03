<?php

namespace Inky\CourseBundle\Entity\InkyChap;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * InkyQuiz
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\CourseBundle\Entity\InkyChap\InkyQuizRepository")
 */
class InkyQuiz
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
     * @ORM\ManyToOne(targetEntity="Inky\CourseBundle\Entity\InkyChap\InkyChap",cascade={"persist"})
     */
    private $inkyChap;
	
	/**
     * @ORM\ManyToOne(targetEntity="Inky\QuizBundle\Entity\Quiz", inversedBy="InkyQuiz")
     * 
     */
    private $quiz;
	
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
     * Set InkyChap
     *
     * @param \Inky\CourseBundle\Entity\InkyChap\InkyChap $inkyChap
     * @return InkyQuiz
     */
    public function setInkyChap(\Inky\CourseBundle\Entity\InkyChap\InkyChap $inkyChap = null)
    {
        $this->InkyChap = $inkyChap;
    
        return $this;
    }

    /**
     * Get InkyChap
     *
     * @return \Inky\CourseBundle\Entity\InkyChap\InkyChap 
     */
    public function getInkyChap()
    {
        return $this->InkyChap;
    }

    /**
     * Set quiz
     *
     * @param \Inky\QuizBundle\Entity\Quiz $quiz
     * @return InkyQuiz
     */
    public function setQuiz(\Inky\QuizBundle\Entity\Quiz $quiz = null)
    {
        $this->quiz = $quiz;
    
        return $this;
    }

    /**
     * Get quiz
     *
     * @return \Inky\QuizBundle\Entity\Quiz 
     */
    public function getQuiz()
    {
        return $this->quiz;
    }
}