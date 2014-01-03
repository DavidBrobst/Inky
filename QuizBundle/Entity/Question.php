<?php

namespace Inky\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\QuizBundle\Entity\QuestionRepository")
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
     * @ORM\Column(name="qContent", type="text")
     */
    private $qContent;

    /**
     * @var integer
     *
     * @ORM\Column(name="qType", type="smallint")
     */
    private $qType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

	/**
     * @ORM\ManyToOne(targetEntity="Inky\QuizBundle\Entity\Quiz", inversedBy="question")
     * 
     */
    private $quiz;
	
 	/**
	 * @ORM\Id
     * @ORM\OneToMany(targetEntity="Inky\QuizBundle\Entity\Answer", mappedBy="question",cascade={"persist", "remove"})
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
     * Set qContent
     *
     * @param string $qContent
     * @return Question
     */
    public function setQContent($qContent)
    {
        $this->qContent = $qContent;
    
        return $this;
    }

    /**
     * Get qContent
     *
     * @return string 
     */
    public function getQContent()
    {
        return $this->qContent;
    }

    /**
     * Set qType
     *
     * @param integer $qType
     * @return Question
     */
    public function setQType($qType)
    {
        $this->qType = $qType;
    
        return $this;
    }

    /**
     * Get qType
     *
     * @return integer 
     */
    public function getQType()
    {
        return $this->qType;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Question
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Question
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answer        = new \Doctrine\Common\Collections\ArrayCollection();
		$this->createdAt     = new \Datetime;
		$this->updatedAt     = new \Datetime;
    }
    
    /**
     * Set question
     *
     * @param \Inky\QuizBundle\Quiz $question
     * @return Question
     */
    public function setQuestion(\Inky\QuizBundle\Quiz $question = null)
    {
        $this->question = $question;
		$question->setQuiz($this);
        return $this;
    }

    /**
     * Get question
     *
     * @return \Inky\QuizBundle\Quiz 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Add answer
     *
     * @param \Inky\QuizBundle\Answer $answer
     * @return Question
     */
    public function addAnswer(\Inky\QuizBundle\Entity\Answer $answer)
    {
        $this->answer[] = $answer;
        return $this;
    }

    /**
     * Remove answer
     *
     * @param \Inky\QuizBundle\Answer $answer
     */
    public function removeAnswer(\Inky\QuizBundle\Answer $answer)
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
     * Set quiz
     *
     * @param \Inky\QuizBundle\Quiz $quiz
     * @return Question
     */
    public function setQuiz(\Inky\QuizBundle\Entity\Quiz $quiz)
    {
        $this->quiz = $quiz;
    
        return $this;
    }

    /**
     * Get quiz
     * @return \Inky\QuizBundle\Quiz 
     */
    public function getQuiz()
    {
        return $this->quiz;
    }
}