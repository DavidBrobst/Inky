<?php

namespace Inky\QuizBundle\Entity\Question;

use Doctrine\ORM\Mapping as ORM;

/**
 * McQuestion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\QuizBundle\Entity\Question\McQuestionRepository")
 */
class McQuestion
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
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

	/**
     * @ORM\ManyToOne(targetEntity="Inky\QuizBundle\Entity\Quiz", inversedBy="McQuestion")
     * 
     */
    private $quiz;
	
 	/**
	 * @ORM\Id
     * @ORM\OneToMany(targetEntity="Inky\QuizBundle\Entity\Answer\McAnswer", mappedBy="question",cascade={"persist", "remove"})
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
     * @return McQuestion
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return McQuestion
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
     * @return McQuestion
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
        $this->answer = new \Doctrine\Common\Collections\ArrayCollection();
		$this->createdAt = new \Datetime;
		$this->updatedAt = new \Datetime;
    }
    
    /**
     * Set quiz
     *
     * @param \Inky\QuizBundle\Entity\Quiz $quiz
     * @return McQuestion
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
     * @param \Inky\QuizBundle\Entity\Answer\mcAnswer $answer
     * @return McQuestion
     */
    public function addAnswer(\Inky\QuizBundle\Entity\Answer\mcAnswer $answer)
    {
        $this->answer[] = $answer;
    
        return $this;
    }

    /**
     * Remove answer
     *
     * @param \Inky\QuizBundle\Entity\Answer\mcAnswer $answer
     */
    public function removeAnswer(\Inky\QuizBundle\Entity\Answer\mcAnswer $answer)
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