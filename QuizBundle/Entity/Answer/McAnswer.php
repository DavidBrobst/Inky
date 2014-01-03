<?php

namespace Inky\QuizBundle\Entity\Answer;

use Doctrine\ORM\Mapping as ORM;

/**
 * McAnswer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\QuizBundle\Entity\Answer\McAnswerRepository")
 */
class McAnswer
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
     * @var boolean
     *
     * @ORM\Column(name="isRight", type="boolean")
     */
    private $isRight;

	/**
     * @ORM\ManyToOne(targetEntity="Inky\QuizBundle\Entity\Question\McQuestion",cascade={"persist"}, inversedBy="answer")
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
     * @param boolean $content
     * @return McAnswer
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return boolean 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set isRight
     *
     * @param boolean $isRight
     * @return McAnswer
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
     * @param \Inky\QuizBundle\Entity\Question\McQuestion $question
     * @return McAnswer
     */
    public function setQuestion(\Inky\QuizBundle\Entity\Question\McQuestion $question = null)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return \Inky\QuizBundle\Entity\Question\McQuestion 
     */
    public function getQuestion()
    {
        return $this->question;
    }
}