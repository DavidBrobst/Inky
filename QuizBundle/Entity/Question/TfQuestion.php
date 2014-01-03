<?php

namespace Inky\QuizBundle\Entity\Question;

use Doctrine\ORM\Mapping as ORM;

/**
 * TfQuestion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\QuizBundle\Entity\Question\TfQuestionRepository")
 */
class TfQuestion
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
     * @ORM\Column(name="TfContent", type="string", length=1000)
     */
    private $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isTrue", type="boolean")
     */
    private $isTrue;

	/**
     * @ORM\ManyToOne(targetEntity="Inky\QuizBundle\Entity\Quiz", inversedBy="TfQuestion")
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
     * Set content
     *
     * @param string $content
     * @return TfQuestion
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
     * Set isTrue
     *
     * @param boolean $isTrue
     * @return TfQuestion
     */
    public function setIsTrue($isTrue)
    {
        $this->isTrue = $isTrue;
    
        return $this;
    }

    /**
     * Get isTrue
     *
     * @return boolean 
     */
    public function getIsTrue()
    {
        return $this->isTrue;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answer = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set quiz
     *
     * @param \Inky\QuizBundle\Entity\Quiz $quiz
     * @return TfQuestion
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

    /**
     * Add answer
     *
     * @param \Inky\QuizBundle\Entity\Answer\TfAnswer $answer
     * @return TfQuestion
     */
    public function addAnswer(\Inky\QuizBundle\Entity\Answer\TfAnswer $answer)
    {
        $this->answer[] = $answer;
    
        return $this;
    }

    /**
     * Remove answer
     *
     * @param \Inky\QuizBundle\Entity\Answer\TfAnswer $answer
     */
    public function removeAnswer(\Inky\QuizBundle\Entity\Answer\TfAnswer $answer)
    {
        $this->answer->removeElement($answer);
    }

    /**
     * Get answer
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set TfContent
     *
     * @param string $tfContent
     * @return TfQuestion
     */
    public function setTfContent($tfContent)
    {
        $this->TfContent = $tfContent;
    
        return $this;
    }

    /**
     * Get TfContent
     *
     * @return string 
     */
    public function getTfContent()
    {
        return $this->TfContent;
    }
}