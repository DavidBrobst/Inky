<?php

namespace Inky\QuizBundle\Entity\Question;

use Doctrine\ORM\Mapping as ORM;
use Inky\QuizBundle\Entity\Question\TfQuestion;
/**
 * Question
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\QuizBundle\Entity\Question\QuestionRepository")
 */
class Question
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
     * @ORM\Column(name="TypeOfQuestion", type="string", length=255)
     */
    private $TypeOfQuestion;
	
    private $TfQuestion;


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
     * Set TypeOfQuestion
     *
     * @param string $typeOfQuestion
     * @return Question
     */
    public function setTypeOfQuestion($typeOfQuestion)
    {
        $this->TypeOfQuestion = $typeOfQuestion;
    
        return $this;
    }

    /**
     * Get TypeOfQuestion
     *
     * @return string 
     */
    public function getTypeOfQuestion()
    {
        return $this->TypeOfQuestion;
    }
	
   public function setTfQuestion($TypeOfQuestion)
    {
        $this->TypeOfQuestion = $TypeOfQuestion;
		return $this;
    }	
   public function getTfQuestion()
    {
        return $this->TypeOfQuestion;
    }
}