<?php

namespace Inky\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quiz
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\QuizBundle\Entity\QuizRepository")
 */
class Quiz
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
     * @var boolean
     *
     * @ORM\Column(name="isPublic", type="boolean")
     */
    private $isPublic;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;
	
	/**
     * @ORM\OneToMany(targetEntity="Inky\CourseBundle\Entity\InkyChap\InkyQuiz",cascade={"persist"}, mappedBy="quiz")
     */
    private $InkyQuiz;
	
	/**
     * @ORM\OneToMany(targetEntity="Inky\QuizBundle\Entity\Question\TfQuestion",cascade={"persist"}, mappedBy="quiz")
     */
    private $TfQuestion;
	
	/**
     * @ORM\OneToMany(targetEntity="Inky\QuizBundle\Entity\Question\McQuestion",cascade={"persist"}, mappedBy="quiz")
     */
    private $McQuestion;
	
	/**
     * @ORM\OneToMany(targetEntity="Inky\QuizBundle\Entity\Question\InputQuestion",cascade={"persist"}, mappedBy="quiz")
     */
    private $InputQuestion;
	
	/**
     * @ORM\OneToMany(targetEntity="Inky\QuizBundle\Entity\Question\SubmitQuestion",cascade={"persist"}, mappedBy="quiz")
     */
    private $SubmitQuestion;
	

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
     * @return Quiz
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
     * Set descritpion
     *
     * @param string $descritpion
     * @return Quiz
     */
    public function setDescritpion($descritpion)
    {
        $this->descritpion = $descritpion;
    
        return $this;
    }

    /**
     * Get descritpion
     *
     * @return string 
     */
    public function getDescritpion()
    {
        return $this->descritpion;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Quiz
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
     * @return Quiz
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
     * Set isPublic
     *
     * @param boolean $isPublic
     * @return Quiz
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Quiz
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->question = new \Doctrine\Common\Collections\ArrayCollection();
		$this->createdAt     = new \Datetime;
		$this->updatedAt     = new \Datetime;
		$this->isActive     = true;
    }
    
    /**
     * Add question
     *
     * @param \Inky\QuizBundle\Entity\Quiz $question
     * @return Quiz
     */
    public function addQuestion(\Inky\QuizBundle\Entity\Quiz $question)
    {
        $this->question[] = $question;
    
        return $this;
    }

    /**
     * Remove question
     *
     * @param \Inky\QuizBundle\Entity\Quiz $question
     */
    public function removeQuestion(\Inky\QuizBundle\Entity\Quiz $question)
    {
        $this->question->removeElement($question);
    }

    /**
     * Get question
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuestion()
    {
        return $this->question;
    }


    /**
     * Set description
     *
     * @param string $description
     * @return Quiz
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
     * Add TfQuestion
     *
     * @param \Inky\QuizBundle\Entity\Question\TfQuestion $tfQuestion
     * @return Quiz
     */
    public function addTfQuestion(\Inky\QuizBundle\Entity\Question\TfQuestion $tfQuestion)
    {
        $this->TfQuestion[] = $tfQuestion;
    
        return $this;
    }

    /**
     * Remove TfQuestion
     *
     * @param \Inky\QuizBundle\Entity\Question\TfQuestion $tfQuestion
     */
    public function removeTfQuestion(\Inky\QuizBundle\Entity\Question\TfQuestion $tfQuestion)
    {
        $this->TfQuestion->removeElement($tfQuestion);
    }

    /**
     * Get TfQuestion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTfQuestion()
    {
        return $this->TfQuestion;
    }

    /**
     * Add McQuestion
     *
     * @param \Inky\QuizBundle\Entity\Question\McQuestion $mcQuestion
     * @return Quiz
     */
    public function addMcQuestion(\Inky\QuizBundle\Entity\Question\McQuestion $mcQuestion)
    {
        $this->McQuestion[] = $mcQuestion;
    
        return $this;
    }

    /**
     * Remove McQuestion
     *
     * @param \Inky\QuizBundle\Entity\Question\McQuestion $mcQuestion
     */
    public function removeMcQuestion(\Inky\QuizBundle\Entity\Question\McQuestion $mcQuestion)
    {
        $this->McQuestion->removeElement($mcQuestion);
    }

    /**
     * Get McQuestion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMcQuestion()
    {
        return $this->McQuestion;
    }

    /**
     * Add InputQuestion
     *
     * @param \Inky\QuizBundle\Entity\Question\INputQuestion $inputQuestion
     * @return Quiz
     */
    public function addInputQuestion(\Inky\QuizBundle\Entity\Question\INputQuestion $inputQuestion)
    {
        $this->InputQuestion[] = $inputQuestion;
    
        return $this;
    }

    /**
     * Remove InputQuestion
     *
     * @param \Inky\QuizBundle\Entity\Question\INputQuestion $inputQuestion
     */
    public function removeInputQuestion(\Inky\QuizBundle\Entity\Question\INputQuestion $inputQuestion)
    {
        $this->InputQuestion->removeElement($inputQuestion);
    }

    /**
     * Get InputQuestion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInputQuestion()
    {
        return $this->InputQuestion;
    }

    /**
     * Add SubmitQuestion
     *
     * @param \Inky\QuizBundle\Entity\Question\SubmitQuestion $submitQuestion
     * @return Quiz
     */
    public function addSubmitQuestion(\Inky\QuizBundle\Entity\Question\SubmitQuestion $submitQuestion)
    {
        $this->SubmitQuestion[] = $submitQuestion;
    
        return $this;
    }

    /**
     * Remove SubmitQuestion
     *
     * @param \Inky\QuizBundle\Entity\Question\SubmitQuestion $submitQuestion
     */
    public function removeSubmitQuestion(\Inky\QuizBundle\Entity\Question\SubmitQuestion $submitQuestion)
    {
        $this->SubmitQuestion->removeElement($submitQuestion);
    }

    /**
     * Get SubmitQuestion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubmitQuestion()
    {
        return $this->SubmitQuestion;
    }


    /**
     * Add InkyQuiz
     *
     * @param \Inky\CourseBundle\Entity\InkyChap\InkyQuiz $inkyQuiz
     * @return Quiz
     */
    public function addInkyQuiz(\Inky\CourseBundle\Entity\InkyChap\InkyQuiz $inkyQuiz)
    {
        $this->InkyQuiz[] = $inkyQuiz;
    
        return $this;
    }

    /**
     * Remove InkyQuiz
     *
     * @param \Inky\CourseBundle\Entity\InkyChap\InkyQuiz $inkyQuiz
     */
    public function removeInkyQuiz(\Inky\CourseBundle\Entity\InkyChap\InkyQuiz $inkyQuiz)
    {
        $this->InkyQuiz->removeElement($inkyQuiz);
    }

    /**
     * Get InkyQuiz
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInkyQuiz()
    {
        return $this->InkyQuiz;
    }
}