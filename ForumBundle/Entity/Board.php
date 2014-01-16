<?php

namespace Inky\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Board
 *
 * @ORM\Table(name="forum_board")
 * @ORM\Entity(repositoryClass="Inky\ForumBundle\Entity\BoardRepository")
 */
class Board
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

	/**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
     * @var integer
     *
     * @ORM\Column(name="cachedPostNb", type="integer")
     */
    private $cachedPostNb = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="cachedTopicNb", type="integer")
     */
    private $cachedTopicNb = 0;

	/**
	 * @ORM\OneToMany(targetEntity="Inky\ForumBundle\Entity\Topic",cascade={"persist"}, mappedBy="board")
	 */
	private $topic;
	
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
     * Set title
     *
     * @param string $title
     * @return Board
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

    /**
     * Set position
     *
     * @param integer $position
     * @return Board
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->topic = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add topic
     *
     * @param \Inky\ForumBundle\Entity\Topic $topic
     * @return Board
     */
    public function addTopic(\Inky\ForumBundle\Entity\Topic $topic)
    {
        $this->topic[] = $topic;
    
        return $this;
    }

    /**
     * Remove topic
     *
     * @param \Inky\ForumBundle\Entity\Topic $topic
     */
    public function removeTopic(\Inky\ForumBundle\Entity\Topic $topic)
    {
        $this->topic->removeElement($topic);
    }

    /**
     * Get topic
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set user
     *
     * @param \Inky\UserBundle\Entity\User $user
     * @return Board
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

    /**
     * Set description
     *
     * @param string $description
     * @return Board
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set cachedPostNb
     *
     * @param integer $cachedPostNb
     * @return Board
     */
    public function setCachedPostNb($cachedPostNb)
    {
        $this->cachedPostNb = $cachedPostNb;
    
        return $this;
    }

    /**
     * Get cachedPostNb
     *
     * @return integer 
     */
    public function getCachedPostNb()
    {
        return $this->cachedPostNb;
    }

    /**
     * Set cachedTopicNb
     *
     * @param integer $cachedTopicNb
     * @return Board
     */
    public function setCachedTopicNb($cachedTopicNb)
    {
        $this->cachedTopicNb = $cachedTopicNb;
    
        return $this;
    }

    /**
     * Get cachedTopicNb
     *
     * @return integer 
     */
    public function getCachedTopicNb()
    {
        return $this->cachedTopicNb;
    }
}