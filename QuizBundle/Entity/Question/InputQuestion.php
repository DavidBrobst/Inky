<?php

namespace Inky\QuizBundle\Entity\Question;

use Doctrine\ORM\Mapping as ORM;

/**
 * InputQuestion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\QuizBundle\Entity\Question\InputQuestionRepository")
 */
class InputQuestion
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
     * @ORM\Column(name="content", type="string", length=1000)
     */
    private $content;
	/**
     * @ORM\ManyToOne(targetEntity="Inky\QuizBundle\Entity\Quiz", inversedBy="InputQuestion")
     * 
     */
    private $quiz;
	
 	/**
	 * @ORM\Id
     * @ORM\OneToMany(targetEntity="Inky\QuizBundle\Entity\Answer\InputAnswer", mappedBy="question",cascade={"persist", "remove"})
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
     * @return InputQuestion
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
     * @return InputQuestion
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
     * @param \Inky\QuizBundle\Entity\Answer\inputAnswer $answer
     * @return InputQuestion
     */
    public function addAnswer(\Inky\QuizBundle\Entity\Answer\inputAnswer $answer)
    {
        $this->answer[] = $answer;
    
        return $this;
    }

    /**
     * Remove answer
     *
     * @param \Inky\QuizBundle\Entity\Answer\inputAnswer $answer
     */
    public function removeAnswer(\Inky\QuizBundle\Entity\Answer\inputAnswer $answer)
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