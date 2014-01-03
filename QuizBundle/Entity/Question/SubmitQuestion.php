<?php

namespace Inky\QuizBundle\Entity\Question;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubmitQuestion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\QuizBundle\Entity\Question\SubmitQuestionRepository")
 */
class SubmitQuestion
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
     * @ORM\Column(name="content", type="text")
     */

	private $content;
	/**
     * @ORM\ManyToOne(targetEntity="Inky\QuizBundle\Entity\Quiz", inversedBy="SubmitQuestion")
     * 
     */
    private $quiz;
	
 	/**
	 * @ORM\Id
     * @ORM\OneToMany(targetEntity="Inky\QuizBundle\Entity\Answer\SubmitAnswer", mappedBy="question",cascade={"persist", "remove"})
     */
    private $answer;
	

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
     * @return SubmitQuestion
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
     * @return SubmitQuestion
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
     * @param \Inky\QuizBundle\Entity\Answer\SubmitAnswer $answer
     * @return SubmitQuestion
     */
    public function addAnswer(\Inky\QuizBundle\Entity\Answer\SubmitAnswer $answer)
    {
        $this->answer[] = $answer;
    
        return $this;
    }

    /**
     * Remove answer
     *
     * @param \Inky\QuizBundle\Entity\Answer\SubmitAnswer $answer
     */
    public function removeAnswer(\Inky\QuizBundle\Entity\Answer\SubmitAnswer $answer)
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
}