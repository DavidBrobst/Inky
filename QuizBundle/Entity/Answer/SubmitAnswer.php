<?php

namespace Inky\QuizBundle\Entity\Answer;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubmitAnswer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\QuizBundle\Entity\Answer\SubmitAnswerRepository")
 */
class SubmitAnswer
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
     * @ORM\ManyToOne(targetEntity="Inky\QuizBundle\Entity\Question\SubmitQuestion",cascade={"persist"}, inversedBy="answer")
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
     * Set content
     *
     * @param string $content
     * @return SubmitAnswer
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
     * Set question
     *
     * @param \Inky\QuizBundle\Entity\Question\SubmitQuestion $question
     * @return SubmitAnswer
     */
    public function setQuestion(\Inky\QuizBundle\Entity\Question\SubmitQuestion $question = null)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return \Inky\QuizBundle\Entity\Question\SubmitQuestion 
     */
    public function getQuestion()
    {
        return $this->question;
    }
}