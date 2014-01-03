<?php

namespace Inky\CourseBundle\Entity\InkyChap;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * InkyVideo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inky\CourseBundle\Entity\InkyChap\InkyVideoRepository")
 */
class InkyVideo
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
     */
    private $title;


    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=100)
	 * @Assert\Url()
	 * @Assert\Length(
     *      min = "5",
     *      max = "100"
     * )
     */
    private $url;

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
     * Set url
     *
     * @param string $url
     * @return InkyVideo
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set InkyChap
     *
     * @param \Inky\CourseBundle\Entity\InkyChap\InkyChap $inkyChap
     * @return InkyVideo
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
     * @return InkyVideo
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