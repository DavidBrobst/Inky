<?php

namespace Inky\QuizBundle\Entity\Answer;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\QuizBundle\Entity\Answer\AnswerRepository")
 */
class Answer
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
     * @ORM\Column(name="aContent", type="string", length=255)
     */
    private $aContent;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isRight", type="boolean")
     */
    private $isRight;

	/**
     * @ORM\ManyToOne(targetEntity="Inky\QuizBundle\Entity\Question\Question",cascade={"persist"}, inversedBy="answer")
     */
    private $question;

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
     * Set aContent
     *
     * @param string $aContent
     * @return Answer
     */
    public function setAContent($aContent)
    {
        $this->aContent = $aContent;
    
        return $this;
    }

    /**
     * Get aContent
     *
     * @return string 
     */
    public function getAContent()
    {
        return $this->aContent;
    }

    /**
     * Set isRight
     *
     * @param boolean $isRight
     * @return Answer
     */
    public function setIsRight($isRight)
    {
        $this->isRight = $isRight;
    
        return $this;
    }

    /**
     * Get isRight
     *
     * @return boolean 
     */
    public function getIsRight()
    {
        return $this->isRight;
    }

    /**
     * Set question
     *
     * @param \Inky\QuizBundle\Entity\Question $question
     * @return Answer
     */
    public function setQuestion(\Inky\QuizBundle\Entity\Question $question)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return \Inky\QuizBundle\Entity\Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set user
     *
     * @param \Inky\UserBundle\Entity\User $user
     * @return Answer
     */
    public function setUser(\Inky\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Inky\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}