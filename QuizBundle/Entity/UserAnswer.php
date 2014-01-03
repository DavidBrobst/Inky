<?php

namespace Inky\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAswer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\QuizBundle\Entity\UserAnswerRepository")
 */
class UserAnswer
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="answerText", type="text")
     */
    private $answerText;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isLocked", type="boolean")
     */
    private $isLocked;


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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UserAnswer
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
     * Set answerText
     *
     * @param string $answerText
     * @return UserAnswer
     */
    public function setAnswerText($answerText)
    {
        $this->answerText = $answerText;
    
        return $this;
    }

    /**
     * Get answerText
     *
     * @return string 
     */
    public function getAnswerText()
    {
        return $this->answerText;
    }

    /**
     * Set isLocked
     *
     * @param boolean $isLocked
     * @return UserAnswer
     */
    public function setIsLocked($isLocked)
    {
        $this->isLocked = $isLocked;
    
        return $this;
    }

    /**
     * Get isLocked
     *
     * @return boolean 
     */
    public function getIsLocked()
    {
        return $this->isLocked;
    }
}
