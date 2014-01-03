<?php

namespace Inky\CourseBundle\Entity\InkyChap;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * InkyText
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\CourseBundle\Entity\InkyChap\InkyTextRepository")
 */
class InkyText
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
     * @ORM\Column(name="title", type="string")
	 * @Assert\Length(
     *      min = "5",
     *      max = "150",
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre nom ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $title;

	/**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

	/**
     * @ORM\ManyToOne(targetEntity="Inky\CourseBundle\Entity\InkyChap\InkyChap",cascade={"persist"})
     */
    private $inkyChap;

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
     * @return InkyText
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
     * Set InkyChap
     *
     * @param \Inky\CourseBundle\Entity\InkyChap\InkyChap $inkyChap
     * @return InkyText
     */
    public function setInkyChap(\Inky\CourseBundle\Entity\InkyChap\InkyChap $inkyChap = null)
    {
        $this->InkyChap = $inkyChap;
    
        return $this;
    }

    /**
     * Get InkyChap
     *
     * @return \Inky\CourseBundle\Entity\InkyChap\InkyChap 
     */
    public function getInkyChap()
    {
        return $this->InkyChap;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return InkyText
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
}