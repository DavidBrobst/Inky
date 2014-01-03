<?php

namespace Inky\QuizBundle\Entity\UserAnswer;

use Doctrine\ORM\Mapping as ORM;

/**
 * McUser
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\QuizBundle\Entity\UserAnswer\McUserRepository")
 */
class McUser
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
     *
     * @ORM\ManyToOne(targetEntity="Inky\QuizBundle\Entity\Answer\mcAnswer",cascade={"persist"})
     */
    private $answer;

	/**
     * @ORM\ManyToOne(targetEntity="Inky\QuizBundle\Entity\Question\mcQuestion",cascade={"persist"})
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
     * @param \Inky\QuizBundle\Entity\Answer\mcAnswer $answer
     * @return McUser
     */
    public function setAnswer(\Inky\QuizBundle\Entity\Answer\mcAnswer $answer = null)
    {
        $this->answer = $answer;
    
        return $this;
    }

    /**
     * Get answer
     *
     * @return \Inky\QuizBundle\Entity\Answer\mcAnswer 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set question
     *
     * @param \Inky\QuizBundle\Entity\Question\mcQuestion $question
     * @return McUser
     */
    public function setQuestion(\Inky\QuizBundle\Entity\Question\mcQuestion $question = null)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return \Inky\QuizBundle\Entity\Question\mcQuestion 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set user
     *
     * @param \Inky\UserBundle\Entity\User $user
     * @return McUser
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