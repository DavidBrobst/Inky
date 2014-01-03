<?php

namespace Inky\QuizBundle\Entity\Answer;

use Doctrine\ORM\Mapping as ORM;

/**
 * InputAnswer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\QuizBundle\Entity\Answer\InputAnswerRepository")
 */
class InputAnswer
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
     * @ORM\Column(name="content", type="string", length=600)
     */
    private $content;

	/**
     * @ORM\ManyToOne(targetEntity="Inky\QuizBundle\Entity\Question\InputQuestion",cascade={"persist"}, inversedBy="answer")
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
     * @return InputAnswer
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
     * @param \Inky\QuizBundle\Entity\Question\InputQuestion $question
     * @return InputAnswer
     */
    public function setQuestion(\Inky\QuizBundle\Entity\Question\InputQuestion $question = null)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return \Inky\QuizBundle\Entity\Question\InputQuestion 
     */
    public function getQuestion()
    {
        return $this->question;
    }
}