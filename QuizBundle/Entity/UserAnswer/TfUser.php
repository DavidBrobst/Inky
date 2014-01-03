<?php

namespace Inky\QuizBundle\Entity\UserAnswer;

use Doctrine\ORM\Mapping as ORM;

/**
 * TfUser
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TfUser
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
     * @var boolean
     *
     * @ORM\Column(name="answer", type="boolean")
     */
    private $answer;

	/**
     * @ORM\ManyToOne(targetEntity="Inky\QuizBundle\Entity\Question\TfQuestion",cascade={"persist"})
     */
    private $question;
	
	/**
	* @ORM\ManyToOne(targetEntity="Inky\UserBundle\Entity\User")
	*/
	private $user;
	

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
     * Set answer
     *
     * @param boolean $answer
     * @return TfUser
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    
        return $this;
    }

    /**
     * Get answer
     *
     * @return boolean 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set question
     *
     * @param \Inky\QuizBundle\Entity\Question\TfQuestion $question
     * @return TfUser
     */
    public function setQuestion(\Inky\QuizBundle\Entity\Question\TfQuestion $question = null)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return \Inky\QuizBundle\Entity\Question\TfQuestion 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set user
     *
     * @param \Inky\UserBundle\Entity\User $user
     * @return TfUser
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