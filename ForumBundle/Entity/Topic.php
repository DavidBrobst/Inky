<?php

namespace Inky\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Topic
 *
 * @ORM\Table(name="forum_topic")
 * @ORM\Entity(repositoryClass="Inky\ForumBundle\Entity\TopicRepository")
 */
class Topic
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="cachedThreadNb", type="integer")
     */
    private $cachedThreadNb = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="cachedPostNb", type="integer")
     */
    private $cachedPostNb = 0;

	/**
	 * @ORM\ManyToOne(targetEntity="Inky\ForumBundle\Entity\Board",cascade={"persist"}, inversedBy="topic")
	 */
	private $board;
	
	/**
	 * @ORM\OneToMany(targetEntity="Inky\ForumBundle\Entity\Thread",cascade={"persist"}, mappedBy="topic")
	 */
	private $thread;
	
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
     * @return Topic
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
     * Set description
     *
     * @param string $description
     * @return Topic
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
     * Set cachedThreadNb
     *
     * @param integer $cachedThreadNb
     * @return Topic
     */
    public function setCachedThreadNb($cachedThreadNb)
    {
        $this->cachedThreadNb = $cachedThreadNb;
    
        return $this;
    }

    /**
     * Get cachedThreadNb
     *
     * @return integer 
     */
    public function getCachedThreadNb()
    {
        return $this->cachedThreadNb;
    }

    /**
     * Set cachedPostNb
     *
     * @param integer $cachedPostNb
     * @return Topic
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
     * Constructor
     */
    public function __construct()
    {
        $this->thread = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set board
     *
     * @param \Inky\ForumBundle\Entity\Board $board
     * @return Topic
     */
    public function setBoard(\Inky\ForumBundle\Entity\Board $board = null)
    {
        $this->board = $board;
    
        return $this;
    }

    /**
     * Get board
     *
     * @return \Inky\ForumBundle\Entity\Board 
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * Add thread
     *
     * @param \Inky\ForumBundle\Entity\Thread $thread
     * @return Topic
     */
    public function addThread(\Inky\ForumBundle\Entity\Thread $thread)
    {
        $this->thread[] = $thread;
    
        return $this;
    }

    /**
     * Remove thread
     *
     * @param \Inky\ForumBundle\Entity\Thread $thread
     */
    public function removeThread(\Inky\ForumBundle\Entity\Thread $thread)
    {
        $this->thread->removeElement($thread);
    }

    /**
     * Get thread
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set user
     *
     * @param \Inky\UserBundle\Entity\User $user
     * @return Topic
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